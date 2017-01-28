<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantTransactionStatus extends Model
{
    protected $table = "plant_transaction_statuses";

    protected $fillable = ['name', 'display_name', 'description'];

}
