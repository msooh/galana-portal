<?php

namespace Modules\Suggestion\Entities;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'name',
        'email',
        'anonymous', 
        'suggestionType', 
        'department', 
        'suggestion', 
        'attachment',
    ];
    
}
