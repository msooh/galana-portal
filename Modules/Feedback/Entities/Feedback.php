<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone',
        'service_date',
        'product',
        'customer_service_rating',
        'product_quality_rating',
        'timeliness_rating',
        'overall_rating',
        'feedback',
    ];
}
