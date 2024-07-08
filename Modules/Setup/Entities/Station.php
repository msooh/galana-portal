<?php

namespace Modules\Setup\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Station extends Model
{
    use HasFactory;
   

    protected $fillable = ['name', 'territory_manager_id', 'station_manager_id', 'dealer_id', 'location', 'created_by', 'updated_by'];

    public function territoryManager()
    {
        return $this->belongsTo(User::class, 'territory_manager_id');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function stationManager()
    {
        return $this->belongsTo(User::class, 'station_manager_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
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
