<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'year', 'term', 'mid_term_grade',
        'mid_mean_score', 'mid_term_position',
        'end_term_mean_score', 'end_term_position', 'end_term_grade'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\PerformanceFactory::new();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
