<?php

namespace App\Nova\Filters;

use App\Models\Employee;
use App\Models\Division;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterBankTransactionDivision extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Divizie');
    }

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $employeeIds = [];
        $employees = Employee::where('division_id',$value)->get();
        foreach($employees as $employee)
            $employeeIds[] = $employee->id;

        return $query->whereIn('employee_id',$employeeIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Division::all()->pluck('id', 'name');
    }

}
