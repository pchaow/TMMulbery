<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/21/2017
 * Time: 11:41 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderPivot extends Pivot
{
    protected $casts = [
        'remark' => 'array'
    ];
}