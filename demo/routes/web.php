<?php

    use Illuminate\Support\Facades\Route;

// Header integration demo: Controller -> Blade initial data -> JS live update.
    use App\Http\Controllers\Admin\HeaderDemoController;

    Route::get('/', [HeaderDemoController::class, 'index'])->name('home');

// Local-only demo routes for testing the shared admin layout.
    Route::prefix('admin/demo')->name('admin.demo.')->group(function () {
        Route::view('/dashboard', 'admin-demo.dashboard')
            ->name('dashboard');

        Route::view('/customers', 'admin-demo.page', [
            'pageTitle'       => 'All Customers',
            'pageDescription' => 'Blank customers page for testing nested navigation.',
        ])->name('customers');

        Route::view('/contacts', 'admin-demo.page', [
            'pageTitle'       => 'Contacts',
            'pageDescription' => 'Blank contacts page for testing nested navigation.',
        ])->name('contacts');

        Route::view('/conversations', 'admin-demo.page', [
            'pageTitle'       => 'All Conversations',
            'pageDescription' => 'Blank conversations page for testing the Inbox submenu.',
        ])->name('conversations');

        Route::view('/automations', 'admin-demo.page', [
            'pageTitle'       => 'Automations',
            'pageDescription' => 'Blank automations page for testing direct navigation.',
        ])->name('automations');

        Route::view('/settings', 'admin-demo.page', [
            'pageTitle'       => 'Settings',
            'pageDescription' => 'Blank settings page for testing navigation across sections.',
        ])->name('settings');
    });
    Route::view('/admin-ui/components', 'admin-ui::pages.component-variants')
        ->name('admin-ui.components');
    Route::view('/admin-ui/buttons', 'admin-ui::pages.buttons')
        ->name('admin-ui.buttons');
    Route::view('/admin-ui/form-inputs', 'admin-ui::pages.form-inputs')
        ->name('admin-ui.form-inputs');
    Route::view('/admin-ui/input-groups', 'admin-ui::pages.input-groups')
        ->name('admin-ui.input-groups');
    Route::view('/admin-ui/tags-pills', 'admin-ui::pages.tags-pills')
        ->name('admin-ui.tags-pills');
    Route::view('/admin-ui/radio-checkbox', 'admin-ui::pages.radio-checkbox')
        ->name('admin-ui.radio-checkbox');
    Route::view('/admin-ui/dropdowns', 'admin-ui::pages.dropdowns')
        ->name('admin-ui.dropdowns');

    Route::view('/admin-ui/test-input-pagination', 'admin-ui-input-pagination-test')
        ->name('admin-ui.test-input-pagination');

    Route::view('/admin-ui/accordions', 'admin-ui::pages.accordions')
        ->name('admin-ui.accordions');
    Route::view('/admin-ui/lists', 'admin-ui::pages.lists')
        ->name('admin-ui.lists');
    Route::view(
        '/admin-ui/statistics-cards',
        'admin-ui::pages.statistics-cards'
    )->name('admin-ui.statistics-cards');
    Route::view(
        '/admin-ui/tables',
        'admin-ui::pages.tables'
    );

    // Login design previews. These routes render the package's shared login
    // markup with per-variant configuration and never submit real credentials.
    Route::view('/admin-ui/auth', 'auth-login-demos')
        ->name('admin-ui.auth.demos');

    foreach (['v1', 'v2', 'v3', 'v4'] as $loginVariant) {
        Route::get('/admin-ui/auth/login-' . $loginVariant, function () use ($loginVariant) {
            return view('admin-ui::auth.login.v1', [
                'loginVariant' => $loginVariant,
                'demoMode' => true,
            ]);
        })->name('admin-ui.auth.login-' . $loginVariant);
    }


// Registration and password-reset visual previews. Demo mode never submits credentials.
Route::view('/admin-ui/auth/registration', 'auth-register-demos')->name('admin-ui.auth.registration-demos');
foreach (['v1', 'v2', 'v3'] as $registrationVariant) {
    Route::get('/admin-ui/auth/register-' . $registrationVariant, function () use ($registrationVariant) {
        return view('admin-ui::auth.register.v1', ['registrationVariant' => $registrationVariant, 'demoMode' => true]);
    })->name('admin-ui.auth.register-' . $registrationVariant);
}
Route::get('/admin-ui/auth/forgot-password', function () {
    return view('admin-ui::auth.forgot-password', ['demoMode' => true]);
})->name('admin-ui.auth.forgot-password-demo');

// Local-only interactive demo for the shared Right Offcanvas component.
Route::view('/admin-ui/offcanvas-demo', 'admin-ui-offcanvas-demo')
    ->name('admin-ui.offcanvas-demo');
