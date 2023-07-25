<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;

class EmployeeImport extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Employee>
     */
    public static $model = \App\Models\Employee::class;

    public static $trafficCop = false;
    public static $showColumnBorders = true;
    public static $tableStyle = 'tight';
    public static $perPageOptions = [50, 100, 150, 200];
    public static $canImportResource = false;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'fullname';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->fullname;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','fname','lname',
    ];


    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Angajati Import');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Angajat Import');
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

            Text::make(__('Nume Complet'),'fullname')
                ->rules('required', 'max:255'),

            Text::make(__('Nume'),'lname')
                ->rules('required', 'max:255'),

            Text::make(__('Prenume'),'fname')
                ->rules('required', 'max:255'),

            Text::make(__('CNP'),'cnp')
                ->rules('required', 'max:255'),

            Text::make(__('Email'),'email')
                ->rules('required', 'max:255'),

            Text::make(__('Email2'),'email2')
                ->rules('required', 'max:255'),

            Text::make(__('Phone'),'phone')
                ->rules('required', 'max:255'),

            Text::make(__('Phone2'),'phone2')
                ->rules('required', 'max:255'),

            Text::make(__('Birthday'),'birthday')
                ->rules('required', 'max:255'),

            Text::make(__('Angajat la'),'employment_at')
                ->rules('required', 'max:255'),

            Text::make(__('Locatie'),'location')
                ->rules('required', 'max:255'),

            Text::make(__('NextUp'),'nextup_id')
                ->rules('required', 'max:255'),

            Text::make(__('Colorful'),'colorful_id')
                ->rules('required', 'max:255'),

            Text::make(__('Divizie'),'division_id')
                ->rules('required', 'max:255'),

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
        return [];
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
