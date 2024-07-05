<?php

namespace Modules\Setup\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'name', 'phone', 'email', 'active', 'created_by', 'updated_by'
    ];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
