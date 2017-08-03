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

    protected $appends = ["countOpenOrder"];

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
        if ($firstTransaction != null) {
            $amount = $firstTransaction->amount;
            $lastDate = $lastTransaction->transaction_date;
            $lastBalance = $lastTransaction->balance;
            $lastDate = Carbon::parse(Carbon::parse($lastDate));
            $now = Carbon::now();

            return $this->calculateRemainingBalance($lastDate, $now, $amount, $lastBalance);
        } else {
            return 0;
        }
    }

    public function planningBalance($date)
    {
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();
        $lastTransaction = $this->transactions()->orderBy('transaction_date', 'desc')->first();
        $firstTransaction = $this->transactions()
            ->where('status_id', '=', $initStatus->id)
            ->orderBy('transaction_date', 'desc')->first();
        if ($firstTransaction != null) {
            $amount = $firstTransaction->amount;
            $lastDate = $lastTransaction->transaction_date;
            $lastBalance = $lastTransaction->balance;
            $lastDate = Carbon::parse(Carbon::parse($lastDate));
            $now = Carbon::now();

            return $this->calculateRemainingBalance($lastDate, $date, $amount, $lastBalance);
        } else {
            return 0;
        }
    }

    public function planningHarvestDate(Carbon $date)
    {
        $harvestStatus = PlantTransactionStatus::where('name', '=', 'H')->first();
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();

        $lastHarvest = $this->transactions()
            ->where('status_id', '=', $harvestStatus->id)
            ->orderBy('transaction_date', 'desc')->first();


        if ($lastHarvest) {
            $lastDate = Carbon::parse($lastHarvest->transaction_date);
            return $lastDate->diffInDays($date, false);
        } else if ($firstInit = $this->transactions()->where('status_id', '=', $initStatus->id)->orderBy('transaction_date', 'desc')->first()) {
            $lastDate = Carbon::parse($firstInit->transaction_date);
            return $lastDate->diffInDays($date, false);

        } else {
            return null;
        }
    }

    public function lastHarvestDate()
    {
        $harvestStatus = PlantTransactionStatus::where('name', '=', 'H')->first();
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();

        $lastHarvest = $this->transactions()
            ->where('status_id', '=', $harvestStatus->id)
            ->orderBy('transaction_date', 'desc')->first();


        if ($lastHarvest) {
            return $lastHarvest->transaction_date;
        } else if ($firstInit = $this->transactions()->where('status_id', '=', $initStatus->id)->orderBy('transaction_date', 'desc')->first()) {
            return $firstInit->transaction_date;
        } else {
            return null;
        }
    }

    private function calculateRemainingBalance($lastDate, $currentDate, $amount, $balance)
    {
        $lastDate->hour = 0;
        $lastDate->minute = 0;
        $lastDate->second = 0;

        $currentDate->hour = 0;
        $currentDate->minute = 0;
        $currentDate->second = 0;

        $currentBalance = ($lastDate->diffInDays($currentDate,false) * $amount * 0.0095) + $balance;
        return $currentBalance;
    }

    public function amount()
    {
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();
        $lastTransaction = $this->transactions()->orderBy('transaction_date', 'desc')->first();
        $firstTransaction = $this->transactions()
            ->where('status_id', '=', $initStatus->id)
            ->orderBy('transaction_date', 'desc')->first();
        if ($firstTransaction != null) {
            $amount = $firstTransaction->amount;
            return $amount;
        } else {
            return 0;
        }
    }

    public function hasTransaction()
    {
        return $this->transactions()->first() != null ? true : false;
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getCountOpenOrderAttribute()
    {
        return $this->orders()->where('status', '!=', 'Closed')->count();
    }

    public function distanceFromPiankusol()
    {
        if ($this->map) {
            $lat0 = $this->map[0]['position']['lat'];
            $lng0 = $this->map[0]['position']['lng'];

            $lat1 = 18.779465;
            $lng1 = 99.046323;

            return $this->distance($lat0, $lng0, $lat1, $lng1,"K");
        } else {
            return null;
        }
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
