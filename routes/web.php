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

Route::get('/', function (\Illuminate\Http\Request $request) {
        return view('index');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name("home");
Route::post('/home/image-upload', 'HomeController@imageUpload')->name("img_up");
Route::post('/platform', 'HomeController@setPlatform')->name("set-platform");

Route::post('/search', function(){
    return back()->with('message','Sorry , 暂没有全局搜索功能！')->with("status",201);
});

Route::get('/word/init',"WordController@initKeyWords");
Route::get('/word/solve/{id}',"WordController@solve");
Route::post('/lang/getCreateLangOfTableTbodyTr',"LangController@getCreateLangOfTableTbodyTr")->name('get-create-lang-tr');
Route::resource("word","WordController");
Route::resource("lang","LangController");
Route::resource("permissions","PermissionController");
Route::resource("users","UserController");
Route::resource("roles","RoleController");
