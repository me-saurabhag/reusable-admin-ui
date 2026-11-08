<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardComponentsTest extends TestCase
{
    public function test_admin_demo_dashboard_displays_all_new_dashboard_components(): void
    {
        $response = $this->get('/admin/demo/dashboard');

        $response->assertOk();
        $response->assertSee('Welcome back, Alex!');
        $response->assertSee('WhatsApp Accounts');
        $response->assertSee('Total Contacts');
        $response->assertSee('Messaging Activity');
        $response->assertSee('Conversation &amp; Automation Health', false);
        $response->assertSee('Open Support Tickets');
    }

    public function test_dashboard_hero_section_renders_host_supplied_content_and_stats(): void
    {
        $response = $this->view('admin-ui::components.dashboard-hero-section', [
            'title' => 'Welcome back, Demo User',
            'subtitle' => 'Dashboard summary',
            'refreshedAt' => 'Updated just now',
            'date' => 'Sunday, November 8, 2026',
            'stats' => [
                ['label' => 'Messages Received', 'value' => '120'],
                ['label' => 'Active Conversations', 'value' => '8', 'indicator' => true],
            ],
        ]);

        $response->assertSee('Welcome back, Demo User');
        $response->assertSee('Updated just now');
        $response->assertSee('Messages Received');
        $response->assertSee('120');
        $response->assertSee('rai-dashboard-hero__indicator', false);
    }

    public function test_messaging_activity_chart_renders_svg_series_and_totals(): void
    {
        $response = $this->view('admin-ui::components.messaging-activity-chart', [
            'activity' => [
                'period_label' => 'Last 7 days',
                'labels' => ['Mon', 'Tue', 'Wed'],
                'incoming' => [10, 20, 30],
                'outgoing' => [5, 15, 25],
                'incoming_total' => 60,
                'outgoing_total' => 45,
            ],
        ]);

        $response->assertSee('Messaging Activity');
        $response->assertSee('Last 7 days');
        $response->assertSee('Mon');
        $response->assertSee('rai-messaging-chart__line--incoming', false);
        $response->assertSee('rai-messaging-chart__line--outgoing', false);
        $response->assertSee('60');
        $response->assertSee('45');
    }

    public function test_conversation_automation_health_renders_supplied_metrics(): void
    {
        $response = $this->view('admin-ui::components.conversation-automation-health', [
            'activeConversations' => 18,
            'unassignedConversations' => 3,
            'automationSuccessPercent' => 98.5,
            'failedRunsToday' => 2,
        ]);

        $response->assertSee('Conversation &amp; Automation Health', false);
        $response->assertSee('18');
        $response->assertSee('3');
        $response->assertSee('98.5%');
        $response->assertSee('2');
    }

    public function test_dashboard_stat_card_variant_renders_icon_sprite_and_footer_values(): void
    {
        $response = $this->view('admin-ui::components.stat-card', [
            'variant' => 'dashboard',
            'title' => 'WhatsApp Accounts',
            'value' => '12',
            'icon' => 'stroke-mobile',
            'trend' => '8 connected',
            'trendVariant' => 'neutral',
            'primaryLabel' => 'Connected',
            'primaryValue' => '8 accounts',
            'secondaryLabel' => 'Disconnected',
            'secondaryValue' => '4 accounts',
        ]);

        $response->assertSee('WhatsApp Accounts');
        $response->assertSee('href="#stroke-mobile"', false);
        $response->assertSee('8 connected');
        $response->assertSee('8 accounts');
        $response->assertSee('4 accounts');
    }

    public function test_login_feature_icons_are_sprite_names_not_inline_svg(): void
    {
        $featureSets = [config('admin-ui.auth.login_page.features', [])];
        foreach (['v2', 'v3'] as $variant) {
            $featureSets[] = config("admin-ui.auth.variants.{$variant}.login_page.features", []);
        }

        foreach ($featureSets as $features) {

            foreach ($features as $feature) {
                $this->assertIsString($feature['icon'] ?? null);
                $this->assertMatchesRegularExpression('/^[a-z0-9-]+$/', $feature['icon']);
            }
        }
    }
}
