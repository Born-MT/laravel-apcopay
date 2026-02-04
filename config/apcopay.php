<?php

return [
    /**
     * ApcoPay Environment
     */
    'env' => env('APCO_PAY_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | ApcoPay Credentials
    |--------------------------------------------------------------------------
    |
    | Your ApcoPay credentials. These should typically be stored in the
    | application's .env file and read from here.
    |
    */
    'username' => env('APCO_PAY_USERNAME', ''),
    'password' => env('APCO_PAY_PASSWORD', ''),
    'pid' => env('APCO_PAY_PID', ''),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    */
    'base_url' => env('APCOPAY_BASE_URL', 'https://www.apsp.biz/GPG/RESTAPI/api/OnlinePayments'),
    'sandbox_base_url' => env('APCOPAY_SANDBOX_BASE_URL', 'https://www.apsp.biz/GPGTest/RESTAPI/api/OnlinePayments'),
];
