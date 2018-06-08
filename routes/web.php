<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    die('pokemath api');
});

Route::group(['namespace' => '\User\Auth'], function(){
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/avatars/count', 'MiscController@getAvatarsCount');    
});

Route::group(['namespace' => '\User\Api', 'middleware' => 'auth:api'], function() {
    Route::get('/stage/{stage}/pokemons', 'StageController@getStagePokemons');
    Route::get('/stages/concise', 'StageController@getAllStagesConcise');
    
    Route::get('/user/pokedex', 'UserController@getUserPokedex');
    Route::get('/user/game-component', 'UserController@getGameComponent');
    Route::post('/user/attack/update', 'UserController@updateAttack');
    Route::post('/battle/{pokemon}/win', 'UserController@updateUserLog'); 
    
});