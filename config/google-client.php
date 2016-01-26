<?php

/*
 * This file is part of L5 Google Client
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */
    'default'     => env('GOOGLE_API_CLIENT_CONNECTION', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Google Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */
    'connections' => [
        /*
         * You can use the auto-configuration when you're on AppEngine
         * or ComputeEngine in general. This method fetches all needed credentials
         * from the metadata service.
         *
         * @see https://cloud.google.com/appengine/docs/managed-vms/custom-runtimes#accessing_cloud_platform_services
         * @see https://cloud.google.com/compute/docs/metadata
         */
        'auto' => [
            'method'             => 'metadata',
            'service_account_id' => env('GOOGLE_API_CLIENT_AUTO_ACCOUNT_ID', 'default')
        ],

        /*
         * You can use the recommended JSON key method, by choosing 'json' as method.
         * JSON token files have all the required information contained in the hash.
         */
        'json' => [
            'method' => 'json',
            'file'   => env('GOOGLE_API_CLIENT_JSON_FILE', storage_path('google_service_account.json')),
            'scopes' => [],
        ],

        /*
         * You can use a legacy p12 certificate, by choosing 'p12' as method.
         * This is a legacy authentication method and not recommended anymore.
         *
         * However, if you want to use it, you need to know the service account id
         * which it is associated with.
         */
        'p12'  => [
            'method'             => 'p12',
            'file'               => env('GOOGLE_API_CLIENT_P12_FILE', storage_path('google_service_account.p12')),
            'scopes'             => [],
            'service_account_id' => env('GOOGLE_API_CLIENT_P12_ACCOUNT_ID', 'name@project-id.iam.gserviceaccount.com'),
            'password'           => env('GOOGLE_API_CLIENT_P12_PASSWORD', 'notasecret')
        ]
    ]
];
