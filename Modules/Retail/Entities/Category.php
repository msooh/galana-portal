<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'description',
        'created_by',
        'updated_by',

    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

}
