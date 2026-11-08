{{-- Copy this menu array into your host Blade page to test the Classic Sidebar. --}}
@php
    $menu = [
        [
            'label' => 'WORKSPACE',
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'default', 'url' => '/admin/dashboard', 'active' => true],
                ['label' => 'Analytics', 'icon' => 'default', 'url' => '/admin/analytics'],
                ['label' => 'Reports', 'icon' => 'default', 'url' => '/admin/reports'],
            ],
        ],
        [
            'label' => 'CUSTOMER MANAGEMENT',
            'items' => [
                ['label' => 'All Customers', 'icon' => 'default', 'url' => '/admin/customers'],
                ['label' => 'Add Customer', 'icon' => 'default', 'url' => '/admin/customers/create'],
                ['label' => 'Customer Groups', 'icon' => 'default', 'url' => '/admin/customer-groups'],
                ['label' => 'Import Customers', 'icon' => 'default', 'url' => '/admin/customers/import'],
            ],
        ],
        [
            'label' => 'MESSAGING',
            'items' => [
                ['label' => 'Inbox', 'icon' => 'default', 'url' => '/admin/messages'],
                ['label' => 'Campaigns', 'icon' => 'default', 'url' => '/admin/campaigns'],
                ['label' => 'Message Templates', 'icon' => 'default', 'url' => '/admin/message-templates'],
                [
                    'label' => 'WhatsApp Accounts',
                    'icon' => 'default',
                    'children' => [
                        ['label' => 'All Accounts', 'icon' => 'default', 'url' => '/admin/whatsapp-accounts'],
                        ['label' => 'Connect Account', 'icon' => 'default', 'url' => '/admin/whatsapp-accounts/create'],
                        ['label' => 'Session History', 'icon' => 'default', 'url' => '/admin/whatsapp-accounts/sessions'],
                        ['label' => 'Webhooks', 'icon' => 'default', 'url' => '/admin/whatsapp-accounts/webhooks'],
                    ],
                ],
                [
                    'label' => 'Automation',
                    'icon' => 'default',
                    'children' => [
                        ['label' => 'Workflows', 'icon' => 'default', 'url' => '/admin/automation/workflows'],
                        ['label' => 'Rules', 'icon' => 'default', 'url' => '/admin/automation/rules'],
                        ['label' => 'Execution Logs', 'icon' => 'default', 'url' => '/admin/automation/logs'],
                    ],
                ],
            ],
        ],
        [
            'label' => 'COMPANY',
            'items' => [
                ['label' => 'Team Members', 'icon' => 'default', 'url' => '/admin/team'],
                ['label' => 'Roles & Permissions', 'icon' => 'default', 'url' => '/admin/roles'],
                ['label' => 'Billing', 'icon' => 'default', 'url' => '/admin/billing'],
            ],
        ],
        [
            'label' => 'PREFERENCES',
            'items' => [
                ['label' => 'Notifications', 'icon' => 'default', 'url' => '/admin/notifications'],
                ['label' => 'Profile Settings', 'icon' => 'default', 'url' => '/admin/profile'],
                ['label' => 'Security', 'icon' => 'default', 'url' => '/admin/security'],
                ['label' => 'System Settings', 'icon' => 'default', 'url' => '/admin/settings'],
            ],
        ],
    ];
@endphp

<x-admin-ui::layout title="Sidebar Menu Test">
    <x-slot:sidebar>
        <x-admin-ui::sidebar :sections="$menu" />
    </x-slot:sidebar>

    <x-slot:header>
        <div class="rai-ui__header-start">
            <button type="button" class="rai-ui__icon-button" data-rai-sidebar-toggle aria-label="Toggle sidebar" aria-expanded="false">
                <span aria-hidden="true">☰</span>
            </button>
            <h1 class="rai-ui__header-title">Sidebar Menu Test</h1>
        </div>
    </x-slot:header>

    <div class="rai-page-heading">
        <div>
            <h2 class="rai-page-heading__title">Classic Sidebar</h2>
            <p class="rai-page-heading__description">Use this page to test section headings, long navigation lists, nested menus, and local SVG icons.</p>
        </div>
    </div>
    <section class="rai-card">
        <div class="rai-card__body">
            <h3 class="rai-card__title">Sidebar test content</h3>
            <p>Menu links are demonstration URLs. Replace them with your application's actual routes before using them in production.</p>
        </div>
    </section>
</x-admin-ui::layout>
