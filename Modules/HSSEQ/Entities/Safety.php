<?php

namespace Modules\HSSEQ\Entities;

use Modules\Setup\Entities\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safety extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'station_id',
        'date', 
        'time', 
        'comment', 
        'action',
        'accident_type_id', 
        'slightly_injured', 
        'injured_medical_treatment',
        'injured_hospitalization', 
        'fatalities', 
        'other_details', 
        'police_report',
        'police_file', 
        'status', 
        'notes', 
        'created_by', 
        'updated_by',
        'assigned_to', 
        'assigned_at',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function accidentType()
    {
        return $this->belongsTo(AccidentType::class, 'accident_type_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
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
