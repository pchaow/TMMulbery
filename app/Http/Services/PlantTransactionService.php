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
use Illuminate\Http\Response;

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

    public static function checkValidTransaction($plantId, $formData)
    {
        $plant = Plant::find($plantId);

        $lastTransaction = $plant->transactions()->orderBy('created_at', 'desc')->first();

        $transactionDateTime = Carbon::parse($formData['transaction_date']);

        $transaction = new PlantTransaction();
        $transaction->transaction_date = $transactionDateTime;

        return $transactionDateTime >= $lastTransaction->transaction_date;
    }


    public static function updateBalanceFarm($plantId, $formData)
    {

        /** @var Plant $plant */
        $plant = Plant::find($plantId);
        $lastTransaction = $plant->transactions()->orderBy('created_at', 'desc')->first();
        $form = $formData;

        $status = PlantTransactionStatus::where('name', '=', 'U')->first();

        $transaction = new PlantTransaction();

        $transactionDateTime = Carbon::parse($form['transaction_date']);
        $transaction->transaction_date = $transactionDateTime;
        $transaction->amount = round($plant->planningBalance($transactionDateTime), 2) - round($lastTransaction->balance, 2);

        if ($transaction->amount == 0) return null;
        $transaction->balance = round($lastTransaction->balance, 2) + $transaction->amount;

        $transaction->type = "+";
        $transaction->status()->associate($status);

        $plant->transactions()->save($transaction);

        return $transaction;
    }

    public static function harvestFarm($plantId, $formData)
    {
        if (self::checkValidTransaction($plantId, $formData)) {


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
            $transaction->balance = round(round($plant->planningBalance($transactionDateTime), 2) - $roundAmount, 2);
            $transaction->type = '-';
            $transaction->status()->associate($status);
            $plant->transactions()->save($transaction);

            return $transaction;
        } else {
            return \response([
                "transaction_date" => "Transaction date is not valid."
            ], 422);
        }
    }

    public static function confirmHarvestFarm($plantId, $formData)
    {
        $transactionId = $formData['id'];
        $transaction = PlantTransaction::find($transactionId);

        if ($transaction) {

            $transaction->confirm_amount = $formData['confirm_amount'];
            $transaction->save();

            return $transaction;
        }
        return null;
    }
}