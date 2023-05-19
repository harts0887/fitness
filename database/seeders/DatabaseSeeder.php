<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/karyawanYGC.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('karyawan table seeded!');
        $path = 'database/machinesfitness.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('maschine table seeded!');
    }
}
