<?php

use Illuminate\Support\Facades\Route;

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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//video routes
Route::get('/video/{id}', 'VideoController@show')->middleware('auth')->name('viewVideo');
Route::resource('files', VideoController::class);

// requests routes.
Route::get('/requestEdit/{id}', 'RequestController@create')->name('RequestEdit');
Route::Post('/Request/store', 'RequestController@store')->name('RequestStore');
Route::get('/Request/videoView/{id}', 'RequestController@videoRequestsView')->name('VideoRequestsView');

// summary routes.
Route::get('/summary/view/{id}', 'SummaryController@view')->name('summaryView');



// Route::get('/assignrole', function (){
//     Permission::create(['name' => 'upload videos']);
//     Permission::create(['name' => 'make edit request']);
//     $role = Role::create(['name' => 'user']);
//     $role->givePermissionTo(['upload videos','make edit request']);
//     auth()->user()->assignRole('user');
// });