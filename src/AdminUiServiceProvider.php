<?php

namespace ReusableAdminUi;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class AdminUiServiceProvider extends ServiceProvider
{
    private const SUPPORTED_THEMES = ['light'];

    private const SUPPORTED_SIDEBAR_PRESETS = ['classic', 'compact', 'modern'];

    private const SUPPORTED_LOGIN_PRESETS = ['v1', 'v2', 'v3', 'v4', 'split'];

    public function register(): void
    {
        $packageConfig = require __DIR__ . '/../config/admin-ui.php';

        $this->mergeConfigFrom(__DIR__ . '/../config/admin-ui.php', 'admin-ui');

        // Laravel's mergeConfigFrom() only merges the top-level config array.
        // Since the host normally overrides parts of `auth`, merge that nested
        // configuration recursively so package defaults such as registration
        // and forgot-password remain available.
        $applicationAuth = config('admin-ui.auth', []);
        $mergedAuth = $this->mergeConfigArrays(
            $packageConfig['auth'] ?? [],
            $applicationAuth
        );

        // Migrate only exact legacy package defaults from previously published host configs.
        $mergedAuth = $this->normalizeLegacyAuthViteEntries($mergedAuth);

        config()->set('admin-ui.auth', $mergedAuth);
    }

    /**
     * Normalize the package's former dedicated auth entry points.
     *
     * Published host configs survive Composer upgrades. Only exact historical
     * package defaults are migrated; custom host entry points are preserved.
     *
     * @param array<string|int, mixed> $auth
     * @return array<string|int, mixed>
     */
    private function normalizeLegacyAuthViteEntries(array $auth): array
    {
        // Migrate known published defaults while preserving custom Host overrides.
        $migrations = [
            'vite.css' => [
                ['resources/css/app.css', 'resources/css/auth-login-v1.css'],
                ['resources/css/app.css', 'resources/css/pages/auth/login.css'],
            ],
            'vite.js' => [
                ['resources/js/app.js', 'resources/js/pages/LoginPage.js'],
                ['resources/js/app.js', 'resources/js/pages/LoginPage.js'],
            ],
            'registration.vite.css' => [
                ['resources/css/app.css'],
                ['resources/css/app.css', 'resources/css/pages/auth/register.css'],
            ],
            'registration.vite.js' => [
                ['resources/js/app.js', 'resources/js/pages/LoginPage.js'],
                ['resources/js/app.js', 'resources/js/pages/RegisterPage.js'],
            ],
            'forgot_password.vite.css' => [
                ['resources/css/app.css'],
                ['resources/css/app.css', 'resources/css/pages/auth/forgot-password.css'],
            ],
            'forgot_password.vite.js' => [
                ['resources/js/app.js'],
                ['resources/js/app.js', 'resources/js/pages/ForgotPasswordPage.js'],
            ],
        ];

        foreach ($migrations as $key => [$legacyPaths, $newPaths]) {
            $configured = data_get($auth, $key);

            if (is_string($configured) && in_array($configured, $legacyPaths, true)) {
                data_set($auth, $key, $newPaths);
            }
        }

        return $auth;
    }

    /**
     * Merge associative configuration recursively while replacing list arrays.
     * This lets a host replace a feature list without inheriting extra items.
     *
     * @param array<string|int, mixed> $defaults
     * @param array<string|int, mixed> $overrides
     * @return array<string|int, mixed>
     */
    private function mergeConfigArrays(array $defaults, array $overrides): array
    {
        if (array_is_list($defaults) || array_is_list($overrides)) {
            return $overrides;
        }

        foreach ($overrides as $key => $value) {
            if (
                is_array($value)
                && isset($defaults[$key])
                && is_array($defaults[$key])
                && ! array_is_list($value)
                && ! array_is_list($defaults[$key])
            ) {
                $defaults[$key] = $this->mergeConfigArrays($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin-ui');
        Blade::anonymousComponentPath(__DIR__ . '/../resources/views/components', 'admin-ui');

        $this->publishes([
            __DIR__ . '/../config/admin-ui.php' => config_path('admin-ui.php'),
        ], 'admin-ui-config');

        // Publish the complete package-owned frontend assets into the Host
        // Application source tree. The Host's existing Vite setup compiles
        // these local copies; the package itself has no build-step dependency.
        $this->publishes([
            __DIR__ . '/../resources/css' => resource_path('css/vendor/admin-ui'),
            __DIR__ . '/../resources/js' => resource_path('js/vendor/admin-ui'),
            __DIR__ . '/../resources/gif' => public_path('vendor/admin-ui/gif'),
        ], 'admin-ui-assets');

        // A starter LoginPage.js is copied into the host application so the
        // developer can add their own authentication implementation there.
        $this->publishes([
            __DIR__ . '/../resources/stubs/LoginPage.js' => resource_path('js/pages/LoginPage.js'),
            __DIR__ . '/../resources/stubs/RegisterPage.js' => resource_path('js/pages/RegisterPage.js'),
            __DIR__ . '/../resources/stubs/ForgotPasswordPage.js' => resource_path('js/pages/ForgotPasswordPage.js'),
            __DIR__ . '/../resources/stubs/css/login.css' => resource_path('css/pages/auth/login.css'),
            __DIR__ . '/../resources/stubs/css/register.css' => resource_path('css/pages/auth/register.css'),
            __DIR__ . '/../resources/stubs/css/forgot-password.css' => resource_path('css/pages/auth/forgot-password.css'),
        ], 'admin-ui-auth');

        // Shared page foundation and browser-location service used by Host pages.
        // Publish them into the Host source tree so Vite can compile them as
        // ordinary local ES modules without requiring a package build pipeline.
        $coreAssets = [
            __DIR__ . '/../resources/js/core/BasePage.js' => resource_path('js/vendor/admin-ui/core/BasePage.js'),
            __DIR__ . '/../resources/js/core/Toast.js' => resource_path('js/vendor/admin-ui/core/Toast.js'),
            __DIR__ . '/../resources/js/core/LocationManager.js' => resource_path('js/vendor/admin-ui/core/LocationManager.js'),
            __DIR__ . '/../resources/js/core/LocationAwarePage.js' => resource_path('js/vendor/admin-ui/core/LocationAwarePage.js'),
            __DIR__ . '/../resources/js/core/Validation.js' => resource_path('js/vendor/admin-ui/core/Validation.js'),
            __DIR__ . '/../resources/js/core/Loader.js' => resource_path('js/vendor/admin-ui/core/Loader.js'),
            __DIR__ . '/../resources/js/core/api' => resource_path('js/vendor/admin-ui/core/api'),
            __DIR__ . '/../resources/js/dialogs/StatusDialog.js' => resource_path('js/vendor/admin-ui/dialogs/StatusDialog.js'),
            __DIR__ . '/../resources/js/dialogs/OtpManager.js' => resource_path('js/vendor/admin-ui/dialogs/OtpManager.js'),
            __DIR__ . '/../resources/css/components/status-dialog.css' => resource_path('css/vendor/admin-ui/status-dialog.css'),
            __DIR__ . '/../resources/css/components/toast.css' => resource_path('css/vendor/admin-ui/components/toast.css'),
            __DIR__ . '/../resources/css/components/loader.css' => resource_path('css/vendor/admin-ui/components/loader.css'),
            __DIR__ . '/../resources/css/components/otp-dialog.css' => resource_path('css/vendor/admin-ui/otp-dialog.css'),
            __DIR__ . '/../resources/js/inputs/PinInput.js' => resource_path('js/vendor/admin-ui/inputs/PinInput.js'),
            __DIR__ . '/../resources/js/components/Pagination.js' => resource_path('js/vendor/admin-ui/components/Pagination.js'),
            __DIR__ . '/../resources/css/components/pin-input.css' => resource_path('css/vendor/admin-ui/pin-input.css'),
            __DIR__ . '/../resources/css/components/pagination.css' => resource_path('css/vendor/admin-ui/pagination.css'),
            __DIR__ . '/../resources/js/components/Offcanvas.js' => resource_path('js/vendor/admin-ui/components/Offcanvas.js'),
            __DIR__ . '/../resources/css/components/offcanvas.css' => resource_path('css/vendor/admin-ui/offcanvas.css'),
        ];

        // BasePage imports StatusDialog, so all shared runtime dependencies are
        // published together as one complete Core set. The narrower dialog tag
        // is also available for developers who only need to refresh this UI.
        $this->publishes($coreAssets, 'admin-ui-core');

        // Status dialog GIFs are package-owned assets; publish them alongside
        // the dialog so Host applications do not need to manage image paths.
        $this->publishes([
            __DIR__ . '/../resources/gif/status-dialog' => public_path('vendor/admin-ui/gif/status-dialog'),
        ], 'admin-ui-core');
        $this->publishes([
            __DIR__ . '/../resources/js/dialogs/StatusDialog.js' => resource_path('js/vendor/admin-ui/dialogs/StatusDialog.js'),
            __DIR__ . '/../resources/css/components/status-dialog.css' => resource_path('css/vendor/admin-ui/status-dialog.css'),
        ], 'admin-ui-dialogs');

        $this->publishes([
            __DIR__ . '/../resources/js/dialogs/OtpManager.js' => resource_path('js/vendor/admin-ui/dialogs/OtpManager.js'),
            __DIR__ . '/../resources/css/components/otp-dialog.css' => resource_path('css/vendor/admin-ui/otp-dialog.css'),
        ], 'admin-ui-otp-dialog');

        $this->publishes([
            __DIR__ . '/../resources/js/inputs/PinInput.js' => resource_path('js/vendor/admin-ui/inputs/PinInput.js'),
            __DIR__ . '/../resources/css/components/pin-input.css' => resource_path('css/vendor/admin-ui/pin-input.css'),
        ], 'admin-ui-inputs');

        $this->publishes([
            __DIR__ . '/../resources/js/components/Pagination.js' => resource_path('js/vendor/admin-ui/components/Pagination.js'),
            __DIR__ . '/../resources/css/components/pagination.css' => resource_path('css/vendor/admin-ui/pagination.css'),
        ], 'admin-ui-pagination');

        $this->publishes([
            __DIR__ . '/../resources/js/components/Offcanvas.js' => resource_path('js/vendor/admin-ui/components/Offcanvas.js'),
            __DIR__ . '/../resources/css/components/offcanvas.css' => resource_path('css/vendor/admin-ui/offcanvas.css'),
        ], 'admin-ui-offcanvas');

        $this->validatePreset('theme.default', self::SUPPORTED_THEMES);
        $this->validatePreset('layout.sidebar', self::SUPPORTED_SIDEBAR_PRESETS);
        $this->validatePreset('auth.login', self::SUPPORTED_LOGIN_PRESETS);

        $this->registerLoginRoute();
        $this->registerRegistrationRoute();
        $this->registerForgotPasswordRoute();
    }

    /**
     * Build middleware for package-owned authentication presentation routes.
     *
     * The host may replace Laravel's default guest middleware with its own
     * middleware class (or list), or set the value to null/false to disable it.
     *
     * @param array<int, string>|string|false|null $routeMiddleware
     * @return array<int, string>
     */
    private function authRouteMiddleware(array|string|false|null $routeMiddleware): array
    {
        $middleware = is_array($routeMiddleware)
            ? $routeMiddleware
            : (is_string($routeMiddleware) ? [$routeMiddleware] : []);

        $guestMiddleware = config('admin-ui.auth.guest_middleware', 'guest');

        if (is_string($guestMiddleware) && $guestMiddleware !== '') {
            $middleware[] = $guestMiddleware;
        } elseif (is_array($guestMiddleware)) {
            $middleware = array_merge($middleware, $guestMiddleware);
        }

        return array_values(array_unique($middleware));
    }

    private function registerLoginRoute(): void
    {
        if (! config('admin-ui.auth.route.enabled', true)) {
            return;
        }

        $path = config('admin-ui.auth.route.path', '/login');
        $name = config('admin-ui.auth.route.name', 'admin-ui.login');
        $middleware = $this->authRouteMiddleware(config('admin-ui.auth.route.middleware', ['web']));
        $variant = config('admin-ui.auth.login', 'v1');
        // `split` was the previous name for the V1 split-screen presentation.
        $variant = $variant === 'split' ? 'v1' : $variant;

        // All variants intentionally render the same Blade structure. The
        // selected value changes presentation/configuration, not form hooks.
        Route::get($path, function () use ($variant) {
            return view('admin-ui::auth.login.v1', [
                'loginVariant' => $variant,
            ]);
        })
            ->middleware($middleware)
            ->name($name);
    }

    private function registerRegistrationRoute(): void
    {
        $config = config('admin-ui.auth.registration', []);
        if (! ($config['enabled'] ?? true) || ! ($config['route']['enabled'] ?? true)) return;
        $variant = $config['variant'] ?? 'v1';
        if (! in_array($variant, ['v1', 'v2', 'v3'], true)) {
            throw new InvalidArgumentException('Unsupported admin-ui.auth.registration.variant. Supported values: v1, v2, v3.');
        }
        $middleware = $this->authRouteMiddleware($config['route']['middleware'] ?? ['web']);
        Route::get($config['route']['path'] ?? '/register', function () use ($variant) {
            return view('admin-ui::auth.register.v1', ['registrationVariant' => $variant]);
        })->middleware($middleware)
          ->name($config['route']['name'] ?? 'admin-ui.register');
    }

    private function registerForgotPasswordRoute(): void
    {
        $config = config('admin-ui.auth.forgot_password', []);
        if (! ($config['enabled'] ?? true) || ! ($config['route']['enabled'] ?? true)) return;
        $middleware = $this->authRouteMiddleware($config['route']['middleware'] ?? ['web']);
        Route::get($config['route']['path'] ?? '/forgot-password', function () {
            return view('admin-ui::auth.forgot-password');
        })->middleware($middleware)
          ->name($config['route']['name'] ?? 'admin-ui.forgot-password');
    }

    /**
     * Fail early with a useful message when a named design preset is misspelled.
     *
     * @param array<int, string> $supported
     */
    private function validatePreset(string $key, array $supported): void
    {
        $selected = config("admin-ui.{$key}");

        if (! in_array($selected, $supported, true)) {
            throw new InvalidArgumentException(sprintf(
                'Unsupported admin-ui.%s preset "%s". Supported values: %s.',
                $key,
                is_scalar($selected) ? (string) $selected : get_debug_type($selected),
                implode(', ', $supported),
            ));
        }
    }
}
