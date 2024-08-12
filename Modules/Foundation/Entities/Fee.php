<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'year', 'total_fees',
        'term_one_fees', 'term_two_fees',
        'term_three_fees', 'status',
        'uniform_others_amount', 'mode_of_payment'
    ];

    
    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\FeeFactory::new();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
