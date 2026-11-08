<?php

namespace App\Presentation\Admin\Navigation;

class AdminMenuProvider
{
    /**
     * Return the menu sections for the current request.
     *
     * This class belongs to the host application. Add host-specific
     * role/permission filtering here if required. The UI package does
     * not know about roles, permissions, or authorization.
     */
    public function sections(): array
    {
        $is = static fn (string $route): bool => request()->routeIs($route);

        $customersActive = $is('admin.demo.customers')
            || $is('admin.demo.contacts');

        return [
            [
                'label' => 'WORKSPACE',
                'items' => [
                    [
                        'label' => 'Home',
                        'icon' => 'stroke-layout',
                        'url' => route('admin.demo.dashboard'),
                        'active' => $is('admin.demo.dashboard'),
                    ],
                ],
            ],
            [
                'label' => 'CUSTOMER MANAGEMENT',
                'items' => [
                    [
                        'label' => 'Customers',
                        'icon' => 'stroke-user',
                        'active' => $customersActive,
                        'children' => [
                            [
                                'label' => 'All Customers',
                                'icon' => 'stroke-user',
                                'url' => route('admin.demo.customers'),
                                'active' => $is('admin.demo.customers'),
                            ],
                            [
                                'label' => 'Contacts',
                                'icon' => 'stroke-contact',
                                'url' => route('admin.demo.contacts'),
                                'active' => $is('admin.demo.contacts'),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'MESSAGING',
                'items' => [
                    [
                        'label' => 'Inbox',
                        'icon' => 'stroke-chat',
                        'active' => $is('admin.demo.conversations'),
                        'children' => [
                            [
                                'label' => 'All Conversations',
                                'icon' => 'stroke-chat',
                                'url' => route('admin.demo.conversations'),
                                'active' => $is('admin.demo.conversations'),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'AUTOMATION',
                'items' => [
                    [
                        'label' => 'Automations',
                        'icon' => 'stroke-project',
                        'url' => route('admin.demo.automations'),
                        'active' => $is('admin.demo.automations'),
                    ],
                ],
            ],
            [
                'label' => 'ADMINISTRATION',
                'items' => [
                    [
                        'label' => 'Settings',
                        'icon' => 'toggle-icon',
                        'url' => route('admin.demo.settings'),
                        'active' => $is('admin.demo.settings'),
                    ],
                ],
            ],
        ];
    }
}
