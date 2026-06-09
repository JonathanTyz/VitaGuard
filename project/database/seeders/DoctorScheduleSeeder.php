<?php

namespace Database\Seeders;

require_once("VitaGuardSeeder.php");

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends VitaGuardSeeder
{
    public function run(): void
    {
        $this->tableName = 'doctor_schedules';
        $this->runVitaGuardSeeder('doctor_schedules.csv');
    }

    protected function modifyData($dataArray): array
    {
        $nullableFields = [
            'break_start_time',
            'break_end_time',
            'notes',
        ];

        foreach ($nullableFields as $field) {
            if (isset($dataArray[$field]) && trim($dataArray[$field]) === '') {
                $dataArray[$field] = null;
            }
        }
        return $dataArray;
    }
}
