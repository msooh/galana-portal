<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_item_id', 'survey_id', 'response', 'comment',
    'weight', 'file_path'];

    public function checklistItem()
    {
        return $this->belongsTo(Checklist::class, 'checklist_item_id');
    }
}
