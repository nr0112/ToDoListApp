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

// 'auth'について：kernel.phpに実際のクラスと名前の定義あり
Route::group(['middleware' => 'auth'], function() {

    //ここに記述したルートは全て認証(middleware)を通過する
    // ホーム画面
    Route::get('/', 'HomeController@index')->name('home');

    //ルートモデルバインディング
    //ミドルウェアを介して作成したポリシーを使用
    //Folderモデル→FolderPolicyポリシーのviewメソッドが認可に使用される
    Route::group(['middleware' => 'can:view,folder'], function() {   
        Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');
        
        Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', 'TaskController@create');
        
        Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');
        
        // Route::post('/folders/{id}/tasks/{task_id}/delete', 'TaskController@destroy')->name('tasks.delete');
        Route::post('/folders/{folder}/tasks/{task}/delete', 'TaskController@destroy')->name('tasks.delete');
        
    });
    
    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');
    
    Route::get('/folders/{folder}/edit', 'FolderController@showEditForm')->name('folders.edit');
    Route::post('/folders/{folder}/edit', 'FolderController@edit');
    
    
    Route::get('/folders/{folder}/delete', 'FolderController@showConfirmDestroy')->name('folders.delete');
    Route::post('/folders/{folder}/delete', 'FolderController@destroy');

});

Route::get('/folders/{folder}/tasks/{task}/detailed', 'TaskController@showDetailedlTask')->name('tasks.detailed');

// 会員登録機能
Auth::routes();