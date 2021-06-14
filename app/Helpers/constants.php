<?php


const APP_NAME = 'Ride To Future';
const USER_OTP_DURATION = 30;
const USER_OTP_MAX_TRIES = 3;
const USER_REGISTRATION_PASSWORD_CRITERIA = '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$';

const SETTINGS = [
    'APP_NAME' => [
        'value' => APP_NAME,
        'description' => 'Website name',
        'category' => 'General'
    ],
    'USER_OTP_DURATION' => [
        'value' => USER_OTP_DURATION,
        'description' => '(in minutes) This is used with max user tries to stop user requesting a lot for forget password otp.',
        'category' => 'Notification'
    ],
    'USER_OTP_MAX_TRIES' => [
        'value' => USER_OTP_MAX_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for forget password otp',
        'category' => 'Notification'
    ],
    'USER_REGISTRATION_PASSWORD_CRITERIA' => [
        'value' => USER_REGISTRATION_PASSWORD_CRITERIA,
        'description' => 'Password pattern for user registration',
        'category' => 'User Registration'
    ]
];

const EMAIL_AND_TEXT_SETTINGS = [
    'OTP_FORGET_PASSWORD_EMAIL' => [
        'subject' => 'Forget Password Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email'
    ],
    'USER_REGISTRATION_WELCOME_EMAIL' => [
        'subject' => 'Welcome',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Welcome to Ride to Future</p>',
        'variables' => 'full_name',
        'variables_description' => 'full_name user full name',
        'type' => 'email'
    ]

];


/**
 * user_roles
 */
const USER_ROLE_ADMIN = 'admin';
const USER_ROLE_CLIENT = 'client';
const USER_ROLE_HELP_DESK = 'help-desk';
const USER_ROLES = [
    USER_ROLE_ADMIN,
    USER_ROLE_CLIENT,
    USER_ROLE_HELP_DESK,
];

/**
 * document_types
 */
const DOCUMENT_TYPES_DRIVING_LICENCE = 'driving_licence';
const DOCUMENT_TYPES_PASSPORT = 'passport';
const DOCUMENT_TYPES_NATIONAL_ID = 'national_id';
const DOCUMENT_TYPES = [
    DOCUMENT_TYPES_DRIVING_LICENCE,
    DOCUMENT_TYPES_PASSPORT,
    DOCUMENT_TYPES_NATIONAL_ID,
];


/**
 * media types
 */

const MEDIA_TYPE_VIDEO_STORAGE = "MEDIA_TYPE_VIDEO_STORAGE";
const MEDIA_TYPE_IMAGE_STORAGE = "MEDIA_TYPE_IMAGE_STORAGE";
const MEDIA_TYPE_VIDEOS = [
    MEDIA_TYPE_VIDEO_STORAGE
];
const MEDIA_TYPE_IMAGES = [
    MEDIA_TYPE_IMAGE_STORAGE
];
const MEDIA_TYPES = [
    MEDIA_TYPE_VIDEO_STORAGE,
    MEDIA_TYPE_IMAGE_STORAGE
];


const VIDEO_MIME_TYPES = [
    'video/3gpp',
    'video/mp4',
    'video/mpeg',
    'video/ogg',
    'video/webm',
];
const IMAGE_MIME_TYPES = [
    'image/gif',
    'image/jpeg',
    'image/png',
];
const PDF_MIME_TYPES = [
    'application/pdf'
];
const AUDIO_MIME_TYPES = [
    'audio/basic',
    'audio/mp4',
    'audio/mpeg',
    'audio/ogg',
    'audio/wav',
    'audio/wave',
    'audio/webm',
];
const ALL_MIME_TYPES = [
    'video/3gpp',
    'video/mp4',
    'video/mpeg',
    'video/ogg',
    'video/webm',

    'image/gif',
    'image/jpeg',
    'image/png',

    'application/pdf',

    'audio/basic',
    'audio/mp4',
    'audio/mpeg',
    'audio/ogg',
    'audio/wav',
    'audio/wave',
    'audio/webm',
];
