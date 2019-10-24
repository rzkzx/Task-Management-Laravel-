<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => ['token.auth']], function(){

        Route::get('auth/logout', 'AuthController@logout');
        
        Route::resource('board', 'BoardController', ['only' => ['index','store']]);
        Route::group(['middleware' => ['token.member']], function(){
            Route::resource('board', 'BoardController', ['except' => ['index','store','destroy']]);
            Route::group(['middleware' => ['token.creator']], function(){
                Route::resource('board', 'BoardController@store', ['only' => ['destroy']]);
            });
            //Prefix Board
            Route::group(['prefix' => 'board/{boardId}'],function (){
                //Member Route
                Route::post('member', 'BoardController@addMember');
                Route::delete('member/{id}', 'BoardController@deleteMember');

                //List Route
                Route::resource('list', 'ListController');
                Route::post('list/{listId}/right','ListController@moveRight')->name('list.right');
                Route::post('list/{listId}/left','ListController@moveLeft')->name('list.left');  

                //Prefix List
                Route::group(['prefix' => 'list/{listId}'], function(){
                    Route::resource('card', 'CardController');

                    //card move route
                    Route::post('card/{cardId}/up', 'CardController@moveUp');
                    Route::post('card/{cardId}/down', 'CardController@moveDown');
                    Route::post('card/{cardId}/move/{toList}', 'CardController@moveCard');
                });
            });
        });
    });
});