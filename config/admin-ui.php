<?php

return [
    // Shared browser tab icon used by the package's Admin and Auth layouts.
    'favicon' => 'https://bot.kotfumes.com/assets/app/images/chatbot.webp',

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
    | Optional layout presets
    |--------------------------------------------------------------------------
    |
    | These names are validated now. Their actual sidebar and login renderers
    | are delivered in the dedicated layout phase.
    |
    */
    'layout' => [
        'enabled' => true,
        'sidebar' => 'classic',
    ],

    'sidebar' => [
        'default_collapsed' => true,
        'persist_state' => false,
        'mobile_breakpoint' => 992,
        'sections' => [],
    ],


    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    |
    | Header controls are presentation-only. Clicks are emitted as
    | `admin-ui:header-action` CustomEvents for the host application.
    |
    */
    'header' => [
        'components' => [
            'search' => true,
            'explore' => true,
            'apps' => true,
            'quick_create' => true,
            'theme_switcher' => true,
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
                'my_profile' => ['enabled' => true, 'label' => 'My Profile', 'icon' => 'user', 'route' => null, 'method' => 'GET', 'divider_before' => false],
                'account_settings' => ['enabled' => true, 'label' => 'Account Settings', 'icon' => 'settings', 'route' => null, 'method' => 'GET', 'divider_before' => false],
                'security' => ['enabled' => true, 'label' => 'Security & Privacy', 'icon' => 'shield', 'route' => null, 'method' => 'GET', 'divider_before' => false],
                'help_center' => ['enabled' => true, 'label' => 'Help Center', 'icon' => 'help', 'route' => null, 'method' => 'GET', 'divider_before' => false],
                'logout' => ['enabled' => true, 'label' => 'Sign Out', 'icon' => 'logout', 'route' => null, 'method' => 'POST', 'divider_before' => true, 'danger' => true],
            ],
        ],
    ],

    'auth' => [
        // Select one of the available Login visual variants: v1, v2, v3 or v4.
        'login' => 'v1',

        // Authentication pages are guest-only by default. Set to a custom
        // middleware class/name (or array) to use Host authentication rules,
        // or null/false to disable the additional guest middleware.
        'guest_middleware' => 'guest',

        // OTP dialog presentation defaults. OTP business logic remains in Host.
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
            'social_login_pending_message' => 'Connecting to :provider...',
            'social_login_unavailable_message' => ':provider login is not configured yet.',
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
                    'description' => 'Enterprise-grade security and compliance.',
                    'icon' => 'profile-check',
                ],
            ],
            'copyright' => '© :year All rights reserved.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Login visual variants
        |--------------------------------------------------------------------------
        |
        | Variants share the same form markup, element IDs, data attributes and
        | Host Application JavaScript integration. Only branding, copy and CSS
        | presentation change when a variant is selected.
        |
        */
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
                            'icon' => 'stroke-calendar',
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
                    'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp',
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
        */
        'registration' => [
            'enabled' => true,
            'variant' => 'v1', // v1, v2, v3
            'route' => ['enabled' => true, 'path' => '/register', 'name' => 'admin-ui.register', 'middleware' => ['web']],
            'action' => null,
            'method' => 'POST',
            // These entrypoints are defined by the Host application's Vite config.
            'vite' => [
                'css' => [
                    'resources/css/app.css',
                    'resources/css/pages/auth/register.css',
                ],
                'js' => [
                    'resources/js/app.js',
                    'resources/js/pages/RegisterPage.js',
                ],
            ],
            'fields' => [
                'name' => ['enabled' => true, 'name' => 'name', 'label' => 'Full Name', 'placeholder' => 'Enter your full name', 'required' => true],
                'email' => ['enabled' => true, 'name' => 'email', 'label' => 'Email Address', 'placeholder' => 'Enter your email', 'required' => true],
                'country_code' => ['enabled' => true, 'name' => 'countryCode', 'label' => 'Country Code', 'placeholder' => 'Select country', 'required' => true],
                'mobile' => ['enabled' => true, 'name' => 'mobileNumber', 'label' => 'Mobile Number', 'placeholder' => 'Enter mobile number', 'required' => true],
                'referral' => ['enabled' => true, 'name' => 'refCode', 'label' => 'Referral Code (Optional)', 'placeholder' => 'Enter referral code', 'required' => false],
            ],
            // Calling codes are sent to the Host API without the leading "+".
            'countries' => [
                ['code' => '91', 'region' => 'IN', 'name' => 'India'],
                ['code' => '1', 'region' => 'US', 'name' => 'United States'],
                ['code' => '44', 'region' => 'GB', 'name' => 'United Kingdom'],
            ],
            'default_country' => 'IN',
            'title' => 'Create Your Account',
            'headline' => 'Get Started.',
            'headline_accent' => 'Grow With WhatsApp.',
            'description' => 'Create your account and start connecting, engaging and growing your business.',
            'welcome_title' => 'Create Your Account',
            'welcome_description' => 'Sign up to get started.',
            'submit_label' => 'Create Account',
            'login_url' => '/login',
            'login_prompt' => 'Already have an account?',
            'login_label' => 'Sign In',
            'copyright' => '© :year All rights reserved.',
            'variants' => [
                'v1' => [],
                'v2' => [
                    'branding' => ['logo_on_dark' => 'https://newsnetworksindia.com/assets/newsLogo.webp', 'logo_on_light' => 'https://newsnetworksindia.com/assets/newsLogo.webp', 'logo_alt' => 'News Networks India'],
                    'title' => 'Join the Newsroom', 'headline' => 'Build Your Newsroom.', 'headline_accent' => 'Tell Every Story.',
                    'description' => 'Create your newsroom account to manage editorial teams, stories and publishing workflows.',
                    'welcome_title' => 'Create Newsroom Account', 'welcome_description' => 'Set up your access to the editorial workspace.',
                    'submit_label' => 'Create Account', 'login_prompt' => 'Already part of the newsroom?', 'copyright' => '© :year News Networks India. All rights reserved.',
                ],
                'v3' => [
                    'branding' => ['logo_on_dark' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp', 'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp', 'logo_alt' => 'Islamic Education Portal'],
                    'title' => 'Join the Learning Portal', 'headline' => 'Begin With Knowledge.', 'headline_accent' => 'Grow With Faith.',
                    'description' => 'Create your learning account and continue your journey of beneficial knowledge.',
                    'welcome_title' => 'Create Your Learning Account', 'welcome_description' => 'A new step in your learning journey begins here.',
                    'submit_label' => 'Create Account', 'login_prompt' => 'Already have an account?', 'login_label' => 'Sign In', 'copyright' => '© :year Islamic Education Portal. All rights reserved.',
                ],
            ],
            'branding' => ['logo_on_dark' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot2.webp', 'logo_on_light' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp', 'logo_alt' => 'Application Logo'],
        ],

        /*
        |--------------------------------------------------------------------------
        | Centered password setup / recovery form
        |--------------------------------------------------------------------------
        */
        'forgot_password' => [
            'enabled' => true,
            'route' => ['enabled' => true, 'path' => '/forgot-password', 'name' => 'admin-ui.forgot-password', 'middleware' => ['web']],
            'action' => null,
            'method' => 'POST',
            'vite' => [
                'css' => [
                    'resources/css/app.css',
                    'resources/css/pages/auth/forgot-password.css',
                ],
                'js' => [
                    'resources/js/app.js',
                    'resources/js/pages/ForgotPasswordPage.js',
                ],
            ],
            'title' => 'Reset Your Password',
            'description' => 'Enter your email and choose a new password for your account.',
            'email_name' => 'email', 'email_label' => 'Email Address', 'email_placeholder' => 'Enter your registered email',
            'password_name' => 'password', 'password_label' => 'New Password', 'password_placeholder' => 'Enter new password',
            'password_confirmation_name' => 'password_confirmation', 'password_confirmation_label' => 'Re-Type Password', 'password_confirmation_placeholder' => 'Re-enter new password',
            'submit_label' => 'Update Password', 'login_url' => '/login', 'login_label' => 'Back to Sign In',
            'branding' => ['logo' => 'https://bot.kotfumes.com/assets/app/images/logo/kotbot1.webp', 'logo_alt' => 'Application Logo'],
        ],

        // These are entries in the HOST application's Vite manifest.
        'vite' => [
            'css' => [
                'resources/css/app.css',
                'resources/css/pages/auth/login.css',
            ],
            'js' => [
                'resources/js/app.js',
                'resources/js/pages/LoginPage.js',
            ],
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
    ],
];
