<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'county', 'sub_county', 'location',
        'father_name', 'father_phone',
        'mother_name', 'mother_phone',
        'guardian_name', 'guardian_phone',
        'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\StudentFactory::new();
    }
}
