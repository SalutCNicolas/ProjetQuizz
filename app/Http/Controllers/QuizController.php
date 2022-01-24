<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Quiz::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $questions = $request["questions"];
        $data = json_decode($request->getContent());
        $quiz= new Quiz();
        $quiz->label = $data->label;
        $quiz->save();
        foreach($questions as $question) {
            $Question = new Question();
            $Question["quiz_id"] = $quiz->id;
            $Question["label"]   = $question["label"];
            $Question["answer"] = 0;
            $Question["earnigs"] = $question["earnings"];
            $Question->save();
            foreach($question["choices"] as $choise) {
                $Choise = new Choice();
                $Choise["question_id"] = 1;
                $Choise["label"]   = $choise["label"];
                $Choise->save();
                if($choise["id"] == $question["answer"]){
                    $Question["answer"] = $Choise["id"];
                    $Question->save();
                }
            }
            $Question->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $id)
    {
        return Quiz::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quizzes = Quizzes::find($id);
        $quizzes -> delete();
        return response()->json(['message' => 'Quizz bien supprimé']);
    }

    public function publishQuiz($id) {
        $quizzes = Quizzes::find($id);
        $quizzes->published = false;
        $quizzes->save();
        return response()->json(['message' => 'Quizz bien mis a jour']);
    }    
}
