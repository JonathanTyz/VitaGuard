<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

require_once("VitaGuardSeeder.php");
class FacilityScheduleSeeder extends VitaGuardSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->tableName = 'facility_schedules';
        $this->runVitaGuardSeeder('facility_schedules.csv');
    }

    protected function modifyData($dataArray):array
    {
        $timeFields = [
            'open_time',
            'close_time',
            'break_start_time',
            'break_end_time'
        ];

        foreach ($timeFields as $field) {
            if (isset($dataArray[$field]) && trim($dataArray[$field]) === '') {
                $dataArray[$field] = null;
            }
        }
        return $dataArray;
    }
}
