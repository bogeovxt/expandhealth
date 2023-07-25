<?php

namespace App\Nova\Filters;

use App\Models\Device;
use App\Models\Tablet;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterInventoryTablet extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Model Tableta');
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
        $tabletIds = [];
        $tablets = Tablet::where('device_id',$value)->get();
        foreach($tablets as $tablet)
            $tabletIds[] = $tablet->id;

        return $query->whereIn('tablet_id',$tabletIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Device::where('devicetype_id',4)->get()->pluck('id', 'name');
    }

}
