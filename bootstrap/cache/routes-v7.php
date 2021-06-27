<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/docs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'scribe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/docs.postman' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'scribe.postman',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/docs.openapi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'scribe.openapi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7ZXIubG7izfwWH06',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.register',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/is_username_exists' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.is-username-exists',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/is_email_exists' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.is-email-exists',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.login',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/get_email_verify_token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.ask-for-email-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/verify_email_token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.verify-email-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/forgot_password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.forgot-password',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/reset_forgot_password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auth.reset-forgot-password',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ping' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ping',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'current-user',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/generate2fa_secret' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => '2fa-secret',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/generate2fa_enable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => '2fa-enable',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/generate2fa_disable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => '2fa-disable',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/kyc/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kyc-upload-file',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/activate_or_deactivate_user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activate-or-deactivate-user-account',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/verify_email_user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verify-email-user-account',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/user_email_verification_history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user-email-verification-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/user_login_history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user-login-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/user_block_history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user-block-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/user_password_history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/api/gateway(?|/multi(?:/(.*))?(*:38)|(?:/(.*))?(*:55)))/?$}sDu',
    ),
    3 => 
    array (
      38 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::R0STdSaZZmV9KbOK',
            'any' => NULL,
          ),
          1 => 
          array (
            0 => 'any',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      55 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7O0CQIExeDkZdbku',
            'any' => NULL,
          ),
          1 => 
          array (
            0 => 'any',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'scribe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'docs',
      'action' => 
      array (
        'middleware' => 
        array (
        ),
        'uses' => '\\Knuckles\\Scribe\\Http\\Controller@webpage',
        'controller' => '\\Knuckles\\Scribe\\Http\\Controller@webpage',
        'namespace' => '\\Knuckles\\Scribe\\Http',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'scribe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'scribe.postman' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'docs.postman',
      'action' => 
      array (
        'middleware' => 
        array (
        ),
        'uses' => '\\Knuckles\\Scribe\\Http\\Controller@postman',
        'controller' => '\\Knuckles\\Scribe\\Http\\Controller@postman',
        'namespace' => '\\Knuckles\\Scribe\\Http',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'scribe.postman',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'scribe.openapi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'docs.openapi',
      'action' => 
      array (
        'middleware' => 
        array (
        ),
        'uses' => '\\Knuckles\\Scribe\\Http\\Controller@openapi',
        'controller' => '\\Knuckles\\Scribe\\Http\\Controller@openapi',
        'namespace' => '\\Knuckles\\Scribe\\Http',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'scribe.openapi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::7ZXIubG7izfwWH06' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'generated::7ZXIubG7izfwWH06',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@register',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@register',
        'as' => 'auth.register',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.is-username-exists' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/is_username_exists',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@isUsernameExists',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@isUsernameExists',
        'as' => 'auth.is-username-exists',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.is-email-exists' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/is_email_exists',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@isEmailExists',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@isEmailExists',
        'as' => 'auth.is-email-exists',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.login' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'login_attempt',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@login',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@login',
        'as' => 'auth.login',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.ask-for-email-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/get_email_verify_token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@askForEmailVerificationOtp',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@askForEmailVerificationOtp',
        'as' => 'auth.ask-for-email-otp',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.verify-email-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/verify_email_token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@verifyEmailOtp',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@verifyEmailOtp',
        'as' => 'auth.verify-email-otp',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.forgot-password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/forgot_password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@forgotPassword',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@forgotPassword',
        'as' => 'auth.forgot-password',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'auth.reset-forgot-password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/reset_forgot_password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@resetForgetPassword',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@resetForgetPassword',
        'as' => 'auth.reset-forgot-password',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@logout',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@logout',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'ping' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/ping',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@ping',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@ping',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'ping',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'current-user' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@getAuthUser',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\AuthController@getAuthUser',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'current-user',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    '2fa-secret' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/generate2fa_secret',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@generate2faSecret',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@generate2faSecret',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => '2fa-secret',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    '2fa-enable' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/generate2fa_enable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@enable2fa',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@enable2fa',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => '2fa-enable',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    '2fa-disable' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/generate2fa_disable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => '2fa',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@disable2fa',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\LoginSecurityController@disable2fa',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => '2fa-disable',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'kyc-upload-file' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/kyc/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Front\\KYCController@uploadDocuments',
        'controller' => 'R2FUser\\Http\\Controllers\\Front\\KYCController@uploadDocuments',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'kyc-upload-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'activate-or-deactivate-user-account' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/activate_or_deactivate_user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@activateOrDeactivateUserAccount',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@activateOrDeactivateUserAccount',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'activate-or-deactivate-user-account',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'verify-email-user-account' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/verify_email_user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@verifyUserEmailAccount',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@verifyUserEmailAccount',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'verify-email-user-account',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user-email-verification-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/user_email_verification_history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@emailVerificationHistory',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@emailVerificationHistory',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'user-email-verification-history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user-login-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/user_login_history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@loginHistory',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@loginHistory',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'user-login-history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user-block-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/user_block_history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@blockHistory',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@blockHistory',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'user-block-history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/user_password_history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
          3 => 'auth:sanctum',
          4 => 'email_verified',
          5 => 'role:admin',
        ),
        'uses' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@passwordHistory',
        'controller' => 'R2FUser\\Http\\Controllers\\Admin\\UserController@passwordHistory',
        'namespace' => 'R2FUser\\Http\\Controllers',
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'password-history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::R0STdSaZZmV9KbOK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'api/gateway/multi/{any?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FGateway\\Http\\Controllers\\GatewayController@multiAggregate',
        'controller' => 'R2FGateway\\Http\\Controllers\\GatewayController@multiAggregate',
        'namespace' => 'R2FGateway\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::R0STdSaZZmV9KbOK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'any' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::7O0CQIExeDkZdbku' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'api/gateway/{any?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'user_activity',
          2 => 'block_user',
        ),
        'uses' => 'R2FGateway\\Http\\Controllers\\GatewayController@aggregate',
        'controller' => 'R2FGateway\\Http\\Controllers\\GatewayController@aggregate',
        'namespace' => 'R2FGateway\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::7O0CQIExeDkZdbku',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'any' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
  ),
)
);
