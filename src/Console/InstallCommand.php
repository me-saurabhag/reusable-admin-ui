<?php

namespace ReusableAdminUi\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'admin-ui:install
        {--force : Overwrite previously published package files}';

    protected $description = 'Publish Reusable Admin UI assets and configure Vite entry points.';

    private array $publishTags = [
        'admin-ui-config',
        'admin-ui-assets',
        'admin-ui-core',
        'admin-ui-auth',
    ];

    /**
     * Keep each page's CSS and JavaScript as an independent Vite entry.
     *
     * @var array<int, string>
     */
    private array $viteEntries = [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/pages/auth/login.css',
        'resources/js/pages/LoginPage.js',
        'resources/css/pages/auth/register.css',
        'resources/js/pages/RegisterPage.js',
        'resources/css/pages/auth/forgot-password.css',
        'resources/js/pages/ForgotPasswordPage.js',
    ];

    public function handle(): int
    {
        $this->info('Installing Reusable Admin UI assets...');

        foreach ($this->publishTags as $tag) {
            $options = ['--tag' => $tag];

            // Config and Host-owned starter entry files are never force-overwritten.
            // --force refreshes only package-managed asset copies under vendor/admin-ui.
            if ($this->option('force') && ! in_array($tag, ['admin-ui-config', 'admin-ui-auth'], true)) {
                $options['--force'] = true;
            }

            if ($this->call('vendor:publish', $options) !== self::SUCCESS) {
                $this->error("Publishing [{$tag}] failed.");
                return self::FAILURE;
            }
        }

        if (! $this->registerGlobalStyles() || ! $this->registerGlobalRuntime() || ! $this->updateViteConfig()) {
            $this->error('Assets were published, but frontend integration needs attention. See the messages above.');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Reusable Admin UI installation completed.');
        $this->line('Next, run: <fg=yellow>npm install bootstrap</>');
        $this->line('Then run: <fg=yellow>npm run build</>');
        $this->line('Bootstrap and Admin UI global CSS imports were added to resources/css/app.css.');
        $this->line('Login, Registration, and Forgot Password include OTP and Status dialogs. Post-login pages opt in per page.');

        return self::SUCCESS;
    }

    /**
     * Register Bootstrap and package-wide styles in the Host global CSS entry.
     * Existing Tailwind directives and Host styles are preserved; imports are
     * inserted once, before CSS directives such as @source and @theme.
     */
    private function registerGlobalStyles(): bool
    {
        $appCssPath = resource_path('css/app.css');

        if (! is_file($appCssPath) || ! is_readable($appCssPath)) {
            $this->error('Could not find resources/css/app.css. Create the standard Laravel Vite CSS entry first.');
            return false;
        }

        $contents = file_get_contents($appCssPath);

        if ($contents === false) {
            $this->error('Could not read resources/css/app.css.');
            return false;
        }

        $imports = [
            '@import "bootstrap/dist/css/bootstrap.min.css";',
            "@import './vendor/admin-ui/admin-ui.css';",
            "@import './vendor/admin-ui/sidebar-logo.css';",
            "@import './vendor/admin-ui/sidebar-variants.css';",
            "@import './vendor/admin-ui/main-header-alignment.css';",
            "@import './vendor/admin-ui/components/toast.css';",
            "@import './vendor/admin-ui/components/loader.css';",
        ];

        $missingImports = [];

        foreach ($imports as $import) {
            $path = preg_quote(trim(substr($import, 7), " \\t\\n\\r;\\\"'"), '/');

            if (! preg_match('/@import\\s+[\\\'"]' . $path . '[\\\'"]\\s*;/', $contents)) {
                $missingImports[] = $import;
            }
        }

        if ($missingImports === []) {
            $this->line('Bootstrap and Admin UI global CSS imports are already registered in app.css.');
            return true;
        }

        $addition = implode("\\n", $missingImports) . "\\n\\n";

        // Keep Tailwind's entry first when the Laravel starter uses Tailwind.
        if (preg_match('/@import\\s+[\\\'"]tailwindcss[\\\'"]\\s*;/', $contents, $match, PREG_OFFSET_CAPTURE)) {
            $offset = $match[0][1] + strlen($match[0][0]);
            $updated = substr($contents, 0, $offset) . "\\n" . $addition . ltrim(substr($contents, $offset), "\\r\\n");
        } else {
            $updated = $addition . ltrim($contents, "\\r\\n");
        }

        if (file_put_contents($appCssPath, $updated) === false) {
            $this->error('Could not update resources/css/app.css. Check file permissions.');
            return false;
        }

        $this->info('Registered Bootstrap and Admin UI global CSS imports in resources/css/app.css.');

        return true;
    }

    /**
     * The package's global runtime handles shared shell interactions only.
     * It does not import page modules, dialogs, or the API client.
     */
    private function registerGlobalRuntime(): bool
    {
        $appJsPath = resource_path('js/app.js');

        if (! is_file($appJsPath) || ! is_readable($appJsPath)) {
            $this->error('Could not find resources/js/app.js. Create the standard Laravel Vite entry first.');
            return false;
        }

        $contents = file_get_contents($appJsPath);

        if ($contents === false) {
            $this->error('Could not read resources/js/app.js.');
            return false;
        }

        $runtimeImport = "import './vendor/admin-ui/admin-ui.js';";

        if (preg_match('/import\\s+[\'\"]\\.\\/vendor\\/admin-ui\\/admin-ui\\.js[\'\"]\\s*;?/', $contents)) {
            $this->line('Global Admin UI runtime is already imported by app.js.');
            return true;
        }

        $updated = rtrim($contents) . "\n\n// Reusable Admin UI shared shell runtime.\n" . $runtimeImport . "\n";

        if (file_put_contents($appJsPath, $updated) === false) {
            $this->error('Could not update resources/js/app.js. Check file permissions.');
            return false;
        }

        $this->info('Registered the shared Admin UI runtime in resources/js/app.js.');

        return true;
    }

    /**
     * Add missing entries to Laravel's conventional Vite input array.
     * Existing project entries and Vite plugins are preserved.
     */
    private function updateViteConfig(): bool
    {
        $viteConfigPath = base_path('vite.config.js');

        if (! is_file($viteConfigPath) || ! is_readable($viteConfigPath)) {
            $this->error('Could not find a readable vite.config.js in the Laravel project root.');
            return false;
        }

        $contents = file_get_contents($viteConfigPath);

        if ($contents === false) {
            $this->error('Could not read vite.config.js.');
            return false;
        }

        if (! preg_match('/(\binput\s*:\s*\[)([\s\S]*?)(\])/', $contents, $matches, PREG_OFFSET_CAPTURE)) {
            $this->error('Could not locate the standard input: [ ... ] array in vite.config.js.');
            return false;
        }

        $entries = $matches[2][0];
        $missingEntries = [];

        foreach ($this->viteEntries as $entry) {
            $quotedEntry = preg_quote($entry, '/');

            if (! preg_match('/[\'"]' . $quotedEntry . '[\'"]/', $entries)) {
                $missingEntries[] = $entry;
            }
        }

        if ($missingEntries === []) {
            $this->line('Vite already contains all required Admin UI entries.');
            return true;
        }

        $closingBracketOffset = $matches[3][1];
        $beforeClosingBracket = substr($contents, 0, $closingBracketOffset);
        $trimmedBeforeClosingBracket = rtrim($beforeClosingBracket);
        $needsComma = $trimmedBeforeClosingBracket !== ''
            && ! str_ends_with($trimmedBeforeClosingBracket, ',');

        $addition = $needsComma ? ',' : '';
        $addition .= "\n                // Reusable Admin UI page entries";

        foreach ($missingEntries as $entry) {
            $addition .= "\n                '" . $entry . "',";
        }

        $addition .= "\n            ";

        $updated = $trimmedBeforeClosingBracket
            . $addition
            . substr($contents, $closingBracketOffset);

        if (file_put_contents($viteConfigPath, $updated) === false) {
            $this->error('Could not update vite.config.js. Check file permissions.');
            return false;
        }

        $this->info('Added ' . count($missingEntries) . ' missing Vite entr' . (count($missingEntries) === 1 ? 'y' : 'ies') . '.');

        return true;
    }
}
