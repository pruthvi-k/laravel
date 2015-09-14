<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 7/9/15
 * Time: 3:50 PM
 */

Route::get('meta', 'Pruthvi\MetaGrabber\Http\Controllers\MetaGrabberController@index');
Route::post('meta/getContent', 'Pruthvi\MetaGrabber\Http\Controllers\MetaGrabberController@getContent');
Route::post('meta/getImages', 'Pruthvi\MetaGrabber\Http\Controllers\MetaGrabberController@getImages');