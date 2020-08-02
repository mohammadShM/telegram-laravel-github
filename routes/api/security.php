<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// region authenticated routes =========================================================================================
// region for auth =====================================================================================================
Route::group(['middleware' => ['auth:api'], 'as' => ''], function (Router $router) {
    // for get all settings
    $router->get('/', [
        'as' => 'get',
        'uses' => 'SecurityController@get',
    ]);
    // for blocked user
    $router->post('/{user}/block', [
        'as' => 'block',
        'uses' => 'SecurityController@blockUser',
    ]);
    // for unblocked user
    $router->post('/{user}/unblock', [
        'as' => 'unblock',
        'uses' => 'SecurityController@unblockUser',
    ]);
    // for group for share phone number =====================
    $router->group(['prefix' => '/share-phone-number'], function (Router $router) {
        // for allow share phone number
        $router->match(['post', 'put'], '', [
            'as' => 'update-share-phone-number',
            'uses' => 'SecurityController@updateSharePhoneNumber',
        ]);
        // for allow share phone number exception
        $router->match(['post', 'put'], '-exceptions', [
            'as' => 'share-phone-number-exceptions',
            'uses' => 'SecurityController@updateSharePhoneNumberExceptions',
        ]);
    });
    // for group for last seen =====================
    $router->group(['prefix' => '/last-seen'], function (Router $router) {
        // for update last seen
        $router->match(['post', 'put'], '', [
            'as' => 'update-last-seen',
            'uses' => 'SecurityController@updateLastSeen',
        ]);
        // for update last seen exception
        $router->match(['post', 'put'], '-exceptions', [
            'as' => 'last-seen-exceptions',
            'uses' => 'SecurityController@updateLastSeenExceptions',
        ]);
    });
    // for group for forward message =====================
    $router->group(['prefix' => '/forward-message'], function (Router $router) {
        // for update forward message
        $router->match(['post', 'put'], '', [
            'as' => 'update-forward-message',
            'uses' => 'SecurityController@updateForwardMessage',
        ]);
        // for update forward message exception
        $router->match(['post', 'put'], '-exceptions', [
            'as' => 'forward-message-exceptions',
            'uses' => 'SecurityController@updateForwardMessageExceptions',
        ]);
    });
    // for group for profile photo =====================
    $router->group(['prefix' => '/profile-photo'], function (Router $router) {
        // for update profile photo
        $router->match(['post', 'put'], '', [
            'as' => 'update-profile-photo',
            'uses' => 'SecurityController@updateProfilePhoto',
        ]);
        // for update profile photo exception
        $router->match(['post', 'put'], '-exceptions', [
            'as' => 'profile-photo-exceptions',
            'uses' => 'SecurityController@updateProfilePhotoExceptions',
        ]);
    });
    // for group for add to groups =====================
    $router->group(['prefix' => '/add-to-groups'], function (Router $router) {
        // for update add to group
        $router->match(['post', 'put'], '', [
            'as' => 'update-add-to-groups',
            'uses' => 'SecurityController@updateAddToGroups',
        ]);
        // for update add to group exception
        $router->match(['post', 'put'], '-exceptions', [
            'as' => 'add-to-groups-exceptions',
            'uses' => 'SecurityController@updateAddToGroupsExceptions',
        ]);
    });
});
