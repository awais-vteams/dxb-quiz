<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Answer extends Model
{
    use HasFactory;

    protected $hidden = ['is_correct'];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function isCorrect(int $questionId, int $answerId): bool
    {
        return static::where([
            'id' => $answerId,
            'question_id' => $questionId,
            'is_correct' => true,
        ])
            ->exists();
    }
}
