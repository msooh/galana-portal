<?php

namespace Modules\Retail\Entities;

use Modules\Setup\Entities\Station;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'total_marks', 'latitude', 'longitude', 'comment', 'station_id', 'created_by', 'updated_by'];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get the signatures for the survey.
     */
    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
