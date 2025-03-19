<?php

namespace Modules\Retail\Entities;

use Modules\Setup\Entities\Station;
use Modules\Retail\Entities\Category;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporarySurvey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'station_id', 'category_id', 'responses', 'signature'];

    protected $casts = [
        'responses' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
   
   
}
