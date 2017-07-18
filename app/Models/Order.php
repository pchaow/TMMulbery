<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    public static $STATUS_OPEN = "Open";
    public static $STATUS_PENDING = "Pending";
    public static $STATUS_CLOSE = "Closed";

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

    public function relatedOrders()
    {
        if ($this->type == Order::$ORDER_TYPE_BUY) {
            return $this->belongsToMany(Order::class, "confirm_orders", "buy_order_id");
        } elseif ($this->type == $this->ORDER_TYPE_SELL) {
            return $this->belongsToMany(Order::class, "confirm_orders", "sell_order_id");
        } else {
            return null;
        }
    }

    public function buyConfirmOrders()
    {
        return $this->hasMany(ConfirmOrder::class, "buy_order_id");
    }

    public function sellConfirmOrders(){
        return $this->hasMany(ConfirmOrder::class, "sell_order_id");

    }

}

