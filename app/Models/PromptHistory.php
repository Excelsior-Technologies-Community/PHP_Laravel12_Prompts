<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptHistory extends Model
{
    protected $fillable = ['prompt_text', 'response'];
}