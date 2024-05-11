<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Services\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function question(Quiz $quiz): array
    {
        return [
            'question' => $quiz->anotherQuestion(),
            'total' => $quiz->totalQuestions(),
            'index' => $quiz->currentQuestion(),
        ];
    }

    public function submit(QuizRequest $request, Quiz $quiz): Response
    {
        $quiz->saveAnswer($request->user(), $request->validated());

        return response()->noContent();
    }

    public function skipQuestion(Request $request, Quiz $quiz): Response
    {
        $quiz->skipAnswer($request->user(), $request->post('question_id'));

        return response()->noContent();
    }
}
