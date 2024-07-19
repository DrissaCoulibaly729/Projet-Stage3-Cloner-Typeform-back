<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getAllQuestions()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    public function getQuestionById($id)
    {
        $question = Question::findOrFail($id);
        return response()->json($question);
    }

    public function createQuestion(Request $request)
    {
        $question = Question::create($request->all());
        return response()->json($question, 201);
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return response()->json($question, 200);
    }

    public function deleteQuestion($id)
    {
        Question::destroy($id);
        return response()->json(null, 204);
    }
}
