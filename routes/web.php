<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('company', 'App\Http\Controllers\CompanyController');
	Route::resource('types', 'App\Http\Controllers\TypeController');
	Route::resource('employees', 'App\Http\Controllers\EmployeeController');
	Route::resource('marketplace', 'App\Http\Controllers\ItemController');
	Route::resource('forms', 'App\Http\Controllers\FormController');
	Route::resource('consultations', 'App\Http\Controllers\ConsultationController');
	Route::resource('services', 'App\Http\Controllers\ServiceController');
	Route::resource('services.prescriptions', 'App\Http\Controllers\PrescriptionController');
	Route::resource('services.diary', 'App\Http\Controllers\DiaryController');

	Route::post('submit-answer', ['as' => 'submit-answer', 'uses' => 'App\Http\Controllers\FormController@storeAnswer']);
	Route::get('answers/{formId}/{userId}', ['as' => 'view-answer', 'uses' => 'App\Http\Controllers\FormController@showAnswers']);

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

