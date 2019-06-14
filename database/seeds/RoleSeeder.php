<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rolAdministrador=Role::create([
            'description'=>'administrador'
        ]);
        $rolEmpleado=Role::create([
            'description'=>'empleado'
        ]);

    }
}
