<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantTransactionStatus extends Model
{
    use SoftDeletes;
    protected $table = "plant_transaction_statuses";

    protected $fillable = ['name', 'display_name', 'description'];

}
