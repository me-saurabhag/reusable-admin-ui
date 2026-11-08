@php
    $menu = [
        ['label' => 'WORKSPACE', 'items' => [
            [
                'label' => 'Dashboard',
                'icon' => 'stroke-layout',
                'url' => route('admin.demo.dashboard'),
                'active' => $activePage === 'dashboard',
            ],
        ]],
        ['label' => 'CUSTOMER MANAGEMENT', 'items' => [
            [
                'label' => 'Customers',
                'icon' => 'stroke-user',
                'active' => in_array($activePage, ['customers', 'contacts'], true),
                'children' => [
                    [
                        'label' => 'All Customers',
                        'icon' => 'stroke-user',
                        'url' => route('admin.demo.customers'),
                        'active' => $activePage === 'customers',
                    ],
                    [
                        'label' => 'Contacts',
                        'icon' => 'stroke-contact',
                        'url' => route('admin.demo.contacts'),
                        'active' => $activePage === 'contacts',
                    ],
                ],
            ],
        ]],
        ['label' => 'MESSAGING', 'items' => [
            [
                'label' => 'Inbox',
                'icon' => 'stroke-chat',
                'active' => $activePage === 'conversations',
                'children' => [
                    [
                        'label' => 'All Conversations',
                        'icon' => 'stroke-chat',
                        'url' => route('admin.demo.conversations'),
                        'active' => $activePage === 'conversations',
                    ],
                ],
            ],
        ]],
        ['label' => 'AUTOMATION', 'items' => [
            [
                'label' => 'Automations',
                'icon' => 'stroke-project',
                'url' => route('admin.demo.automations'),
                'active' => $activePage === 'automations',
            ],
        ]],
        ['label' => 'ADMINISTRATION', 'items' => [
            [
                'label' => 'Settings',
                'icon' => 'toggle-icon',
                'url' => route('admin.demo.settings'),
                'active' => $activePage === 'settings',
            ],
        ]],
    ];
@endphp

<x-admin-ui::sidebar brand-name="Acme Admin" :sections="$menu" />
