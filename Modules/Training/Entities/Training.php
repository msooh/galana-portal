<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_facility',
        'start_date',
        'end_date',
        'cost',
        'certificate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Training\Database\factories\TrainingFactory::new();
    }
}
