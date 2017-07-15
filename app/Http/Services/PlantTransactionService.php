<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/15/2017
 * Time: 10:20 AM
 */

namespace App\Http\Services;


use App\Models\Plant;
use App\Models\PlantTransaction;
use App\Models\PlantTransactionStatus;
use Carbon\Carbon;

class PlantTransactionService
{

    public static function getTransactionListByPlantId($plantId, $paginate = true)
    {
        $plant = PlantService::getPlantById($plantId);
        $query = $plant->transactions()->with("status");
        return $paginate ? $query->paginate() : $query->get();
    }


    public static function initialFarm($plantId, $formData)
    {

        /** @var Plant $plant */
        $plant = Plant::find($plantId);
        $form = $formData;

        $status = PlantTransactionStatus::where('name', '=', 'N')->first();

        $transaction = new PlantTransaction();

        $transaction->fill($form);
        $transaction->balance = 0;
        $transaction->status()->associate($status);
        $plant->transactions()->save($transaction);

        return $transaction;
    }


    public static function updateBalanceFarm($plantId, $formData)
    {

        /** @var Plant $plant */
        $plant = Plant::find($plantId);
        $lsatTransaction = $plant->transactions()->orderBy('created_at', 'desc')->first();
        $form = $formData;

        $status = PlantTransactionStatus::where('name', '=', 'U')->first();

        $transaction = new PlantTransaction();

        $transactionDateTime = Carbon::parse($form['transaction_date']);
        $transaction->transaction_date = $transactionDateTime;
        $transaction->amount = round($plant->remainingBalance(), 2) - round($lsatTransaction->balance, 2);
        $transaction->balance = round($plant->remainingBalance(), 2);
        $transaction->type = "+";
        $transaction->status()->associate($status);

        $plant->transactions()->save($transaction);

        return $transaction;
    }

    public static function harvestFarm($plantId, $formData)
    {

        PlantTransactionService::updateBalanceFarm($plantId, $formData);

        $plant = Plant::find($plantId);
        $form = $formData;

        $status = PlantTransactionStatus::where('name', '=', 'H')->first();
        $transaction = new PlantTransaction();
        $transactionDateTime = Carbon::parse($form['transaction_date']);
        $transactionDateTime->addSeconds(1);
        $transaction->transaction_date = $transactionDateTime;
        $roundAmount = round($form  ['amount'], 2);
        $transaction->amount = $roundAmount;
        $transaction->balance = round(round($plant->remainingBalance(), 2) - $roundAmount, 2);
        $transaction->type = '-';
        $transaction->status()->associate($status);
        $plant->transactions()->save($transaction);

        return $transaction;
    }
}