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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create',function(){
    return view('create');
});

Route::get('/game','MainController@index');

Route::get('/wait','MainController@wait')->name('game.wait');

Route::get('/join','MainController@onJoinGame')->name('game.join');

Route::post('/create/game','MainController@onCreateGame')->name('game.create');
