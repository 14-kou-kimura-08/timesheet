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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/timesheets', 'TimesheetController@index');
Route::get('/timesheets/{year}/{month}', 'TimesheetController@show')->where(['year' => '20[0-9]{2}', 'month' => '[1-9]|1[0-2]']);
Route::post('/timesheets', 'TimesheetController@store');
Route::post('/timesheets/delete', 'TimesheetController@delete');
