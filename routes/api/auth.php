<?php

use Illuminate\Support\Facades\Route;

// 1=>code(create generate code for user),2=>login(set code for login user);
// region none authenticated routes ====================================================================================
// region for auth =====================================================================================================
Route::group(['as' => 'auth.'], function () {
    Route::post('/code', [
        'as' => 'code',
        'uses' => 'AuthController@generateCode',
    ]);
    Route::post('/login', [
        'as' => 'login',
        'uses' => 'AuthController@login',
    ]);
});
