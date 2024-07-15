<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Setup\Entities\Station;
use Laravel\Sanctum\HasApiTokens;

use Modules\Setup\Entities\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    } 

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_user');
    }

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'user_stations');
    }

    /**
     * Get the stations managed by the user.
     */
    public function managedStations()
{
    return $this->belongsToMany(Station::class, 'user_stations', 'user_id', 'station_id')
                ->join('user_roles', 'user_stations.user_id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->where('roles.name', 'Station Manager');
}


    /**
     * Get the stations where the user is the dealer.
     */
    public function dealerStations()
    {
        return $this->hasMany(Station::class, 'dealer_id');
    }

    /**
     * Get the stations where the user is the territory manager.
     */
    public function territoryManagerStations()
    {
        return $this->hasMany(Station::class, 'territory_manager_id');
    }
}
