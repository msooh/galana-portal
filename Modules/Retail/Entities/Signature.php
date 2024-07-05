<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id', 'role', 'name', 'signature_image',
    ];
    

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
