<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\SchoolFactory::new();
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }
}
