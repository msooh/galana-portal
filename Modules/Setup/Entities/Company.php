<?php

namespace Modules\Setup\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'location', 'address', 'contact_person', 'email', 'phone_number', 'kra_pin', 'status', 'type', 'created_by', 'updated_by'
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
