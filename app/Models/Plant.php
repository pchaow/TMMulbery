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

    public function planningBalance(Carbon $date)
    {
        $initStatus = PlantTransactionStatus::where('name', '=', 'N')->first();
        $lastTransaction = $this->transactions()
            ->where('transaction_date', '<=', $date)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $firstTransaction = $this->transactions()
            ->where('status_id', '=', $initStatus->id)
            ->orderBy('transaction_date', 'desc')
            ->first();
        if ($firstTransaction != null && $lastTransaction != null) {
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

        $currentBalance = ($lastDate->diffInDays($currentDate, false) * $amount * 0.0095) + $balance;
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
        return $this->orders()->where('status', '!=', 'Closed')
            ->where('type', '=', 'buy')->count();
    }

    /*
     * @deprecated
     */
    public function distanceFromPiankusol()
    {
//        if ($this->map) {
//            $lat0 = $this->map[0]['position']['lat'];
//            $lng0 = $this->map[0]['position']['lng'];
//
//            $lat1 = 18.779465;
//            $lng1 = 99.046323;
//
//            return $this->distance($lat0, $lng0, $lat1, $lng1, "K");
//        } else {
//            return null;
//        }
        return $this->distanceFromBuyer();
    }

    public function distanceFromBuyer()
    {
        $user = $this->user;
        $buyer = null;
        if ($user->parent != null) {
            $buyer = $user->parent()->first();
        } else {
            $buyer = $user;
        }
        if ($this->map && $buyer->map) {
            $lat0 = $this->map[0]['position']['lat'];
            $lng0 = $this->map[0]['position']['lng'];

            $lat1 = $buyer->map[0]['position']['lat'];;
            $lng1 = $buyer->map[0]['position']['lng'];;

//            return $this->distance($lat0, $lng0, $lat1, $lng1, "K");
            return $this->GetDrivingDistance($lat0, $lng0, $lat1, $lng1, "K");

        }

        return null;
    }

    function GetDrivingDistance($lat1, $long1, $lat2, $long2, $unit = null)
    {

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        $distance_km = $response_a['rows'][0]['elements'][0]['distance']['value'];

        $distance_km = floatval($distance_km) / 1000.00;

        return $distance_km;
    }


    private
    function distance($lat1, $lon1, $lat2, $lon2, $unit)
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
