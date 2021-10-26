<?php
return [
    // List of microservices behind the gateway
    'services' => [
        'default' => [
            'doc_point' => '/docs',
            /** Can client calls the routes that are not defined here on this service */
            'just_current_routes' => true,
            'domain' => 'local',
        ],
        'subscription' => [
            'doc_point' => env('SUBSCRIPTION_BASE_URL','https://staging-subscription.janex.org/') . 'docs',
            'just_current_routes' => false,
            'domain' => env('SUBSCRIPTION_BASE_URL','https://staging-subscription.janex.org/')
        ],
        'kyc' => [
            'doc_point' => env('KYC_BASE_URL','https://staging-kyc.janex.org/') . 'docs',
            'just_current_routes' => false,
            'domain' =>  env('KYC_BASE_URL','https://staging-kyc.janex.org/')
        ],
        'mlm' => [
            'doc_point' => env('MLM_BASE_URL','https://staging-mlm.janex.org/') . 'docs',
            'just_current_routes' => false,
            'domain' => env('MLM_BASE_URL','https://staging-mlm.janex.org/')
        ],

    ],
    'routes' => [
        [
            'services' => [
                '*',
            ],
            'matches' => [
                [
                    'method' => '*',
                    'paths' => [
                        '*',
                    ],
                    'exceptions_paths' => [
                        ''
                    ]
                ]
            ],
            'middlewares' => [
                'maintenance_mode'
            ]
        ],
        [
            'services' => [
                '*',
            ],
            'matches' => [
                [
                    'method' => '*',
                    'paths' => [
                        '*',
                    ],
                    'exceptions_paths' => [
                        'payments',
                        'packages',
                        'orders',
                        'wallets'
                    ]
                ]
            ],
            'middlewares' => [
                'has_valid_package'
            ]
        ],

        [
            'services' => [
                'default'
            ],
            'matches' => [
                [
                    'method' => 'GET',
                    'paths' => [
                        'logout',
                        'ping',
                        'user',
                    ],
                ],
                [
                    'method' => 'POST',
                    'paths' => [
                        'generate2fa_disable',
                    ],
                    'middlewares' => ['2fa']
                ],
                [
                    'method' => 'POST',
                    'paths' => [
                        'generate2fa_secret',
                        'generate2fa_enable',
                    ],
                ]
            ],
            'middlewares' => [
                'auth:sanctum'
            ]
        ],
        [
            'services' => [
                'default'
            ],
            'matches' => [
                [
                    'method' => 'GET',
                    'paths' => [
                        'user_email_verification_history',
                        'user_login_history',
                        'user_block_history',
                        'user_password_history',
                    ],
                ],
                [
                    'method' => 'POST',
                    'paths' => [
                        'activate_or_deactivate_user',
                        'verify_email_user',
                    ],
                ]
            ],
            'prefix'=> 'admin',
            'middlewares' => [
                'auth:sanctum','role:admin'
            ]
        ],
    ],
];
