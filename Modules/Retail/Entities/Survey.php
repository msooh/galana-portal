<?php

namespace Modules\Retail\Entities;

use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Category;
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

    public function category()
    {
        return $this->hasManyThrough(
            Category::class,             // Target model
            Checklist::class,            // Intermediate model
            'id',           // Foreign key on Checklist table (refers to Subcategory)
            'id',                        // Foreign key on Category table
            'id',                        // Local key on Survey table (relates to Response)
            'sub_category_id'                // Local key on Checklist table (refers to Subcategory)
        );
    }
    


}
