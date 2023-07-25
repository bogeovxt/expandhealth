<?php

namespace App\Nova\Filters;

use App\Models\Devicetype;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterDevicetype extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Tip Echipament');
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
        return $query->where('devicetype_id', $value);
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
        $obj = DeviceType::all();
        foreach($obj as $item)
            $options[ucfirst(strtolower($item->name))] = $item->id;
        return $options;
    }
}
