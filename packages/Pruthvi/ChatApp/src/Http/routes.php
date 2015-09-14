<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 25/8/15
 * Time: 6:10 PM
 */

Route::get('api/chat-rooms', 'ChatRoomController@getAll');
Route::post('api/chat-rooms', 'ChatRoomController@create');

Route::get('api/messages/{chatRoom}', 'MessageController@getByChatRoom');
Route::post('api/messages/{chatRoom}', 'MessageController@createInChatRoom');

Route::post('api/messages/{lastMessageId}/{chatRoom}', 'MessageController@getUpdates');

Route::post('api/login/pruthvi', 'UsersController@loginPruthvi');
Route::post('api/login/nishi', 'UsersController@loginNishi');

Route::get('testChat', function(){
    echo "hello from package";
});
