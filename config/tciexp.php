<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default TciExpApi Credentilas
    |--------------------------------------------------------------------------
    |
    | Here you can set the default TciExpApi credentilas. However, you can pass the credentials while connecting to TciExpApi client
    |
    */

    'dev_wsdl' => env('TCI_EXPRESS_DEV_URL', 'https://customerapitesting.tciexpress.in/ServiceEnquire.asmx?WSDL'),
    'prod_wsdl' => env('TCI_EXPRESS_PROD_URL', 'https://customerapi.tciexpress.in/ServiceEnquire.asmx?WSDL'),

    'credentials' => [
        'username' => env('TCI_EXPRESS_USERNAME', 'username'),
        'password' => env('TCI_EXPRESS_PASSWORD', 'secret')
    ]
];
