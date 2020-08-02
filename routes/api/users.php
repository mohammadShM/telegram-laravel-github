<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// region authenticated routes =========================================================================================
// region for auth =====================================================================================================
Route::group(['middleware' => ['auth:api'], 'as' => 'user.'], function (Router $router) {
    // group for update user ==============================
      $router->group(['prefix' => '/update'], function (Router $router) {
          // for update user's profile =====
          $router->put('/', [
              'as' => 'update',
              //'middleware' => ['auth:api'],
              'uses' => 'UserController@update',
          ]);
          // for update mobile phone =====
          $router->put('-mobile', [
              'as' => 'update-mobile',
              //'middleware' => ['auth:api'],
              'uses' => 'UserController@updateMobile',
          ]);
          // for check code verify for update mobile phone =====
          $router->post('-mobile', [
              'as' => 'update-mobile-verify',
              //'middleware' => ['auth:api'],
              'uses' => 'UserController@updateMobileVerify',
          ]);
      });
    // for check username exists =====
    $router->get('/check-username/{username}', [
        'as' => 'check-username',
        //'middleware' => ['auth:api'],
        'uses' => 'UserController@checkUsername',
    ]);
    // group for profile picture ==============================
    $router->group(['prefix' => '/profile-picture'], function (Router $router) {
        // for upload image for user's profile =====
        $router->match(['put', 'post'], '/', [
            'as' => 'upload-profile-picture',
            'uses' => 'UserController@uploadProfilePicture',
        ]);
        // for delete image for user's profile =====
        $router->delete('/{name}', [
            'as' => 'delete-profile-picture',
            'uses' => 'UserController@deleteProfilePicture',
        ]);
    });
    // for search in username
    $router->get('/find-by-username', [
        'as' => 'find-by-username',
        'uses' => 'UserController@findByUsername',
    ]);
});
