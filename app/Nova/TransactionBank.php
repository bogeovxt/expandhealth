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

use App\Nova\Actions\InventoryReturnEquipment;
use App\Nova\Actions\InventoryDeliveryEquipment;
use App\Nova\Actions\InventoryReplaceEquipment;
use App\Nova\Actions\TransactionBankImport;

use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Traits\HasTabs;

use Suenerds\NovaSearchableBelongsToFilter\NovaSearchableBelongsToFilter;
use NovaErrorField\Errors;

class TransactionBank extends Resource
{

    public static $trafficCop = false;
    public static $showColumnBorders = true;
    public static $tableStyle = 'tight';
    public static $perPageOptions = [50, 100, 150, 200];
    public static $canImportResource = true;


    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TransactionBank>
     */
    public static $model = \App\Models\TransactionBank::class;

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
        'id','description','account','bank','filename'
    ];

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Tranzactii bancare');
    }
    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Tranzactie bancara');
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

            Text::make('Numar document','no_document')
                ->rules('max:255')
                ->sortable(),

            Text::make('Suma debit','debit')
                ->rules('max:255')
                ->sortable(),

            Text::make('Suma credit','credit')
                ->rules('max:255')
                ->sortable(),

            Text::make('Descriere','description')
                ->rules('max:255')
                ->sortable(),

            Text::make('Cont','account')
                ->rules('max:255')
                ->sortable(),

            Date::make('Data ','purchased')
                ->sortable(),

            Text::make('Observatii','observations')
                ->rules('max:255')
                ->sortable(),

            Text::make('Fisier','filename')
                ->rules('max:255')
                ->sortable(),

            Text::make('Bank','bank')
                ->rules('max:255')
                ->sortable(),

            Boolean::make('Procesat','is_processed')
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
        // return [new Actions\TransactionBankImport];

        return [
            TransactionBankImport::make()->standalone(),
        ];
    }
}
