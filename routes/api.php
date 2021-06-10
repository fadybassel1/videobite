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

Route::post('VideoSummaryUpdate', 'VideoController@updateSummary');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
// ->middleware('auth:api')
Route::get('/verified-only', function(Request $request){

    dd('your are verified', $request->user()->name);
})->middleware('auth:api','verified');

Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'], function () {
   
    Route::get('/home', 'HomeControllerApi@index')->name('home');
    
    //video routes
    Route::get('/video/{id}', 'VideoControllerApi@show')->name('viewVideo');
    Route::resource('files', VideoControllerApi::class);
    
    // // requests routes.
    Route::get('/requestEdit/{id}', 'RequestControllerApi@create')->name('RequestEdit');
    Route::Post('/Request/store', 'RequestControllerApi@store')->name('RequestStore');
    Route::get('/Request/videoView/{id}', 'RequestControllerApi@videoRequestsView')->name('VideoRequestsView');
    
    // // summary routes.
    Route::get('/summary/view/{id}', 'SummaryControllerApi@view')->name('summaryView');
    Route::get('/summary/update/{id}', 'SummaryControllerApi@update')->name('summaryUpdate');
    
    // // notifications routes.
    // Route::get('/notifications', 'NotificationsController@unread')->name('notifications');
    // Route::get('/notifications/markallasread', 'NotificationsController@markallasread')->name('notifications.markallasread');
    // Route::get('/notifications/viewall', 'NotificationsController@viewall')->name('notifications.viewall');
    Route::post('/logout', 'Api\AuthController@logout');
});

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@reset');


Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');