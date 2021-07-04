<?php

const APP_NAME = 'Ride To Future';
const USER_FORGOT_PASSWORD_OTP_DURATION = 60;
const USER_FORGOT_PASSWORD_OTP_TRIES = 1;

const USER_EMAIL_VERIFICATION_OTP_DURATION = 60;
const USER_EMAIL_VERIFICATION_OTP_TRIES = 1;

const USER_REGISTRATION_PASSWORD_CRITERIA = '^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$';
const USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD = true;
const OTP_LENGTH = 6;
const OTP_CONTAIN_ALPHABET = false;
const OTP_CONTAIN_ALPHABET_LOWER_CASE = true;
const USER_NORMAL_LOGIN_WARNING_EMAIL = true;

const SETTINGS = [
    'APP_NAME' => [
        'value' => APP_NAME,
        'description' => 'Website name',
        'category' => 'General',
    ],
    'OTP_CONTAIN_ALPHABET' => [
        'value' => OTP_CONTAIN_ALPHABET,
        'description' => 'Otp can contain alphabet in them',
        'category' => 'General > Otp',
    ],
    'OTP_CONTAIN_ALPHABET_LOWER_CASE' => [
        'value' => OTP_CONTAIN_ALPHABET_LOWER_CASE,
        'description' => 'Otp can contain only lower case alphabet in them',
        'category' => 'General > Otp',
    ],
    'OTP_LENGTH' => [
        'value' => OTP_LENGTH,
        'description' => 'Otp length',
        'category' => 'General > Otp',
    ],
    'USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD' => [
        'value' => USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD,
        'description' => 'When user wants to reset password, should we check history and not allow shim to use previous ones.',
        'category' => 'User > Password',
    ],

    'USER_FORGOT_PASSWORD_OTP_DURATION' => [
        'value' => USER_FORGOT_PASSWORD_OTP_DURATION,
        'description' => '(in seconds) Forget otp is valid for 90 seconds as default.',
        'category' => 'User > Password',
    ],
    'USER_FORGOT_PASSWORD_OTP_TRIES' => [
        'value' => USER_FORGOT_PASSWORD_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for forgot password otp',
        'category' => 'User > Password',
    ],
    'USER_EMAIL_VERIFICATION_OTP_DURATION' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_DURATION,
        'description' => '(in seconds) Email verification otp is valid for 90 seconds as default.',
        'category' => 'User > Email Verification',
    ],
    'USER_EMAIL_VERIFICATION_OTP_TRIES' => [
        'value' => USER_EMAIL_VERIFICATION_OTP_TRIES,
        'description' => 'This is used with max user duration to stop user requesting a lot for email verification  otp',
        'category' => 'User > Email Verification',
    ],
    'USER_NORMAL_LOGIN_WARNING_EMAIL' => [
        'value' => USER_NORMAL_LOGIN_WARNING_EMAIL,
        'description' => 'Send email warning after successful login',
        'category' => 'User > Login',
    ],
    'USER_REGISTRATION_PASSWORD_CRITERIA' => [
        'value' => USER_REGISTRATION_PASSWORD_CRITERIA,
        'description' => 'Password pattern for user registration',
        'category' => 'User > Password',
    ],
];
const LOGIN_ATTEMPT_SETTINGS = [
    [
        'priority' => 0,
        'times' => 3,
        'duration' => 90,
        'blocking_duration' => 5 * 60,
    ], [
        'priority' => 0,
        'times' => 2,
        'duration' => 90,
        'blocking_duration' => 10 * 60,
    ], [
        'priority' => 0,
        'times' => 6,
        'duration' => 90,
        'blocking_duration' => 20 * 60,
    ],
];
const EMAIL_CONTENT_SETTINGS = [
    'FORGOT_PASSWORD_OTP_EMAIL' => [
        'subject' => 'Forget Password Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Ride To Future',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email',
    ],
    'VERIFICATION_EMAIL_OTP_EMAIL' => [
        'subject' => 'Email Verification Otp',
        'from' => 'info@r2f.com',
        'from_name' => 'Ride To Future',
        'body' => '<p>Hello, {{full_name}}</p><p>Your otp token to verify email is {{otp}}</p>',
        'variables' => 'full_name,otp',
        'variables_description' => 'full_name user full name, otp otp token',
        'type' => 'email',
    ],
    'USER_REGISTRATION_WELCOME_EMAIL' => [
        'subject' => 'Welcome to Janex',
        'from' => 'support@janex.com',
        'from_name' => 'Janex Support Team',
        'body' => <<<EOT
                <div>
                <div>Hello,&nbsp;{{full_name}}!</div>
                <div>&nbsp;</div>
                <div>We're excited to have you get started. First, you need to confirm your aacount by using the below code.</div>
                <div>&nbsp;</div>
                <h2 style="text-align: center;"><span style="background-color: #ffff00;">{{otp}}</span></h2>
                <p>This code code is valid only for 1 minute. You will need to request for another code if it expires.</p>
                <p>Cheers,</p>
                <p>Janex Support Team</p>
                </div>
            EOT,
        'variables'=>'full_name,otp',
        'variables_description'=>'full_name user full name, otp otp token',
        'type'=>'email',
    ],
    'SUSPICIOUS_LOGIN_ATTEMPT_EMAIL'=>[
        'subject'=>'Suspicious Login Attempt',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Someone tries to Login from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}} and login is {{status}} </p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'NORMAL_LOGIN_EMAIL'=>[
        'subject'=>'Successful Login',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Successful login from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}} and login is {{status}} </p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'TOO_MANY_LOGIN_ATTEMPTS_TEMPORARY_BLOCK_EMAIL'=>[
        'subject'=>'Too Many Login Attempt - Temporary Blocked',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Too many tries {{login_attempt_times}} times, You can try again in {{next_try_time}}</p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status,next_try_time,login_attempt_times',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'TOO_MANY_LOGIN_ATTEMPTS_PERMANENT_BLOCK_EMAIL'=>[
        'subject'=>'Too Many Login Attempt - Blocked',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>You tried too many times, your account is blocked</p><p>Please reach the support team.</p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status,next_try_time,login_attempt_times',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'PASSWORD_CHANGED_WARNING_EMAIL'=>[
        'subject'=>'Password Changed Warning',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Password changed from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}}. if it is not you please reach the support team  </p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'EMAIL_VERIFICATION_SUCCESS_EMAIL'=>[
        'subject'=>'Email Verified Successfully',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Your email is verified successfully from {{country}}-{{city}} / {{ip}} ip, {{platform}} - {{browser}}. if it is not you please reach the support team  </p>',
        'variables'=>'full_name,country,city,ip,platform,browser,status',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'USER_ACCOUNT_ACTIVATED_EMAIL'=>[
        'subject'=>'Account Activated',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Your account is activated by {{actor_full_name}}</p>',
        'variables'=>'full_name,actor_full_name',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
    ],
    'USER_ACCOUNT_DEACTIVATED_EMAIL'=>[
        'subject'=>'Account Deactivated',
        'from'=>'info@r2f.com',
        'from_name'=>'Ride To Future',
        'body'=>'<p>Hello, {{full_name}}</p><p>Your account is deactivated by {{actor_full_name}}</p>',
        'variables'=>'full_name,actor_full_name',
        'variables_description'=>'full_name user full name',
        'type'=>'email',
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
const USER_BLOCK_TYPE_BY_ADMIN = 'USER_BLOCK_TYPE_BY_ADMIN';
const USER_BLOCK_TYPES = [
    USER_BLOCK_TYPE_AUTOMATIC,
    USER_BLOCK_TYPE_BY_ADMIN,
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
const OTP_TYPE_EMAIL_VERIFICATION = 'OTP_EMAIL_VERIFICATION';
const OTP_TYPE_EMAIL_FORGOT_PASSWORD = 'OTP_EMAIL_FORGOT_PASSWORD';
const OTP_TYPES = [
    OTP_TYPE_EMAIL_VERIFICATION,
    OTP_TYPE_EMAIL_FORGOT_PASSWORD,
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
    LOGIN_ATTEMPT_STATUS_BLOCKED,
];

/**
 * media types
 */

const MEDIA_TYPE_VIDEO_STORAGE = "MEDIA_TYPE_VIDEO_STORAGE";
const MEDIA_TYPE_IMAGE_STORAGE = "MEDIA_TYPE_IMAGE_STORAGE";
const MEDIA_TYPE_VIDEOS = [
    MEDIA_TYPE_VIDEO_STORAGE,
];
const MEDIA_TYPE_IMAGES = [
    MEDIA_TYPE_IMAGE_STORAGE,
];
const MEDIA_TYPES = [
    MEDIA_TYPE_VIDEO_STORAGE,
    MEDIA_TYPE_IMAGE_STORAGE,
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
    'application/pdf',
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
