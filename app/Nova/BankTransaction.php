<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;
use Laravel\Nova\Query\Search\SearchableMorphToRelation;
use Carbon\Carbon;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;

use App\Nova\Actions\ImportBankTransaction;
use App\Nova\Actions\MailBankTransaction;

use Sereny\NovaSearchableFilter\SearchableFilter;

class BankTransaction extends Resource
{
    public static $trafficCop = false;
    public static $showColumnBorders = true;
    // public static $tableStyle = 'tight';
    public static $perPageOptions = [50, 100, 150, 200];
    public static $canImportResource = true;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BankTransaction>
     */
    public static $model = \App\Models\BankTransaction::class;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['employee'];

     /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','description','account','bank'
    ];

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Tranzactii bancare';
    }
    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Tranzactie bancara';
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

    public function authorizedToView(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
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

            BelongsTo::make('Angajat', 'employee', Employee::class)
                ->searchable()
                ->withoutTrashed()
                ->sortable(),

            Text::make('Document','no_document')
                ->rules('max:255')
                ->sortable(),

            Currency::make('Debit','debit')
                ->step(0.01)
                ->displayUsing(fn ($value) => $value ? $value.' lei' : '')
                ->sortable(),

            Currency::make('Credit','credit')
                ->step(0.01)
                ->displayUsing(fn ($value) => $value ? $value.' lei' : '')
                ->sortable(),

            Text::make('Descriere','description')
                ->rules('max:255')
                ->sortable(),

            Text::make('Cont','account')
                ->rules('max:255')
                ->sortable(),

            Date::make('Data','purchased_at')
                ->sortable()
                ->rules('nullable', 'date')
                ->displayUsing(fn ($value) => $value ? $value->format('Y-m-d') : ''),

            Text::make('Bank','bank')
                ->rules('max:255')
                ->sortable(),

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
            SearchableFilter::make(__('Angajat'), 'employee'),
            new Filters\FilterBankTransactionDivision,
            new Filters\FilterBankTransactionPurchased,
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
            ImportBankTransaction::make()->standalone(),
            MailBankTransaction::make()->standalone()
        ];
    }
}
