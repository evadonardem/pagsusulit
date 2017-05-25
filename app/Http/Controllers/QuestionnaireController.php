<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Questionnaire;

use App\Question;

use App\Option;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $questionnaires = Questionnaire::all();
            foreach ($questionnaires as &$questionnaire) {
                $questionnaire->description = html_entity_decode($questionnaire->description);
                $questionnaire->deleteURL = action('QuestionnaireController@destroy', $questionnaire->id);
            }
            return $questionnaires;
        }
        return view('questionnaire.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Questionnaire::create($request->all());
        return redirect(action('QuestionnaireController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $questionnaire = Questionnaire::find($id);
        if(!is_object($questionnaire)) return;
        $questionnaire->delete();
        return $questionnaire;
    }


    public function get_available_questions(Request $request) {
        $questions = Question::where('is_finalized', 1)
            ->whereNotIn('id', $request->input('questions'))
            ->with('options')->get();
        return $questions;
    }
}
