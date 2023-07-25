<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Carbon\Carbon;

use App\Nova\Actions\LaptopsExport;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;

// use Laravel\Nova\Query\Search\SearchableRelation;
// use Laravel\Nova\Query\Search\SearchableMorphToRelation;


class Laptop extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Laptop>
     */
    public static $model = \App\Models\Laptop::class;

    public static $trafficCop = false;
    public static $showColumnBorders = true;
    public static $tableStyle = 'tight';
    public static $perPageOptions = [50, 100, 150, 200];
    public static $canImportResource = false;

    public static $with = [
        'device',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'serial_number';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->device->name.' - '.$this->serial_number;
    }

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'device' => ['name'],
    ];

    // /**
    //  * The columns that should be searched.
    //  *
    //  * @var array
    //  */
    public static $search = [
        'id','inventory_code','serial_number',
    ];


    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Laptopuri');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Laptop');
    }

    /**
     * Indicates whether Nova should prevent the user from leaving an unsaved form, losing their data.
     *
     * @var bool
     */
    public static $preventFormAbandonment = true;

   /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return \Laravel\Nova\URL|string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey().'/'.$resource->getKey();
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return \Laravel\Nova\URL|string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('Echipament'), 'device', Device::class)
                ->searchable()
                ->showCreateRelationButton(),

            Text::make(__('Service TAG/S.N./IMEI'),'serial_number')
                ->sortable()
                ->rules('max:255'),

            Text::make(__('Cod Inventar'),'inventory_code')
                ->sortable()
                ->rules('max:255'),

            Date::make(__('Achizitionat'),'purchased')
                ->sortable(),

            Text::make(__('Accesorii'),'accessory')
                ->sortable()
                ->rules('max:255'),

            Textarea::make(__('Observatii'),'observations')
                ->sortable()
                ->rules('max:255'),

            Boolean::make('Status','is_active')
                ->trueValue('1')
                ->falseValue('0')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\FilterStatus,
            new Filters\FilterDeviceLaptop,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
