<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

class EmployeeObserver
{
    /**
     * Handle the app modules catalog models product "created" event.
     *
     * @return void
     */
    public function created(Employee $employee)
    {
        Employee::where('id', $employee->id)->update(['fullname'=>$employee->fname.' '.$employee->lname]);
        // $this->update_fullname($employee);
    }

    /**
     * Handle the app modules catalog models product "updated" event.
     *
     * @return void
     */
    public function updated(Employee $employee)
    {
        Employee::where('id', $employee->id)->update(['fullname'=>$employee->fname.' '.$employee->lname]);
        // $this->update_fullname($employee);
    }

    /**
     * Handle the app modules catalog models product "deleted" event.
     *
     * @return void
     */
    public function deleted(Employee $employee)
    {

    }

    /**
     * Handle the app modules catalog models product "restored" event.
     *
     * @return void
     */
    public function restored(Employee $employee)
    {

    }

    /**
     * Handle the app modules catalog models product "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {

    }

    public function update_fullname(Employee $employee)
    {
        $employee->fullname = $employee->fname.' '.$employee->lname;
        $employee->save();
    }

}
