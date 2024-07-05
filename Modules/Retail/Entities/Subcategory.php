<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'description', 'created_by', 'updated_by',];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'sub_category_id'); 
    }
    
    
}
