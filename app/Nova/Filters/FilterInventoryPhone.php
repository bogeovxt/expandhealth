<?php

namespace App\Nova\Filters;

use App\Models\Device;
use App\Models\Phone;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterInventoryPhone extends Filter
{
    /**
     * Filter Title
     * @return array|string|null
     */
    public function name(){
        return __('Model Telefon');
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
        $phoneIds = [];
        $phones = Phone::where('device_id',$value)->get();
        foreach($phones as $phone)
            $phoneIds[] = $phone->id;

        return $query->whereIn('phone_id',$phoneIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Device::where('devicetype_id',1)->get()->pluck('id', 'name');
    }

}
