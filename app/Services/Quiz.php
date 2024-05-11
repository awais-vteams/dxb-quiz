<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Quiz
{
    public function __construct(
        private Answer $answer,
        private ?string $cacheKey = null,
    ) {
        $this->cacheKey = Auth::id().':questions';
    }

    public function anotherQuestion(): ?Question
    {
        $shownQuestions = Cache::get($this->cacheKey, []);

        return Question::with('answers')
            ->whereNotIn('id', $shownQuestions ?? [])
            //->inRandomOrder()
            ->orderByRaw("RAND()")
            ->first();
    }

    public function currentQuestion(): int
    {
        return count(Cache::get($this->cacheKey, [])) + 1;
    }

    public function totalQuestions(): int
    {
        return Question::count();
    }

    public function saveAnswer(User $user, int $questionId, int $answerId = null, $isSkip = false): void
    {
        $result = $user->myResult();

        if ($isSkip) {
            $result->increment('skip_answers');
        }

        if ($answerId) {
            $isCorrect = $this->answer->isCorrect($questionId, $answerId);
            $result->increment($isCorrect ? 'correct_answers' : 'wrong_answers');
        }

        $this->saveInSession($questionId);
    }

    private function saveInSession(int $questionId): void
    {
        $shownQuestions = Cache::get($this->cacheKey, []);

        $shownQuestions[] = $questionId;

        Cache::put($this->cacheKey, $shownQuestions);
    }
}
