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
        'google' =>  [
            'doc_point' => 'https://jsonplaceholder.typicode.com/',
            'just_current_routes' => false,
            'domain' => 'https://dms.licdn.com/playlist/C4D05AQHqfs5cFUxVGA/mp4-640p-30fp-crf28/0/1624460061157?e=1624600800&v=beta&t=T3SW7n2cVH_fSbQSeNT3acdDYUk_81AhqD4EzZsDL_M'
        ],

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
