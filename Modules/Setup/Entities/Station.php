<?php

namespace Modules\Setup\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Station extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name', 'location', 'company_id', 'long', 'dealer_id', 'territory_manager_id', 
        'lat', 'email', 'phone', 'is_active', 'till_number', 
        'start_date', 'end_date', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    /**
     * Get the company that owns the station.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the users who manage the station.
     */
    public function managers()
    {
        return $this->belongsToMany(User::class, 'user_stations', 'station_id', 'user_id');
    }

    /**
     * Get the dealer for the station.
     */
    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    /**
     * Get the territory manager for the station.
     */
    public function territoryManager()
    {
        return $this->belongsTo(User::class, 'territory_manager_id');
    }

    /**
     * Get the user who created the station.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the station.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
    * Define a has-many relationship with responses.
    */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

   
}
