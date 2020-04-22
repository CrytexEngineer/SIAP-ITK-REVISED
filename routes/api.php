<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'v1/mobile'], function () {
    Route::resource('kelas', 'Mobile\KelasController', [
        'except' => ['create', 'edit']]);
    Route::resource('user', 'Mobile\UserProfileController', [
        'except' => ['create', 'edit']]);
    Route::POST('validate', 'Mobile\ValidatorController@validation');

    Route::POST('validate/register_meeting', 'Mobile\MeetingController@registerStudent');
    Route::GET('profile/{id}', 'Mobile\UserProfileController@show');

    Route::POST('login', 'Mobile\LoginController@login');
    Route::POST('password/create', 'Mobile\PasswordResetController@create');
    Route::GET('password/find/{token}', 'Mobile\PasswordResetController@find');
    Route::POST('password/reset', 'Mobile\PasswordResetController@reset');

});
