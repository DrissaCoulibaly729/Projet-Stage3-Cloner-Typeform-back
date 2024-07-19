<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 'type', 'form_id',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
}

