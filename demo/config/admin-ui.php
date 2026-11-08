<?php

    return [
        /*
        |--------------------------------------------------------------------------
        | Theme defaults
        |--------------------------------------------------------------------------
        |
        | Phase 1 ships the light theme. The data-rai-theme attribute and token
        | structure leave room for additional themes without duplicating component
        | stylesheets.
        |
        */
        'theme' => [
            'default' => 'light',
            'allow_runtime_override' => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | Layout presets
        |--------------------------------------------------------------------------
        |
        | Select the sidebar appearance: classic, modern, or compact. All three
        | variants share the same markup, responsive behavior and interactions.
        | Only the visual styling changes.
        |
        */
        'layout' => [
            'enabled' => true,
            'sidebar' => 'modern',
        ],

        /*
        |--------------------------------------------------------------------------
        | Admin Header
        |--------------------------------------------------------------------------
        |
        | Control which header controls and information cards are displayed.
        | These settings belong to the host application and override package defaults.
        |
        */
        'header' => [
            'components' => [
                'search' => true,
                'explore' => false,
                'apps' => false,
                'quick_create' => false,
                'theme_switcher' => false,
                'language_switcher' => true,
                'fullscreen' => true,
                'messages' => true,
                'notifications' => true,
                'info_cards' => true,
                'profile' => true,
            ],

            'info_cards' => [
                'wallet_balance' => [
                    'enabled' => true,
                    'label' => 'Prepaid Balance',
                    'icon' => 'wallet',
                ],

                'otp_credit' => [
                    'enabled' => true,
                    'label' => 'OTP SMS Credit',
                    'icon' => 'message',
                ],
            ],

            'profile_menu' => [
                'enabled' => true,
                'show_user_details' => true,
                'items' => [
                    'my_profile' => [
                        'enabled' => true,
                        'label' => 'My Profile',
                        'icon' => 'user',
                        'divider_before' => false,
                    ],
                    'account_settings' => [
                        'enabled' => true,
                        'label' => 'Account Settings',
                        'icon' => 'settings',
                        'divider_before' => false,
                    ],
                    'security' => [
                        'enabled' => true,
                        'label' => 'Security & Privacy',
                        'icon' => 'shield',
                        'divider_before' => false,
                    ],
                    'help_center' => [
                        'enabled' => true,
                        'label' => 'Help Center',
                        'icon' => 'help',
                        'divider_before' => false,
                    ],
                    'logout' => [
                        'enabled' => true,
                        'label' => 'Sign Out',
                        'icon' => 'logout',
                        'divider_before' => true,
                        'danger' => true,
                    ],
                ],
            ],
        ],

        'auth' => [
            // Select one of the available Login visual variants: v1, v2, v3 or v4.
            'login' => 'v1',

            // OTP dialog appearance. Change top_image here without editing package files.
            'otp_dialog' => [
                'enabled' => true,
                'top_image' => 'https://bot.kotfumes.com/assets/app/images/otp_top_graphic.webp',
                'otp_length' => 6,
                'resend_timer' => 120,
            ],

            // The package registers the GET page route. The host application owns
            // the POST endpoint and all authentication processing.
            'route' => [
                'enabled' => true,
                'path' => '/login',
                'name' => 'admin-ui.login',
                'middleware' => ['web'],
            ],

            'branding' => [
                'logo_on_dark' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp',
                'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp',
                'logo_alt' => 'Application Logo',
            ],

            'login_page' => [
                'title' => 'Sign In',
                'action' => null, // Defaults to the configured login page URL.
                'method' => 'POST',
                'email_name' => 'emailAddress',
                'password_name' => 'password',
                'email_label' => 'Email Address',
                'email_placeholder' => 'Enter Registered Email',
                'password_label' => 'Password',
                'password_placeholder' => 'Enter your password',
                'submit_label' => 'Sign In',
                'forgot_password_url' => '/forgot-password',
                'forgot_password_label' => 'Forgot Password?',
                'register_url' => '/register',
                'register_prompt' => "Don't have an account?",
                'register_label' => 'Create Account',
                'google_url' => null,
                'social_logins' => [
                    [
                        'provider' => 'google',
                        'label' => 'Sign in with Google',
                        'url' => null,
                        'enabled' => true,
                    ],
                ],
                'headline' => 'Manage Conversations.',
                'headline_accent' => 'Delight Customers.',
                'description' => 'The all-in-one WhatsApp CRM to connect, engage and grow your business.',
                'welcome_title' => 'Welcome Back',
                'welcome_description' => 'Sign in to your account',
                'divider_label' => 'or',
                'brand_panel_label' => 'About',
                'features' => [
                    [
                        'title' => 'Centralized Inbox',
                        'description' => 'Manage all your WhatsApp conversations in one place.',
                        'icon' => 'stroke-chat',
                    ],
                    [
                        'title' => 'Team Collaboration',
                        'description' => 'Assign chats, add internal notes and work together seamlessly.',
                        'icon' => 'stroke-add-user',
                    ],
                    [
                        'title' => 'Powerful Insights',
                        'description' => 'Track performance and get insights to improve customer engagement.',
                        'icon' => 'profit',
                    ],
                    [
                        'title' => 'Secure & Reliable',
                        'description' => 'Enterprise-grade security to keep your data safe and compliant.',
                        'icon' => 'profile-check',
                    ],
                ],
                'copyright' => '© :year All rights reserved.',
            ],

            'variants' => [
                // V1 uses the base branding and login_page values above.
                'v1' => [],

                'v2' => [
                    'branding' => [
                        'logo_on_dark' => 'https://newsnetworksindia.com/assets/newsLogo.webp',
                        'logo_on_light' => 'https://newsnetworksindia.com/assets/newsLogo.webp',
                        'logo_alt' => 'News Networks India',
                    ],
                    'login_page' => [
                        'title' => 'Newsroom Admin · Sign In',
                        'headline' => 'Every Story.',
                        'headline_accent' => 'One Newsroom.',
                        'description' => 'A smarter workspace to publish, manage and grow your digital news platform.',
                        'welcome_title' => 'Welcome to the Newsroom',
                        'welcome_description' => 'Sign in to manage your publication.',
                        'email_label' => 'Work Email',
                        'email_placeholder' => 'Enter your newsroom email',
                        'password_label' => 'Password',
                        'password_placeholder' => 'Enter your password',
                        'submit_label' => 'Access Dashboard',
                        'forgot_password_label' => 'Forgot your password?',
                        'register_url' => null,
                        'show_register_link' => false,
                        'divider_label' => 'or continue with',
                        'brand_panel_label' => 'Newsroom platform',
                        'features' => [
                            [
                                'title' => 'Editorial Workflow',
                                'description' => 'Coordinate stories, drafts and approvals from one workspace.',
                                'icon' => 'stroke-file',
                            ],
                            [
                                'title' => 'Audience Insights',
                                'description' => 'Understand readership and track your content performance.',
                                'icon' => 'profit',
                            ],
                            [
                                'title' => 'Publishing Control',
                                'description' => 'Keep your channels, contributors and publishing schedule aligned.',
                                'icon' => 'stroke-kyc',
                            ],
                        ],
                        'copyright' => '© :year News Networks India. All rights reserved.',
                    ],
                ],

                'v3' => [
                    'branding' => [
                        'logo_on_dark' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp',
                        'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp',
                        'logo_alt' => 'Islamic Education Portal',
                    ],
                    'login_page' => [
                        'title' => 'Islamic Education Portal · Sign In',
                        'headline' => 'Knowledge for Life.',
                        'headline_accent' => 'Faith for the Journey.',
                        'description' => 'A welcoming space to learn, reflect and grow through authentic Islamic education.',
                        'welcome_title' => 'Assalamu Alaikum',
                        'welcome_description' => 'Sign in to continue your learning journey.',
                        'email_label' => 'Email Address',
                        'email_placeholder' => 'Enter your registered email',
                        'password_label' => 'Password',
                        'password_placeholder' => 'Enter your password',
                        'submit_label' => 'Continue Learning',
                        'forgot_password_label' => 'Forgot password?',
                        'register_prompt' => 'New to the learning portal?',
                        'register_label' => 'Create an account',
                        'divider_label' => 'or sign in with',
                        'brand_panel_label' => 'Islamic education',
                        'features' => [
                            [
                                'title' => 'Learn with Purpose',
                                'description' => 'Explore structured courses and carefully curated lessons.',
                                'icon' => 'stroke-project',
                            ],
                            [
                                'title' => 'Trusted Resources',
                                'description' => 'Access learning material prepared with care and clarity.',
                                'icon' => 'profile-check',
                            ],
                            [
                                'title' => 'Grow Together',
                                'description' => 'Build a consistent learning habit with your community.',
                                'icon' => 'stroke-add-user',
                            ],
                        ],
                        'copyright' => '© :year Islamic Education Portal. All rights reserved.',
                    ],
                ],

                'v4' => [
                    'branding' => [
                        'logo_on_dark' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp',
                        'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp',
                        'logo_alt' => 'Application Logo',
                    ],
                    'login_page' => [
                        'title' => 'Sign In',
                        'headline' => '',
                        'headline_accent' => '',
                        'description' => '',
                        'welcome_title' => 'Welcome Back',
                        'welcome_description' => 'Sign in to your account to continue.',
                        'submit_label' => 'Sign In',
                        'show_social_logins' => false,
                        'show_register_link' => false,
                        'features' => [],
                        'copyright' => '',
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Registration page
            |--------------------------------------------------------------------------
            |
            | Select the registration design used by the package GET route.
            | The package supplies the remaining registration defaults.
            |
            */
            'registration' => [
                'variant' => 'v2', // v1 = WhatsApp CRM, v2 = News Portal, v3 = Islamic Education
            ],

            // These are entries in the HOST application's Vite manifest.
            'vite' => [
                'css' => 'resources/css/auth-login-v1.css',
                'js' => 'resources/js/pages/LoginPage.js',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Asset paths
        |--------------------------------------------------------------------------
        |
        | Bootstrap is supplied by the host application. By default the optional
        | package layout expects local Bootstrap 5 files at the paths below.
        | Set include_bootstrap to false if the host layout already loads Bootstrap.
        |
        */
        'assets' => [
            'include_bootstrap' => false,
            'bootstrap_css' => 'vendor/bootstrap/css/bootstrap.min.css',
            'bootstrap_js' => 'vendor/bootstrap/js/bootstrap.bundle.min.js',
            'css' => 'vendor/admin-ui/css/admin-ui.css',
            'js' => 'vendor/admin-ui/js/admin-ui.js',
        ],
    ];
