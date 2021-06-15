<?php


const APP_NAME = 'Ride To Future';
const USER_FORGET_PASSWORD_OTP_DURATION = 90;
const USER_FORGET_PASSWORD_OTP_INTERVALS = 90;
const USER_FORGET_PASSWORD_OTP_TRIES = 3;

const USER_EMAIL_VERIFICATION_OTP_DURATION = 90;
const USER_EMAIL_VERIFICATION_OTP_INTERVALS = 90;
const USER_EMAIL_VERIFICATION_OTP_TRIES = 3;


const USER_REGISTRATION_PASSWORD_CRITERIA = '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$';
const MAX_LOGIN_ATTEMPTS_INTERVALS = '3,30,90';
const MAX_LOGIN_ATTEMPTS_TRIES = 3;

const SETTINGS = [
    'APP_NAME' => [
        'value' => APP_NAME,
        'description' => 'Website name',
        'category' => 'General'
    ],
    'USER_FORGET_PASSWORD_OTP_INTERVALS' => [
        'value' => USER_FORGET_PASSWORD_OTP_INTERVALS,
        'description' => '(in seconds) This is used with max user tries to stop user requesting a lot for forget password otp.',
        'category' => 'User'
    ],
    'USER_FORGET_PASSWORD_OTP_DURATION' => [
        'value' => USER_FORGET_PASSWORD_OTP_DURATION,
        'description' => '(in seconds) Forget otp is valid for 90 seconds as default.',
        'category' => 'User'
    ],
    'USER_FORGET_PASSWORD_OTP_TRIES' => [
        'value' => USER_FORGET_PASSWORD_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for forget password otp',
        'category' => 'User'
    ],
    'USER_EMAIL_VERIFICATION_OTP_INTERVALS' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_INTERVALS,
        'description' => '(in seconds) This is used with max user tries to stop user requesting a lot for email verification  otp.',
        'category' => 'User'
    ],
    'USER_EMAIL_VERIFICATION_OTP_DURATION' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_DURATION,
        'description' => '(in seconds) Email verification otp is valid for 90 seconds as default.',
        'category' => 'User'
    ],
    'USER_EMAIL_VERIFICATION_OTP_TRIES' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for email verification  otp',
        'category' => 'User'
    ],
    'USER_REGISTRATION_PASSWORD_CRITERIA' => [
        'value' => USER_REGISTRATION_PASSWORD_CRITERIA,
        'description' => 'Password pattern for user registration',
        'category' => 'User'
    ],
    'MAX_LOGIN_ATTEMPTS_INTERVALS' => [
        'value' => MAX_LOGIN_ATTEMPTS_INTERVALS,
        'description' => 'Max login attempt intervals separated with , ',
        'category' => 'User'
    ],
    'MAX_LOGIN_ATTEMPTS_TRIES' => [
        'value' => MAX_LOGIN_ATTEMPTS_TRIES,
        'description' => 'Max login attempt per interval ',
        'category' => 'User'
    ]
];

const EMAIL_SETTINGS = [
    'OTP_FORGET_PASSWORD_EMAIL' => [
        'subject' => 'Forget Password Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email'
    ],
    'EMAIL_VERIFICATION_OTP_EMAIL' => [
        'subject' => 'Email Verification Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token to verify email is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email'
    ],
    'USER_REGISTRATION_WELCOME_EMAIL' => [
        'subject' => 'Welcome',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Welcome to Ride to Future, You can activate your email by this token {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email'
    ],
    'SUSPICIOUS_LOGIN_ATTEMPT_EMAIL' => [
        'subject' => 'Suspicious Login Attempt',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Someone tries to Login from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}} and login is {{status}} </p>',
        'variables' => 'full_name,country,city,ip,platform,browser,status',
        'variables_description' => 'full_name user full name',
        'type' => 'email'
    ]


];

const QUEUES_EMAIL = 'emails';

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
 * otp types
 */
const OTP_EMAIL_VERIFICATION = 'OTP_EMAIL_VERIFICATION';
const OTP_EMAIL_FORGET_PASSWORD = 'OTP_EMAIL_FORGET_PASSWORD';
const OTP_TYPES = [
    OTP_EMAIL_VERIFICATION,
    OTP_EMAIL_FORGET_PASSWORD
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
