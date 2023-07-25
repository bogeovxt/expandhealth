<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;
use Laravel\Nova\Query\Search\SearchableMorphToRelation;
use Carbon\Carbon;

use Laravel\Nova\Actions\ExportAsCsv;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;

use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Heading;

use App\Nova\Actions\ImportEmployee;

// use App\Observers\EmployeeObserver;

class Employee extends Resource
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
    public static $with = ['division'];


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
     * Get the searchable columns for the resource.
     *
     * @return array
     */
    public static function searchableColumns()
    {
        return ['id','fname','lname','cnp','location','nextup_id','colorful_id', new SearchableRelation('division', 'name')];
    }

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Angajati');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Angajat');
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

    public function authorizedToReplicate(Request $request)
    {
        return false;
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

            Text::make(__('Nume'),'fullname')
                ->sortable()
                ->onlyOnIndex(),

            Text::make(__('Nume'),'lname')
                ->rules('required', 'max:255')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('Prenume'),'fname')
                ->rules('required', 'max:255')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('CNP'),'cnp')
                ->rules('required', 'max:255')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('Email'),'email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:employees,email')
                ->updateRules('unique:employees,email,{{resourceId}}')
                ->sortable(),

            Text::make(__('Email2'),'email2')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('Phone'),'phone')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make(__('Phone2'),'phone2')
                ->sortable()
                ->hideFromIndex(),

            Date::make(__('Birthday'),'birthday')
                ->rules('required', 'max:255')
                ->sortable()
                ->hideFromIndex(),

            Date::make(__('Angajat la'),'employment_at')
                ->sortable()
                ->hideFromIndex(),

            Select::make(__('Locatie'),'location')->options([
                    'B' => 'Bucuresti',
                    'AB' => 'Alba',
                    'AR' => 'Arad',
                    'AG' => 'Arges',
                    'BC' => 'Bacau',
                    'BH' => 'Bihor',
                    'BN' => 'Bistrita - Nasaud',
                    'BT' => 'Botosani',
                    'BR' => 'Braila',
                    'BV' => 'Brasov',
                    'BZ' => 'Buzau',
                    'CL' => 'Calarasi',
                    'CS' => 'Caras - Severin',
                    'CJ' => 'Cluj',
                    'CT' => 'Constanta',
                    'CV' => 'Covasna',
                    'DB' => 'Dambovita',
                    'DJ' => 'Dolj',
                    'GL' => 'Galati',
                    'GR' => 'Giurgiu',
                    'GJ' => 'Gorj',
                    'HR' => 'Harghita',
                    'HD' => 'Hunedoara',
                    'IL' => 'Ialomita',
                    'IS' => 'Iasi',
                    'IF' => 'Ilfov',
                    'MM' => 'Maramures',
                    'MH' => 'Mehedinti',
                    'MS' => 'Mures',
                    'NT' => 'Neamt',
                    'OT' => 'Olt',
                    'PH' => 'Prahova',
                    'SJ' => 'Salaj',
                    'SM' => 'Satu Mare',
                    'SB' => 'Sibiu',
                    'SV' => 'Suceava',
                    'TR' => 'Teleorman',
                    'TM' => 'Timis',
                    'TL' => 'Tulcea',
                    'VL' => 'Valcea',
                    'VS' => 'Vaslui',
                    'VN' => 'Vrancea',
                ])->displayUsingLabels()
                ->sortable()
                ->searchable(),


            BelongsTo::make(__('Divizie'), 'division', Division::class)
                ->searchable()
                ->sortable()
                ->showCreateRelationButton(),

            Text::make(__('NextUp'),'nextup_id')
                ->rules('required', 'max:255'),

            Text::make(__('Colorful'),'colorful_id')
                ->rules('required', 'max:255')
                ->sortable(),

            Boolean::make('Status','is_active')
                ->trueValue('1')
                ->falseValue('0')
        ];
    }

    /**
     * Resource Index
     *
     * @return array
     */
    public function fieldsForIndex(Request $request)
    {
        $dataFields[] = Stack::make(__('Angajat'), [
            Line::make(__('Prenume'),function(){
                return $this->fname;
            })->asSubTitle()->extraClasses('inertia-link-active'),
            Line::make(__('Nume'),function(){
                return $this->lname;
            })->asSubTitle()->extraClasses('inertia-link-active'),
        ]);

        $dataFields[] = Stack::make(__('Divizie'), [
            Line::make(__('Divizie'),function(){
                return optional($this->division)->name;
            })->asSmall()->extraClasses('inertia-link-active'),
            Line::make(__('Locatie'),function(){
                return $this->location;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Telefon'), [
            Line::make(__('Telefon Job'),function(){
                return $this->phone;
            })->asSmall()->extraClasses('inertia-link-active'),
            Line::make(__('Telefon Personal'),function(){
                return $this->phone2;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Email'), [
            Line::make(__('Email Job'),function(){
                return $this->email;
            })->asSmall()->extraClasses('inertia-link-active'),
            Line::make(__('Email Personal'),function(){
                return $this->email2;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Nextup / Colorful'), [
            Line::make(__('Nextup'),function(){
                return $this->nextup_id;
            })->asSmall(),
            Line::make(__('Colorful'),function(){
                return $this->colorful_id;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('CNP / Data nastere'), [
            Line::make(__('CNP'),function(){
                return $this->cnp;
            })->asSmall(),
            Line::make(__('Data'),function(){
                return optional($this->birthday)->format('Y-m-d');
            })->asSmall(),
        ]);

        $dataFields[] = Boolean::make('Status','is_active')
            ->trueValue('1')
            ->falseValue('0');

        return $dataFields;
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
        return [
            ImportEmployee::make()->standalone(),
            ExportAsCsv::make()->withFormat(function ($model) {
                return [
                    'ID' => $model->getKey(),
                    'Name' => $model->fullname,
                    'Email Address' => $model->email,
                ];
            }),
        ];
    }
}
