<?php

namespace App\Nova\Filters;

use App\Models\Device;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterDeviceLaptop extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Model Echipament');
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
        return $query->where('device_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $options = [];
        // $obj = Device::all();
        $obj = Device::where('devicetype_id',3)->get();
        foreach($obj as $item)
            $options[ucfirst(strtolower($item->name))] = $item->id;
        return $options;
    }
}
