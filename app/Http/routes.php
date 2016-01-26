<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('private', function () {
        $file = Storage::disk('gcs')->put('private.gif', file_get_contents(storage_path('app/private.gif')));

        return dd($file);
    });
    Route::get('public', function () {

        if (Storage::disk('gcs')->exists('clear.gif')) {
            Storage::disk('gcs')->delete('clear.gif');
        }
        if (Storage::disk('gcs')->exists('clear-copy.gif')) {
            Storage::disk('gcs')->delete('clear-copy.gif');
        }

        $file = Storage::disk('gcs')->put(
            'clear.gif',
            file_get_contents(storage_path('app/clear.gif')),
            \Illuminate\Contracts\Filesystem\Filesystem::VISIBILITY_PRIVATE
        );

        Storage::disk('gcs')->copy('clear.gif', 'clear-copy.gif');
        Storage::disk('gcs')->setVisibility('clear-copy.gif', \Illuminate\Contracts\Filesystem\Filesystem::VISIBILITY_PUBLIC);
        Storage::disk('gcs')->setVisibility('clear-copy.gif', \Illuminate\Contracts\Filesystem\Filesystem::VISIBILITY_PRIVATE);

        return dd($file);
    });

    Route::get('buckets', function() {
        // Authenticate your API Client
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);

        $storage = new Google_Service_Storage($client);

        /**
         * Google Cloud Storage API request to retrieve the list of buckets in your project.
         */
        $buckets = $storage->buckets->listBuckets('silver-wall-120109');

        return $buckets;
    });
});
