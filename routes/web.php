<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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
    return redirect('login');
});

Auth::routes();



// user routes.

Route::group(['middleware' => ['role:user']], function () {
   
    Route::get('/home', 'HomeController@index')->name('home');
    
    //video routes
    Route::get('/video/{id}', 'VideoController@show')->name('viewVideo');
    Route::resource('files', VideoController::class);
    
    // requests routes.
    Route::get('/requestEdit/{id}', 'RequestController@create')->name('RequestEdit');
    Route::Post('/Request/store', 'RequestController@store')->name('RequestStore');
    Route::get('/Request/videoView/{id}', 'RequestController@videoRequestsView')->name('VideoRequestsView');
    
    // summary routes.
    Route::get('/summary/view/{id}', 'SummaryController@view')->name('summaryView');
    Route::get('/summary/update/{id}', 'SummaryController@update')->name('summaryUpdate');
});



// admin routes.

Route::group(['middleware' => ['role:admin'] , 'prefix'=>'admin' , 'namespace'=>'Admin'], function () {
   
    Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

});




// Route::get('/assignrole', function (){
//     Permission::create(['name' => 'accept requests']);
//     Permission::create(['name' => 'view requests']);
//     $role = Role::create(['name' => 'admin']);
//     $role->givePermissionTo(['accept requests','view requests']);
//     auth()->user()->assignRole('admin');
// });

