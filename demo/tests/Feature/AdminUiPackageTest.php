<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminUiPackageTest extends TestCase
{
    public function test_demo_page_renders_the_ui_shell_and_named_components(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Overview');
        $response->assertSee('Revenue overview');
        $response->assertSee('Recent activity');
        $response->assertSee('data-rai-theme="light"', false);
        $response->assertSee('data-rai-sidebar-toggle', false);
        $response->assertSee('data-rai-sidebar-close', false);
    }

    public function test_header_renders_configured_information_cards_and_action_hooks(): void
    {
        config()->set('admin-ui.header.components.notifications', true);
        config()->set('admin-ui.header.info_cards.cards.wallet_balance.enabled', true);

        $response = $this->view('admin-ui::components.header', [
            'title' => 'Dashboard',
            'cardData' => ['wallet_balance' => ['value' => 1250]],
        ]);

        $response->assertSee('data-rai-header-action="notifications"', false);
        $response->assertSee('data-rai-info-card="wallet_balance"', false);
        $response->assertSee('Prepaid Balance');
        $response->assertSee('1250');
        $response->assertDontSee('data-rai-notification-menu', false);
    }

    public function test_application_configuration_uses_selected_defaults(): void
    {
        $this->assertSame('light', config('admin-ui.theme.default'));
        $this->assertSame('modern', config('admin-ui.layout.sidebar'));
        $this->assertSame('v1', config('admin-ui.auth.login'));
        $this->assertArrayHasKey('v1', config('admin-ui.auth.variants'));
        $this->assertArrayHasKey('v2', config('admin-ui.auth.variants'));
        $this->assertArrayHasKey('v3', config('admin-ui.auth.variants'));
        $this->assertArrayHasKey('v4', config('admin-ui.auth.variants'));
    }

    public function test_published_auth_starter_resolves_the_shared_base_page_module(): void
    {
        $basePage = resource_path('js/vendor/admin-ui/core/BasePage.js');
        $loginStarter = resource_path('js/pages/LoginPage.js');
        $registerStarter = resource_path('js/pages/RegisterPage.js');
        $forgotPasswordStarter = resource_path('js/pages/ForgotPasswordPage.js');

        $this->assertFileExists($basePage, 'Publish the admin-ui-core tag before running this test.');

        foreach ([$loginStarter, $registerStarter, $forgotPasswordStarter] as $starter) {
            $this->assertFileExists($starter, 'Publish the admin-ui-auth tag before running this test.');
            $source = file_get_contents($starter);
            $this->assertIsString($source);
            $this->assertStringContainsString(
                "from '../vendor/admin-ui/core/BasePage.js';",
                $source
            );
        }
    }

}
