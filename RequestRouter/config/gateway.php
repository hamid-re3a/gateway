<?php
return [
    // List of microservices behind the gateway
    'services' => [
        'default' => [
            'prefix' => '/default',
            'doc_point' => '/docs',
            /** Can client calls the routes that are not defined here on this service */
            'routes' => true,
            'domain' => 'local',
        ],
        'fake' => [
            'prefix' => '/fake',
            'doc_point' => 'https://jsonplaceholder.typicode.com/',
            'routes' => false,
            'domain' => 'https://jsonplaceholder.typicode.com/'
        ]

    ],
    'routes' => [
        [
            'services' => [
                'fake'
            ],
            'matches' => [
                [
                    'method' => 'GET',
                    'paths' => [
                        'posts',
                        'comments'
                    ]
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
