<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Services\Quiz;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function startQuiz(): View
    {
        return view('quiz.start');
    }

    public function result(Request $request): View
    {
        return view('quiz.result')->with(['result' => $request->user()->result]);
    }

    public function question(Quiz $quiz)
    {
        return ['question' => $quiz->anotherQuestion()];
    }

    public function submit(QuizRequest $request, Quiz $quiz)
    {
        $quiz->saveAnswer($request->validated());

        return [];
    }

    public function skipQuestion(Request $request, Quiz $quiz)
    {
        $quiz->skipAnswer($request->user());

        return [];
    }
}
