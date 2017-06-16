<?php

use Illuminate\Database\Seeder;

class PlantTransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                "name" => "N",
                "display_name" => "Initiailize",
                "description" => "เริ่มปลูก",
            ],
            [
                "name" => "H",
                "display_name" => "Harvest",
                "description" => "เก็บเกี่ยว",
            ],
            [
                "name" => "U",
                "display_name" => "Update",
                "description" => "ปรับปรุงรายการ",
            ]
        ];

        foreach ($statuses as $s){
            $sf = new \App\Models\PlantTransactionStatus();
            $sf->fill($s);
            $sf->save();
        }
    }
}
