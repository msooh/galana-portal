<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'bank', 'account_no', 'account_name', 'branch'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\BankDetailFactory::new();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
