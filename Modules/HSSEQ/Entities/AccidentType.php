<?php
namespace Modules\HSSEQ\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccidentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rating',
    ];

    public function safeties()
    {
        return $this->hasMany(Safety::class);
    }
}
