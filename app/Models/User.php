<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
    ];

    public function result(): HasOne
    {
        return $this->hasOne(Result::class);
    }

    public function myResult(): HasOne
    {
        if ($this->result()->doesntExist()) {
            $this->result()->create([
                'correct_answers' => 0,
                'wrong_answers' => 0,
                'skip_answers' => 0,
            ]);
        }

        return $this->result();
    }
}
