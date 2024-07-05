<?php

namespace Modules\Feedback\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffFeedback extends Model
{
    use HasFactory;

    protected $table = 'staff_feedback';

    protected $fillable = [
        'feedbackType',
        'feedback',
    ];
}
