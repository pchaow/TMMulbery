<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $STATUS_OPEN = "Open";
    public static $STATUS_PENDING = "Pending";
    public static $STATUS_CLOSE = "Close";

    public static $ORDER_TYPE_BUY = "buy";
    public static $ORDER_TYPE_SELL = "sell";

    protected $table = "orders";

    protected $fillable = [
        'user_id', 'plant_id', 'status', 'amount', 'type'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function confirmOrder()
    {
        if ($this->type == Order::$ORDER_TYPE_BUY) {
            return $this->belongsToMany(Order::class, "confirm_orders", "buyer_id");
        } elseif ($this->type == $this->ORDER_TYPE_SELL) {
            return $this->belongsToMany(Order::class, "confirm_orders", "seller_id");
        } else {
            return null;
        }
    }


}
