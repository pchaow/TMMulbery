<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\PlantTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{


    //
    public function plantHarvestStats(Request $request, $plantId)
    {
        $today = Carbon::now();
        $today->day = 1;
        $today->addMonth(7);

        $last24Month = Carbon::now();
        $last24Month->day = 1;
        $last24Month->addMonth(1);
        $last24Month->subMonth(18);

        $fixLast = Carbon::now();
        $fixLast->day = 1;
        $fixLast->addMonth(1);
        $fixLast->subMonth(18);

        $categories = [];
        $amounts = [];
        $confirmAmounts = [];
        $diff = [];

        while ($last24Month < $today) {
            $id = "$last24Month->year-$last24Month->month";
            $categories[] = $id;
            $last24Month->addMonth(1);
            $amounts[$id] = 0;
            $confirmAmounts[$id] = 0;
            $diff[$id] = 0;

        }

        $query = PlantTransaction::query();
        $query->addSelect(DB::raw("concat(date_format(transaction_date,\"%Y\"),'-',convert(date_format(transaction_date,\"%m\"),UNSIGNED INTEGER)) as catId"));
//        $query->addSelect("transaction_date");
        $query->addSelect(DB::raw("COALESCE(sum(amount),0) as amount"));
        $query->addSelect(DB::raw("COALESCE(sum(confirm_amount),0)  as confirm_amount"));

        $query->where("status_id", '=', '2');
        $query->where("plant_id", '=', $plantId);
        $query->whereBetween("transaction_date", [$fixLast, $today]);
        $query->groupBy(DB::raw("catId"));

        $data = $query->get();

        foreach ($data as $d) {
            $currentAmount = floatval($d->amount);
            $currentEstiamte = floatval($d->confirm_amount);
            $amounts[$d->catId] = $currentAmount;
            $confirmAmounts[$d->catId] = $currentEstiamte;
            $diff[$d->catId] = $currentAmount == 0 || $currentEstiamte == 0 ? 0 : $currentAmount - $currentEstiamte;
        }
        return [
            "categories" => $categories,
            "series" => [
                [
                    "name" => "Estimate",
                    "data" => array_flatten($amounts),
                ],
                [
                    "name" => "Actual",
                    "data" => array_flatten($confirmAmounts),
                ],
                [
                    "name" => "Different",
                    "data" => array_flatten($diff),
                ]
            ]
        ];
    }
}
