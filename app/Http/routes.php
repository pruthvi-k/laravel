<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//use Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('map', function () {
    return view('map');
});
Route::get('modal', function () {
    return view('modal');
});


Route::post('geo_location', 'GeoLocationController@create');

get('broadcast/{name}', function($name){
    event(new \App\Events\UserHasRegistered($name));
    return "Done";
});

Route::get('carousel', '\Pruthvi\Carousel\Controllers\CarouselController@index');