<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
//All user list show
Route::get('list','API\UserController@index');
//create Role
Route::post('role','API\RoleController@test');
//Single user details show by id
Route::post('single','API\UserController@singleUser');


Route::group(['middleware' => 'auth:api'], function(){
    //single login user details
Route::post('details', 'API\UserController@details');
//Add user with assigning role
Route::post('add','API\UserController@add');
//Update User and have to change role from user
Route::post('update', 'API\UserController@updateUser');
//profile updated
Route::post('createdprofile', 'API\ProfileController@createProfile');
//Single profile showing
Route::post('singleProfile','API\ProfileController@singleProfile');



});
