<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeTransaction extends Model
{

    protected $table = 'trade_transaction';

    protected $fillable = ['deal_date', 'amount', 'pricerate', 'user_id', 'plant_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

}
