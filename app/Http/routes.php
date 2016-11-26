<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('question', 'QuestionController');
Route::resource('questionnaire', 'QuestionnaireController');

Route::get('/testing', function() {
	$question = App\Question::find(1);
	echo $question->description;

	$question->options()->save(App\Option::create(
		[ 'description' => 'A' ]
	));
});

Route::group(['prefix' => 'api'], function() {
	Route::post('get_available_questions', 'QuestionnaireController@get_available_questions');
});