<?php

namespace Modules\Foundation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherPayment extends Model
{
    use HasFactory;

    protected $fillable = ['fee_id', 'purpose', 'amount'];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Foundation\Database\factories\OtherPaymentFactory::new();
    }
}
