<?php

namespace Database\Seeders;

require_once("VitaGuardSeeder.php");

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->tableName = 'medicines';
        $this->runVitaGuardSeeder('medicines.csv');
    }
}
