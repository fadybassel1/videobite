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
    
    // notifications routes.
    Route::get('/notifications', 'NotificationsController@unread')->name('notifications');
    Route::get('/notifications/markallasread', 'NotificationsController@markallasread')->name('notifications.markallasread');
    Route::get('/notifications/viewall', 'NotificationsController@viewall')->name('notifications.viewall');
});


Route::group(['middleware' => ['role:admin'] , 'prefix'=>'admin'], function () {
   
    Route::get('/dashboard', 'Admin\HomeController@index')->name('admin.dashboard');
    Route::post('/request/changeStatus', 'RequestController@changeStatus')->name('requestChangeStatus');

});

/*
NOTIFICATIONS TEST
///////////////////
use App\models\Video;
use App\Notifications\DataUpdated;
Route::get('/notification', function () {
    $video = Video::find(2);
    return (new DataUpdated($video))
                ->toMail($video->user, $video);
});*/


// Route::get('/assignrole', function (){
//     Permission::create(['name' => 'accept requests']);
//     Permission::create(['name' => 'view requests']);
//     $role = Role::create(['name' => 'admin']);
//     $role->givePermissionTo(['accept requests','view requests']);
//     auth()->user()->assignRole('admin');
// });