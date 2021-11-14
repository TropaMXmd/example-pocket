<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/pocket', ['as' => 'create-pocket', 'uses' => 'PocketController@store']);
Route::get('/pockets/{pocketId}/contents', ['as' => 'fetch-pocket-content', 'uses' => 'PocketController@getContentsByPocketId']);

Route::post('/pockets/{pocketId}/content', ['as' => 'create-content', 'uses' => 'ContentController@store']);
//Route::get('/pockets/{id}/contents', ['as' => 'fetch-pocket-content', 'uses' => 'ContentController@getContentsByPocketId']);
Route::get('/contents', ['as' => 'fetch-keyword-content', 'uses' => 'ContentController@getContentsByKeywords']);
Route::delete('/contents/{contentId}', ['as' => 'delete-content', 'uses' => 'ContentController@destroy']);
