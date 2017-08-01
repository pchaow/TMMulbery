<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = ['plant_id', 'type', 'amount', 'balance', 'transaction_date', 'status_id'];


    public function status()
    {
        return $this->belongsTo(PlantTransactionStatus::class, 'status_id');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }


}
