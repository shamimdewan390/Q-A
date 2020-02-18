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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController')->except('show');
Route::get('questions/{slug}','QuestionController@show')->name('questions.show');

Route::resource('questions.answers', 'AnswerController')
        ->except(['index','create','show']);

Route::post('answers/{answer}/accept', 'AcceptAnswerController@accept')
        ->name('accept.answer');

        Route::middleware('auth')->group(function(){
            Route::post('questions/{question}/favorites', 'FavoritesController@store')
                ->name('favorite.questions');
            Route::delete('questions/{question}/favorites', 'FavoritesController@destroy')
                ->name('unfavorite.questions');
        });




Route::any('questions/{question}/vote', 'voteQuestionController@vote')
        ->name('questions.vote');

Route::any('answers/{answer}/vote', 'voteAnswerController@vote')
        ->name('answers.vote');
