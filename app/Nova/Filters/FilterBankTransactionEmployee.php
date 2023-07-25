<?php

namespace App\Nova\Filters;

use App\Models\Employee;
use App\Models\Division;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterBankTransactionEmployee extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Angajat');
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
        return $query->where('employee_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Employee::all()->pluck('id', 'fullname');
    }

}
