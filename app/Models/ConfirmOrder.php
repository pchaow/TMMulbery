<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfirmOrder extends Model
{
    use SoftDeletes;

    public static $STATUS_OPEN = "Open";
    public static $STATUS_PENDING = "Pending";
    public static $STATUS_CLOSE = "Closed";

    protected $table = "confirm_orders";

    protected $casts = [
        'remark' => 'array',
    ];


    public function buyOrder()
    {
        return $this->belongsTo(Order::class, "buy_order_id");
    }

    public function sellOrder()
    {
        return $this->belongsTo(Order::class, "sell_order_id");
    }


}
