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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** difine a new route */
// Route::get('/status' , function() {
//     return response()->json(['status' => 'ok']);
// });

/** define a group of rouets */
// Route::group(function () {
//     Route::get('/status' , function() {
//     return response()->json(['status' => 'ok']);
//     });
// });

/** define group of routes with the prefix v1 */
/** http://localhost:8000/api/v1/status */
// Route::group(['prefix' => 'v1'], function () {
//     Route::get('/status' , function() {
//             return response()->json(['status' => 'ok']);
//             });
// });

/** define group of routes with prefix v1 , and a prefix name to the routes : api.v1. */
// Route::prefix('v1')->name('api.v1.')->group(function () {
//         Route::get('/status' , function() {
//                 return response()->json(['status' => 'ok']);
//                 })->name('status');
// });

/** define a new api resource routes , and add ->namespace('Api\V1') to avoid the conflict with controller PostCommentController */
Route::prefix('v1')->name('api.v1.')->namespace('App\Http\Controllers\Api\V1')->group(function () {
        
        
        Route::get('/status' , function() {
                return response()->json(['status' => 'ok']);
        })->name('status');

        Route::post('/login',[App\Http\Controllers\Api\V1\ApiAuthController::class,'login']);
        
        Route::apiResource('posts.comments','PostCommentController'); /** create route of all api actions of PostCommentController */
        

});



