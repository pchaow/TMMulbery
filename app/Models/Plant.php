<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    use SoftDeletes;

    protected $table = "plants";

    protected $fillable = ['name', 'quality', 'map', 'area_sqm', 'row_spacing', 'plant_spacing', 'province_id', 'amphure_id', 'district_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
