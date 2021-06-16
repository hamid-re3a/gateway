<?php


const APP_NAME = 'Ride To Future';
const USER_FORGOT_PASSWORD_OTP_DURATION = 90;
const USER_FORGOT_PASSWORD_OTP_INTERVALS = 90;
const USER_FORGOT_PASSWORD_OTP_TRIES = 3;

const USER_EMAIL_VERIFICATION_OTP_DURATION = 90;
const USER_EMAIL_VERIFICATION_OTP_INTERVALS = 90;
const USER_EMAIL_VERIFICATION_OTP_TRIES = 3;


const USER_REGISTRATION_PASSWORD_CRITERIA = '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$';
const MAX_LOGIN_ATTEMPTS_INTERVALS = '30,60,90';
const MAX_LOGIN_ATTEMPTS_TRIES = 3;
const USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD = true;

const SETTINGS = [
    'APP_NAME' => [
        'value' => APP_NAME,
        'description' => 'Website name',
        'category' => 'General'
    ],
    'USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD' => [
        'value' => USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD,
        'description' => 'When user wants to reset password, should we check history and not allow shim to use previous ones.',
        'category' => 'User > Password'
    ],
    'USER_FORGOT_PASSWORD_OTP_INTERVALS' => [
        'value' => USER_FORGOT_PASSWORD_OTP_INTERVALS,
        'description' => '(in seconds) This is used with max user tries to stop user requesting a lot for forgot password otp.',
        'category' => 'User > Password'
    ],
    'USER_FORGOT_PASSWORD_OTP_DURATION' => [
        'value' => USER_FORGOT_PASSWORD_OTP_DURATION,
        'description' => '(in seconds) Forget otp is valid for 90 seconds as default.',
        'category' => 'User > Password'
    ],
    'USER_FORGOT_PASSWORD_OTP_TRIES' => [
        'value' => USER_FORGOT_PASSWORD_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for forgot password otp',
        'category' => 'User > Password'
    ],
    'USER_EMAIL_VERIFICATION_OTP_INTERVALS' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_INTERVALS,
        'description' => '(in seconds) This is used with max user tries to stop user requesting a lot for email verification  otp.',
        'category' => 'User > Email Verification'
    ],
    'USER_EMAIL_VERIFICATION_OTP_DURATION' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_DURATION,
        'description' => '(in seconds) Email verification otp is valid for 90 seconds as default.',
        'category' => 'User > Email Verification'
    ],
    'USER_EMAIL_VERIFICATION_OTP_TRIES' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for email verification  otp',
        'category' => 'User > Email Verification'
    ],
    'USER_REGISTRATION_PASSWORD_CRITERIA' => [
        'value' => USER_REGISTRATION_PASSWORD_CRITERIA,
        'description' => 'Password pattern for user registration',
        'category' => 'User > Password'
    ],
    'MAX_LOGIN_ATTEMPTS_INTERVALS' => [
        'value' => MAX_LOGIN_ATTEMPTS_INTERVALS,
        'description' => 'Max login attempt intervals separated with , ',
        'category' => 'User > Login'
    ],
    'MAX_LOGIN_ATTEMPTS_TRIES' => [
        'value' => MAX_LOGIN_ATTEMPTS_TRIES,
        'description' => 'Max login attempt per interval ',
        'category' => 'User > Login'
    ]
];

const EMAIL_SETTINGS = [
    'FORGOT_PASSWORD_OTP_EMAIL' => [
        'subject' => 'Forget Password Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email'
    ],
    'VERIFICATION_EMAIL_OTP_EMAIL' => [
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
    ],
    'TOO_MANY_LOGIN_ATTEMPTS_TEMPORARY_BLOCK_EMAIL' => [
        'subject' => 'Too Many Login Attempt - Temporary Blocked',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Too many tries {{login_attempt_times}} times, You can try again in {{next_try_time}}</p>',
        'variables' => 'full_name,country,city,ip,platform,browser,status,next_try_time,login_attempt_times',
        'variables_description' => 'full_name user full name',
        'type' => 'email'
    ],
    'TOO_MANY_LOGIN_ATTEMPTS_PERMANENT_BLOCK_EMAIL' => [
        'subject' => 'Too Many Login Attempt - Permanently Blocked',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>You tried too many times, your account is permanently blocked</p><p>Call the administration.</p>',
        'variables' => 'full_name,country,city,ip,platform,browser,status,next_try_time,login_attempt_times',
        'variables_description' => 'full_name user full name',
        'type' => 'email'
    ],
    'PASSWORD_CHANGED_WARNING_EMAIL' => [
        'subject' => 'Password Changed Warning',
        'from' => 'info@r2f.com',
        'from_name' => 'Site Administration',
        'body' => '<p>Hello, {{full_name}}</p><p>Someone tries to Login from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}}. if it is not you call the administration  </p>',
        'variables' => 'full_name,country,city,ip,platform,browser,status',
        'variables_description' => 'full_name user full name',
        'type' => 'email'
    ],
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
 * user block types
 */
const USER_BLOCK_TYPE_AUTOMATIC = 'USER_BLOCK_TYPE_AUTOMATIC';
const USER_BLOCK_TYPES = [
    USER_BLOCK_TYPE_AUTOMATIC,
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
const OTP_EMAIL_FORGOT_PASSWORD = 'OTP_EMAIL_FORGOT_PASSWORD';
const OTP_TYPES = [
    OTP_EMAIL_VERIFICATION,
    OTP_EMAIL_FORGOT_PASSWORD
];


/**
 * login attempt status
 */
const LOGIN_ATTEMPT_STATUS_ON_GOING = 0;
const LOGIN_ATTEMPT_STATUS_SUCCESS = 1;
const LOGIN_ATTEMPT_STATUS_FAILED = 2;
const LOGIN_ATTEMPT_STATUS_BLOCKED = 3;
const LOGIN_ATTEMPT_STATUSES = [
    LOGIN_ATTEMPT_STATUS_ON_GOING,
    LOGIN_ATTEMPT_STATUS_SUCCESS,
    LOGIN_ATTEMPT_STATUS_FAILED,
    LOGIN_ATTEMPT_STATUS_BLOCKED
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
