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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::delete('wcalendar', 'WcalendarController@destroyAllInvalid')->name('wcalendar.destroy.invalid');
    Route::get('wcalendar/{month}/{year}', 'WcalendarController@goto')->name('wcalendar.goto');
    Route::resource('wcalendar', 'WcalendarController');
    Route::get('category/{category}', 'CategoryController@show')->name('category.show');
    Route::get('export/{year}', 'ExportController@index')->name('export.index');
    Route::get('export', 'ExportController@getRoute')->name('export.route');
    Route::any('{all}', 'HomeController@index')->name('home')->where('all', '.*');
});