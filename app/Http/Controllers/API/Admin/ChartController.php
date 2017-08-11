<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\PlantTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

//    public function plantHarvestStats(Request $request, $plantId)
//    {
//        $today = Carbon::now();
//        $today->day = 1;
//        $today->addMonth(7);
//
//        $last24Month = Carbon::now();
//        $last24Month->day = 1;
//        $last24Month->addMonth(1);
//        $last24Month->subMonth(18);
//
//        $fixLast = Carbon::now();
//        $fixLast->day = 1;
//        $fixLast->addMonth(1);
//        $fixLast->subMonth(18);
//
//        $categories = [];
//        $amounts = [];
//        $confirmAmounts = [];
//        $diff = [];
//
//        while ($last24Month < $today) {
//            $id = "$last24Month->year-$last24Month->month";
//            $categories[] = $id;
//            $last24Month->addMonth(1);
//            $amounts[$id] = 0;
//            $confirmAmounts[$id] = 0;
//            $diff[$id] = 0;
//
//        }
//
//        $query = PlantTransaction::query();
//        $query->addSelect(DB::raw("concat(date_format(transaction_date,\"%Y\"),'-',convert(date_format(transaction_date,\"%m\"),UNSIGNED INTEGER)) as catId"));
////        $query->addSelect("transaction_date");
//        $query->addSelect(DB::raw("COALESCE(sum(amount),0) as amount"));
//        $query->addSelect(DB::raw("COALESCE(sum(confirm_amount),0)  as confirm_amount"));
//
//        $query->where("status_id", '=', '2');
//        $query->where("plant_id", '=', $plantId);
//        $query->whereBetween("transaction_date", [$fixLast, $today]);
//        $query->groupBy(DB::raw("catId"));
//
//        $data = $query->get();
//
//        foreach ($data as $d) {
//            $currentAmount = floatval($d->amount);
//            $currentEstiamte = floatval($d->confirm_amount);
//            $amounts[$d->catId] = $currentAmount;
//            $confirmAmounts[$d->catId] = $currentEstiamte;
//            $diff[$d->catId] = $currentAmount == 0 || $currentEstiamte == 0 ? 0 :  $currentEstiamte - $currentAmount;
//        }
//        return [
//            "categories" => $categories,
//            "series" => [
//                [
//                    "name" => "Estimate",
//                    "data" => array_flatten($amounts),
//                ],
//                [
//                    "name" => "Actual",
//                    "data" => array_flatten($confirmAmounts),
//                ],
//                [
//                    "name" => "Different",
//                    "data" => array_flatten($diff),
//                ]
//            ]
//        ];
//    }

    public function plantHarvestStats(Request $request, $plantId)
    {
        $today = Carbon::now();
        $today->day = 1;
        $today->addMonth(7);

        $firstMonth = Carbon::now();
        $firstMonth->day = 1;
        $firstMonth->month = 1;
        $firstMonth->year = 2015;

        $fixLast = Carbon::now();
        $fixLast->day = 1;
        $fixLast->addMonth(1);
        $fixLast->subMonth(18);

        $categories = [];
        $estimate = [];
        $amount = [];
        $diff = [];
        $dates = [];
        while ($firstMonth < $today) {
            $id = "$firstMonth->year-$firstMonth->month";
            $categories[] = $id;

            $dates[$id] = $firstMonth->timestamp;
            $dateInMills = $dates[$id] * 1000;

            $amount[$id] = [$dateInMills, 0];
            $estimate[$id] = [$dateInMills, 0];
            $diff[$id] = [$dateInMills, 0];

            $firstMonth->addMonth(1);

        }

        $query = PlantTransaction::query();
        $query->addSelect(DB::raw("concat(date_format(transaction_date,'%Y'),'-',convert(date_format(transaction_date,'%m'),UNSIGNED INTEGER)) as catId"));
//        $query->addSelect("transaction_date");
        $query->addSelect(DB::raw("COALESCE(sum(amount),0) as amount"));
        $query->addSelect(DB::raw("COALESCE(sum(confirm_amount),0)  as confirm_amount"));

        $query->where("status_id", '=', '2');
        $query->where("plant_id", '=', $plantId);
        $query->whereBetween("transaction_date", [$fixLast, $today]);
        $query->groupBy(DB::raw("transaction_date"));

        $data = $query->get();

        foreach ($data as $d) {

            $currentEstimate = floatval($d->amount);
            $currentRealAmount = floatval($d->confirm_amount);
            $currentDiff = $currentEstimate == 0 || $currentRealAmount == 0 ? 0 : $currentRealAmount - $currentEstimate;
            $dateInMills = $dates[$d->catId] * 1000;
            $estimate[$d->catId] = [$dateInMills, $currentEstimate];
            $amount[$d->catId] = [$dateInMills, $currentRealAmount];
            $diff[$d->catId] = [$dateInMills, $currentDiff];
        }

        $realSeries = [];
        $estimateSeries = [];
        $diffSeries = [];


        foreach ($categories as $key) {
            $realSeries[] = $amount[$key];
            $estimateSeries[] = $estimate[$key];
            $diffSeries[] = $diff[$key];
        }


        return [$realSeries, $estimateSeries, $diffSeries];
    }
}
