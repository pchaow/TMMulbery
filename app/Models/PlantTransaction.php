<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantTransaction extends Model
{
    protected $fillable = ['plant_id', 'type', 'amount', 'balance', 'transaction_date', 'status_id'];


    public function status()
    {
        return $this->belongsTo(PlantTransactionStatus::class, 'status_id');
    }


}
