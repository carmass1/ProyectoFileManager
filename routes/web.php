<?php


// symlink('/home3/mcontrol/Laravel_Gestordearchivos/storage/app/public', '/home3/mcontrol/pruebas.mcontrolhelpdesk.com/storage');

// // Password Reset Routes...
// Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Authentication Routes...

Route::get('/', function () {
	return view('auth.login');
});

Auth::routes();

// Rewritte Routes...
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->middleware('super')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->middleware('super');

// Route::get('/home', 'HomeController@index')->name('home');

// ADMIN

Route::get('/super', 'Admin\AdminController@index')->middleware('auth', 'admin');
Route::get('/admin', 'Admin\AdminController@index')->middleware('auth', 'admin')->name('admin');
Route::get('/cliente', 'FrontClientController@index')->middleware('auth');

Route::post('/newfolder/{name}/{parent}', 'Admin\FolderController@createFolder')->middleware('admin');
Route::post('/renamefolder/{newname}/{folder}', 'Admin\FolderController@renameFolder')->middleware('admin');
Route::post('/deletefolder/{folder}', 'Admin\FolderController@deleteFolder')->middleware('admin');
Route::post('/renamefile/{newname}/{file}', 'Admin\FileController@renameFile')->middleware('admin');

Route::post('/listfolders/{folder}', 'Admin\FolderController@listFolders')->middleware('auth');
Route::post('/listfiles/{folder}', 'Admin\FileController@listFiles')->middleware('auth');
Route::post('/detailsfile/{file}', 'Admin\FileController@getDetailsFile')->middleware('auth');
Route::post('/uploadfiles', 'Admin\AdminController@uploadFile')->name('admin.uploadfile')->middleware('admin');

Route::post('/deletefile/{file}', 'Admin\AdminController@deleteFile')->name('admin.deletefile')->middleware('super');

Route::prefix('admin')->name('admin.')->group(function () {

	// CLIENT
	Route::resource('/client', 'Admin\ClientController', ['except' => ['destroy']])->middleware('admin');
	Route::post('/client/{id}', 'Admin\ClientController@show')->middleware('admin');
	Route::post('/client/{id}/delete', 'Admin\ClientController@destroy')->middleware('admin');
	Route::post('/client/{id}/update', 'Admin\ClientController@update')->middleware('admin')->name('client.update');

	// USER
	Route::resource('/user', 'Admin\UserController', ['except' => ['destroy', 'show', 'store']])->middleware('super');
	Route::post('/user/{id}/delete', 'Admin\UserController@destroy')->middleware('super');
	Route::post('/user/{id}/update', 'Admin\UserController@update')->middleware('super')->name('user.update');
});



