<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Quiz
{
    public function __construct(
        private Answer $answer,
        private Result $result
    ) {
    }

    public function anotherQuestion(): ?Question
    {
        $key = Auth::id().':questions';

        $shownQuestions = Cache::get($key, []);

        $question = Question::with('answers')
            ->whereNotIn('id', $shownQuestions ?? [])
            //->inRandomOrder()
            ->orderByRaw("RAND()")
            ->first();

        if (! $question) {
            return null;
        }

        $shownQuestions[] = $question->id;

        Cache::put($key, $shownQuestions);

        return $question;
    }

    public function saveAnswer(array $validated): void
    {
        $result = $this->result->firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'user_id' => Auth::id(),
                'correct_answers' => 0,
                'wrong_answers' => 0,
                'skip_answers' => 0,
            ]
        );

        $isCorrect = $this->answer->isCorrect($validated['question_id'], $validated['answer_id']);

        $result->increment($isCorrect ? 'correct_answers' : 'wrong_answers');
    }

    public function skipAnswer(User $user): void
    {
        $user->result()->increment('skip_answers');
    }
}
