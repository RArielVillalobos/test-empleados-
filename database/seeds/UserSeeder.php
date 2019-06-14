<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userAdmin=User::create([
            'name'=>'admin',
            'role_id'=>1,
            'email'=>'admin@test.com',
            'password'=>bcrypt('1234'),


        ]);
        $userEmployee=User::create([
            'name'=>'empleado',
            'role_id'=>2,
            'email'=>'empleado@test.com',
            'password'=>bcrypt('1234'),


        ]);
        $empleado=Employee::create([
            'user_id'=>$userEmployee->id,
        ]);
    }
}
