<?php

use App\Http\Requests\Chat\UpdateChatPermissionsForParticipantRequest;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// region authenticated routes =========================================================================================
// region for auth =====================================================================================================
Route::group(['middleware' => ['auth:api'], 'as' => 'chat.'], function (Router $router) {
    // for create chat =====
    $router->post('/', [
        'as' => 'create',
        'uses' => 'ChatController@create',
    ]);
    // for get chat =====
    $router->get('/{chat}', [
        'as' => 'show',
        'uses' => 'ChatController@show',
    ]);
    // for update chat =====
    $router->put('/{chat}', [
        'as' => 'update',
        'uses' => 'ChatController@update',
    ]);
    // for delete photo for profile chat =====
    $router->delete('/{chat}/photo/{photo_id}', [
        'as' => 'delete',
        'uses' => 'ChatController@deletePhoto',
    ]);
    // for upload photo for profile chat =====
    $router->post('/upload-photo', [
        'as' => 'upload-photo',
        'uses' => 'ChatController@uploadPhoto',
    ]);
    // group for participants =====
    $router->group(['prefix' => '{chat}/participants', 'as' => 'participants.'], function (Router $router) {
        // for show  list participant in chat =====
        $router->get('/', [
            'as' => 'list',
            'uses' => 'ChatController@listParticipants',
        ]);
        // for add user in participants chat =====
        $router->post('/', [
            'as' => 'add',
            'uses' => 'ChatController@addParticipants',
        ]);
        // for delete user in participants chat =====
        $router->delete('/{user}', [
            'as' => 'remove',
            'uses' => 'ChatController@removeParticipants',
        ]);
        // for user promote to admin in participants chat =====
        $router->post('/{user}/promote-to-admin', [
            'as' => 'promote-to-admin',
            'uses' => 'ChatController@promoteParticipantToAdmin',
        ]);
        // for permissions in participant
        $router->group(['prefix' => '/{user}/permissions', 'as' => 'permissions'], function (Router $router) {
            // for update user permission in participants chat =====
            $router->match(['put', 'post'], '/', [
                'as' => 'update',
                'uses' => 'ChatController@updatePermissionsForParticipant',
            ]);
            // for get user permission in participants chat =====
            $router->get('/', [
                'as' => 'show',
                'uses' => 'ChatController@showParticipantPermissions',
            ]);
        });
    });
    // group for permissions =====
    $router->group(['prefix' => '{chat}/permissions', 'as' => 'permissions.'], function (Router $router) {
        // for update user in permissions chat =====
        $router->match(['put', 'post'], '/', [
            'as' => 'update',
            'uses' => 'ChatController@updatePermissions',
        ]);
    });
});
