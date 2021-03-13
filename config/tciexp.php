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

    'debug_wsdl' => env('TCI_EXPRESS_DEBUG_URL', 'https://customerapitesting.tciexpress.in/ServiceEnquire.asmx?WSDL'),
    'production_wsdl' => env('TCI_EXPRESS_PRODUCTION_URL', 'https://customerapi.tciexpress.in/ServiceEnquire.asmx?WSDL'),

    'credentials' => [
        'username' => env('TCI_EXPRESS_USERNAME', 'username'),
        'password' => env('TCI_EXPRESS_PASSWORD', 'secret')
    ],


   /*
    |--------------------------------------------------------------------------
    | Default output response type
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the output response you need.
    |
    | Supported: "collection" , "object", "array"
    |
    */

    'responseType' => 'collection',
];
