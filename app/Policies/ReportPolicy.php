<?php

namespace App\Policies;

use App\User;
use App\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the report.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    //si el usuario tiene rol empleado puede generar un reporte
    public function create(User $user)
    {
        //
        return $user->has_role(2);
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    //si el empleado es el que genero el reporte, puede actualizarlo o es usuario admin
    public function update(User $user, Report $report)
    {
        //
        if($user->has_role(1)){
            return true;
        }
        elseif($report->employee!=null){
            return $report->employee->id===$user->employee->id;
        }


        return false;

    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    //si el empleado es el que genero el reporte,puede eliminarlo o es usuario admin
    public function delete(User $user, Report $report)
    {
        //
        if($user->has_role(1)){
            return true;
        }
        elseif($report->employee!=null){
            return $report->employee->id===$user->employee->id;
        }


        return false;
    }

    /**
     * Determine whether the user can restore the report.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the report.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        //
    }
}
