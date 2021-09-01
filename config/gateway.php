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
        'fake' => [
            'doc_point' => 'https://jsonplaceholder.typicode.com/',
            'just_current_routes' => true,
            'domain' => 'https://jsonplaceholder.typicode.com/'
        ],
        'subscription' => [
            'doc_point' => 'https://staging-subscription.janex.org/docs',
            'just_current_routes' => false,
            'domain' => 'https://staging-subscription.janex.org/'
        ],
        'kyc' => [
            'doc_point' => 'https://staging-kyc.janex.org/docs',
            'just_current_routes' => false,
            'domain' => 'https://staging-kyc.janex.org/'
        ],
        'local_subscription' => [
            'doc_point' => 'http://192.168.43.121:3561/docs',
            'just_current_routes' => false,
            'domain' => 'http://192.168.43.121:3561/'
        ],
        'google' =>  [
            'doc_point' => 'https://jsonplaceholder.typicode.com/',
            'just_current_routes' => false,
            'domain' => 'https://google.com/'
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
                        'payments',
                        'packages',
                        'orders'
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
