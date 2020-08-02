<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// region authenticated routes =========================================================================================
// region for auth =====================================================================================================
Route::group(['middleware' => ['auth:api'], 'as' => 'contact.'], function (Router $router) {
    // for add contact by search username or mobile
    $router->post('/', [
        'as' => 'create',
        'uses' => 'ContactController@create',
    ]);
    // for get all contact
    $router->get('/', [
        'as' => 'list',
        'uses' => 'ContactController@list',
    ]);
    // for edit contact
    $router->match(['post', 'put'], '/{contact}', [
        'as' => 'update',
        'uses' => 'ContactController@update',
    ]);
    // for delete contact by search username or mobile
    $router->delete('/{contact}', [
        'as' => 'delete',
        'uses' => 'ContactController@delete',
    ]);
});
