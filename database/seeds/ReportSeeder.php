<?php

use Illuminate\Database\Seeder;
use App\Report;
class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Report::create([
            'description'=>'dia productivo',
            'date'=>'2019-06-14',
            'employee_id'=>1,

        ]);
        Report::create([
            'description'=>'dia productivo',
            'date'=>'2019-06-13',
            'employee_id'=>1,

        ]);
        Report::create([
            'description'=>'dia productivo',
            'date'=>'2019-06-12',
            'employee_id'=>1,

        ]);
        Report::create([
            'description'=>'dia productivo',
            'date'=>'2019-06-11',
            'employee_id'=>1,

        ]);
    }
}
