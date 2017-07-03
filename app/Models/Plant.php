<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function transactions()
    {
        return $this->hasMany(PlantTransaction::class);
    }

    public function remainingBalance()
    {
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();
        $lastTransaction = $this->transactions()->orderBy('transaction_date', 'desc')->first();
        $firstTransaction = $this->transactions()
            ->where('status_id', '=', $initStatus->id)
            ->orderBy('transaction_date', 'desc')->first();
        $amount = $firstTransaction->amount;
        $lastDate = $lastTransaction->transaction_date;
        $lastBalance = $lastTransaction->balance;
        $lastDate = Carbon::parse(Carbon::parse($lastDate));
        $now = Carbon::now();

        return $this->calculateRemainingBalance($lastDate, $now, $amount, $lastBalance);
    }

    private function calculateRemainingBalance($lastDate, $currentDate, $amount, $balance)
    {
        $currentBalance = ($currentDate->diffInDays($lastDate) * $amount * 0.008) + $balance;
        return $currentBalance;
    }

}
