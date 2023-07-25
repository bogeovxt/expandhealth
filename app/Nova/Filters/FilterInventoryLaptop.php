<?php

namespace App\Nova\Filters;

use App\Models\Device;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterInventoryLaptop extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Model Laptop');
    }

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public $singleSelect = true;

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
        $laptopIds = [];
        $laptops = Laptop::where('device_id',$value)->get();
        foreach($laptops as $laptop)
            $laptopIds[] = $laptop->id;

        return $query->whereIn('laptop_id',$laptopIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Device::where('devicetype_id',3)->get()->pluck('id', 'name');
    }

}
