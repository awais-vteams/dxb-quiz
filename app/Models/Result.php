<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'correct_answers', 'skip_answers', 'wrong_answers'];
}
