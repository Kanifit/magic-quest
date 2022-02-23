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

Route::get('/', function () {
    return redirect()->route('book.index');
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('book.index');
})->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/book', "BookController@index")->name('book.index');
    Route::get('/reader/book/{book}', "BookController@reader")->name('book.reader');
    Route::get('/test/{testId}', 'TestController@show')->name('book.test');
});

Route::group(['prefix' => 'bookadmin', 'middleware' => 'auth'], function () {

	Route::resource('glossary', 'GlossaryController');
	Route::resource('tests', 'TestController');
	Route::resource('steps', 'StepController');
//	Route::get('steps/{testId}', 'StepController@index');
	Route::post('getAvailableBooks', 'BookController@getAvailableBooks');
	Route::post('getBook', 'TestController@getBook');

});

//Методы асинхронного получения
Route::group(['prefix' => 'api'/*, 'middleware' => 'auth'*/], function () {

    //Книги
        //Получить список книг пользователя
    Route::post('/books', "BookController@userBooks");

        //Получить информацию о конкретной книге
    Route::post('/book/getinfo', "BookController@getBookInfo");

    Route::group(['prefix' => 'test'], function () {
        Route::post('getTest', 'TestController@getTest');
        Route::post('getStep', 'TestController@getStep');
        Route::resource('download', 'TestFileLoaderController');
        Route::post('getActiveAttemptId', 'AttemptController@getActiveAttemptId');
        Route::post('addAttemptScore', 'AttemptController@addAttemptScore');
        Route::post('getAttemptScore', 'AttemptController@getAttemptScore');
        Route::resource('attempt', 'AttemptController');
        Route::resource('journal', 'AttemptJournalController');
        Route::post('getLastStep', 'AttemptJournalController@getLastStep');
        Route::post('getStepAttempt', 'AttemptJournalController@getStepAttempt');
    });
});
