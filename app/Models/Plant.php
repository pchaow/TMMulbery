<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    use SoftDeletes;

    protected $table = "plants";

    protected $fillable = ['name', 'quality', 'map', 'area_sqm', 'area_rai', 'area_ngan', 'row_spacing', 'plant_spacing', 'province_id', 'amphure_id', 'district_id', 'user_id'];

    protected $casts = [
        'map' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function amphure()
    {
        return $this->belongsTo(Amphure::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

}
