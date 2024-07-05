<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sub_category_id',
        'created_by',
        'updated_by'

    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'sub_category_id');
    }

    public function category()
    {
        return $this->subcategory->category(); 
    }
}
