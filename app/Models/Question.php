<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Question extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->inRandomOrder();
    }
}
