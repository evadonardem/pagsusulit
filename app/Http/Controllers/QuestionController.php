<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Question;

use App\Option;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $questions = Question::all();
            foreach ($questions as &$question) {
                $question->description = html_entity_decode($question->description);
                foreach ($question->options as &$option) {
                    $option->description = html_entity_decode($option->description);
                }
                $question->deleteURL = action('QuestionController@destroy', $question->id);
            }
            return $questions;
        }

        return view('question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = Question::create([
            'description' => $request->input('description')
        ]);

        $options = $request->input('options');
        foreach ($options as $key => $value) {
            $question->options()->save(Option::create([
                'description' => $value,
                'is_correct' => ($request->input('correct_answer')==$key) ? true : false
            ]));
        }

        return redirect(action('QuestionController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        if(!is_object($question)) return;
        $question->delete();
        return $question;
    }
}
