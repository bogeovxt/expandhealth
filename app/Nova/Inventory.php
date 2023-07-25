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

class Inventory extends Resource
{
    use HasTabs;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Inventory>
     */
    public static $model = \App\Models\Inventory::class;

    public static $trafficCop = false;
    public static $showColumnBorders = true;
    public static $tableStyle = 'tight';//'tight';
    public static $perPageOptions = [50, 100, 150, 200];
    public static $canImportResource = false;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user','employee','phone','laptop','monitor','projector','tablet','usbstick'];


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the menu that should represent the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\Menu\MenuItem
     */
    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            return static::$model::count();
        });
    }

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'employee' => ['fullname','location'],
        'phone_sim' => ['number'],
        'tablet_sim' => ['number'],
        'usbstick_sim' => ['number'],
        'employee.division' => ['name'],
        'phone.device' => ['name'],
        'laptop.device' => ['name'],
        'tablet.device' => ['name'],
        'monitor.device' => ['name'],
        'usbstick.device' => ['name'],
    ];


    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Inventar');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Inventar');
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return true;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }

    public function authorizedToView(Request $request)
    {
        return true;
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
    public function fields(NovaRequest $request){
        return [];
    }
    public function fieldsForCreate(NovaRequest $request)
    {

        $employeesIds = $phonesIds = $laptopsIds = $tabletsIds = $usbsticksIds = $monitorsIds = $desktopsIds = $projectorsIds = $simGsmIds = $simDateIds = $simGpsIds = $simIds = [];
        $inventoryObj = Inventory::ofActive()->get();
        if(!empty($inventoryObj))
        {
            foreach($inventoryObj as $inventory)
            {
                if(!empty($inventory->employee_id))
                    $employeesIds[] = $inventory->employee_id;

                if(!empty($inventory->phone_id))
                    $phonesIds[] = $inventory->phone_id;

                if(!empty($inventory->laptop_id))
                    $laptopsIds[] = $inventory->laptop_id;

                if(!empty($inventory->tablet_id))
                    $tabletsIds[] = $inventory->tablet_id;

                if(!empty($inventory->usbstick_id))
                    $usbsticksIds[] = $inventory->usbstick_id;

                if(!empty($inventory->monitor_id))
                    $monitorsIds[] = $inventory->monitor_id;

                if(!empty($inventory->desktop_id))
                    $desktopsIds[] = $inventory->desktop_id;

                if(!empty($inventory->projector_id))
                    $projectorsIds[] = $inventory->projector_id;

                if(!empty($inventory->phone_sim_id))
                    $simGsmIds[] = $inventory->phone_sim_id;

                if(!empty($inventory->tablet_sim_id))
                    $simDateIds[] = $inventory->tablet_sim_id;

                if(!empty($inventory->usbstick_sim_id))
                    $simDateIds[] = $inventory->usbstick_sim_id;

                if(!empty($inventory->laptop_sim_id))
                    $simDateIds[] = $inventory->laptop_sim_id;

                // if(!empty($inventory->gps_sim_id))
                //     $simGpsIds[] = $inventory->gps_sim_id;
            }
        }

        //angajatii activi care nu sunt deja alocati
        $employees = \App\Models\Employee::ofSelected($employeesIds)->ofActive()->pluck('fullname','id')->toArray();

        //telefoanele care nu sunt deja alocate
        $phonesObj = \App\Models\Phone::with('device')->ofWithoutSelected($phonesIds)->ofActive()->get();
        $phones = [];
        if(!empty($phonesObj))
            foreach($phonesObj as $phone)
                $phones[$phone->id] = $phone->device->name.' - '.$phone->serial_number;

        //laptopurile care nu sunt deja alocate
        $laptopsObj = \App\Models\Laptop::with('device')->ofSelected($laptopsIds)->ofActive()->get();
        $laptops = [];
        if(!empty($laptopsObj))
            foreach($laptopsObj as $laptop)
                $laptops[$laptop->id] = $laptop->device->name.' - '.$laptop->serial_number;

        //tablete care nu sunt deja alocate
        $tabletsObj = \App\Models\Tablet::with('device')->ofSelected($tabletsIds)->ofActive()->get();
        $tablets = [];
        if(!empty($tabletsObj))
            foreach($tabletsObj as $tablet)
                $tablets[$tablet->id] = $tablet->device->name.' - '.$tablet->serial_number;

        //usbsticks care nu sunt deja alocate
        $usbsticksObj = \App\Models\Usbstick::with('device')->ofSelected($usbsticksIds)->ofActive()->get();
        $usbsticks = [];
        if(!empty($usbsticksObj))
            foreach($usbsticksObj as $usbstick)
                $usbsticks[$usbstick->id] = $usbstick->device->name.' - '.$usbstick->serial_number;

        //priectoare care nu sunt deja alocate
        $projectortsObj = \App\Models\Projector::with('device')->ofSelected($projectorsIds)->ofActive()->get();
        $projectors = [];
        if(!empty($projectortsObj))
            foreach($projectortsObj as $projector)
                $projectors[$projector->id] = $projector->device->name.' - '.$projector->serial_number;

        //monitoare care nu sunt deja alocate
        $monitorsObj = \App\Models\Monitor::with('device')->ofSelected($monitorsIds)->ofActive()->get();
        $monitors = [];
        if(!empty($monitorsObj))
            foreach($monitorsObj as $monitor)
                $monitors[$tablet->id] = $monitor->device->name.' - '.$monitor->serial_number;

        //desktopuri care nu sunt deja alocate
        $desktopsObj = \App\Models\Desktop::with('device')->ofSelected($desktopsIds)->ofActive()->get();
        $desktops = [];
        if(!empty($desktopsObj))
            foreach($desktopsObj as $desktop)
                $desktops[$desktop->id] = $desktop->device->name.' - '.$desktop->serial_number;

        //Simuri care nu sunt deja alocate
        $sim_gsm = $sim_date = $sim_gps = [];
        $simIds = array_merge($simGsmIds,$simDateIds);
        $simObj = \App\Models\Subscription::with('subscriptiontype')->ofActive()->get();
        if(!empty($simObj))
        {
            foreach($simObj as $sim)
            {
                if(!array_key_exists($sim->id, $simIds))
                    switch ($sim->subscriptiontype->type_sim)
                    {
                        case '5G':
                            $sim_gsm[$sim->id] = $sim->number.' - '.$sim->subscriptiontype->price.' Eur - '.$sim->sim;
                            break;
                        case 'Date':
                            $sim_date[$sim->id] = $sim->number.' - '.$sim->subscriptiontype->price.' Eur - '.$sim->sim;
                            break;
                        case 'GPS':
                            $sim_gps[$sim->id] = $sim->number.' - '.$sim->subscriptiontype->price.' Eur - '.$sim->sim;
                            break;
                    }
            }
        }

        $dataFields[] = Select::make(__('Angajat'),'employee_id')
            ->options($employees)
            ->searchable();

        $dataFields[] = Select::make(__('Telefon'),'phone_id')
            ->options($phones)
            ->searchable();

        $dataFields[] = Select::make(__('SIM Telefon'),'phone_sim_id')
            ->options($sim_gsm)
            ->searchable();

        $dataFields[] = Select::make(__('Laptop'),'laptop_id')
            ->options($laptops)
            ->searchable();

        $dataFields[] = Select::make(__('SIM Laptop'),'laptop_sim_id')
            ->options($sim_date)
            ->searchable();

        $dataFields[] = Select::make(__('Tableta'),'tablet_id')
            ->options($tablets)
            ->searchable();

        $dataFields[] = Select::make(__('SIM Tableta'),'tablet_sim_id')
            ->options($sim_date)
            ->searchable();

        $dataFields[] = Select::make(__('Usbstick'),'usbstick_id')
            ->options($usbsticks)
            ->searchable();

        $dataFields[] = Select::make(__('SIM Usbstick'),'usbstick_sim_id')
            ->options($sim_date)
            ->searchable();

        $dataFields[] = Select::make(__('Proiector'),'projector_id')
            ->options($projectors)
            ->searchable();

        $dataFields[] = Select::make(__('Desktop'),'desktop_id')
            ->options($desktops)
            ->searchable();

        $dataFields[] = Select::make(__('Monitor'),'monitor_id')
            ->options($monitors)
            ->searchable();

        $dataFields[] = Date::make(__('Predat'),'delivered_at')
            ->sortable();

        $dataFields[] = Date::make(__('Preluat'),'received_at')
            ->sortable()
            ->nullable();

        $dataFields[] = Boolean::make('Status','is_active')
            ->trueValue('1')
            ->falseValue('0');

        return $dataFields;
    }

    public function fieldsForUpdate(NovaRequest $request)
    {

        $dataFields[] = ID::make()->sortable();
        $dataFields[] = BelongsTo::make(__('Angajat'), 'employee', Employee::class)
            ->searchable()
            // ->showCreateRelationButton()
            ->withoutTrashed();
            // ->noPeeking()
            // ->withSubtitles()
            // ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Telefon'), 'phone', Phone::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('SIM Telefon'), 'phone_sim', Subscription::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Laptop'), 'laptop', Laptop::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('SIM Laptop'), 'laptop_sim', Subscription::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Tablet'), 'tablet', Tablet::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('SIM Tableta'), 'tablet_sim', Subscription::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Usbstick'), 'usbstick', Usbstick::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('SIM Usbstick'), 'usbstick_sim', Subscription::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Proiector'), 'projector', Projector::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Desktop'), 'desktop', Desktop::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = BelongsTo::make(__('Monitor'), 'monitor', Monitor::class)
            ->searchable()
            ->showCreateRelationButton()
            ->withoutTrashed()
            ->nullable()
            ->modalSize('3xl');

        $dataFields[] = Date::make(__('Predat'),'delivered_at')
            ->sortable();

        $dataFields[] = Date::make(__('Preluat'),'received_at')
            ->sortable()
            ->nullable();

        $dataFields[] = Boolean::make('Status','is_active')
            ->trueValue('1')
            ->falseValue('0');

        return $dataFields;
    }

    /**
     * Resource Index
     *
     * @return array
     */
    public function fieldsForIndex(Request $request)
    {

        $dataFields[] = Stack::make(__('Angajat'), [
            Line::make(__('Nume'),function(){
                return optional($this->employee)->fullname;
            })->asSubTitle()->extraClasses('inertia-link-active'),
            Line::make(__('Divizie'),function(){
                return optional(optional($this->employee)->division)->name;
            })->asSmall(),
            Line::make(__('Divizie'),function(){
                return optional($this->employee)->location;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Telefon'), [
            Line::make(__('Telefon'),function(){
                return optional(optional($this->phone)->device)->name;
            })->asSubTitle(),
            Line::make(__('Abonament'),function(){
                return optional($this->phone_sim)->number;
            })->asSmall()->extraClasses('inertia-link-active'),
            Line::make(__('Abonament'),function(){
                return optional(optional($this->phone_sim)->subscriptiontype)->title;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Tableta'), [
            Line::make(__('Tableta'),function(){
                return optional(optional($this->tablet)->device)->name;
            })->asSmall(),
            Line::make(__('Abonament'),function(){
                return optional($this->tablet_sim)->number;
            })->asSmall(),
            Line::make(__('Abonament'),function(){
                return optional(optional($this->tablet_sim)->subscriptiontype)->name;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Laptop / Desktop'), [
            Line::make(__('Laptop'),function(){
                return optional(optional($this->laptop)->device)->name
                .(optional(optional($this->desktop)->device)->name)
                ?(optional(optional($this->laptop)->device)->name) ? '':' / '.optional(optional($this->desktop)->device)->name
                :'';
            })->asSmall(),
            Line::make(__('Abonament'),function(){
                return optional(optional($this->usbstick)->device)->name;
            })->asSmall(),
            Line::make(__('Abonament'),function(){
                return optional(optional($this->usbstick_sim)->subscriptiontype)->name;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Proiector / Monitor'), [
            Line::make(__('Proiector'),function(){
                return optional(optional($this->project)->device)->name;
            })->asSmall(),
            Line::make(__('Monitor'),function(){
                return optional(optional($this->monitor)->device)->name;
            })->asSmall()
        ]);

        $dataFields[] = Stack::make(__('Predat / Preluat'), [
            Line::make(__('Data'),function(){
                return optional($this->delivered_at)->format('Y-m-d');
            })->asSmall()->extraClasses('inertia-link-active'),
            Line::make(__('Data'),function(){
                return optional($this->received_at)->format('Y-m-d');
            })->asSmall(),
            Line::make(__('Utilizator'),function(){
                return optional($this->user)->name;
            })->asSmall()
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
            new Filters\FilterInventoryPhone,
            new Filters\FilterInventoryTablet,
            new Filters\FilterInventoryLaptop,
            new Filters\FilterInventoryDivision,
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
            // Action::modal('Download User Summary', 'UserSummary',  [
            //     'user_id' => optional($this->resource)->getKey(),
            // ]),
            // Action::danger('Disable User Account', 'This action is no longer available!'),
            // Action::visit('View Logs', '/nova/logs'),
            // Action::downloadUrl(
            //     'Download User Summary',
            //     route('users.summary', $this->resource)
            // ),
            InventoryReturnEquipment::make()->withoutConfirmation()->showInline(),
            InventoryDeliveryEquipment::make()->withoutConfirmation()->showInline(),

            TransactionBankImport::make()->standalone(),


            // (new AddAnonymousUserAction($this->model()))->showOnTableRow() //

            (new InventoryReplaceEquipment($this->id))
            ->onlyOnTableRow()
            // ->showInline()
            ->confirmText('Selectati echipamentele')
            ->confirmButtonText('Inlocuieste')
            ->cancelButtonText("Renunta"),

            // (new InventoryReplaceEquipment($this->model())::make()->showInline()->confirmText('Selectati echipamentele')
            // ->confirmButtonText('Inlocuieste')
            // ->cancelButtonText("Renunta"),


            // InventoryReturnEquipment::openInNewTab('Visit Stripe Dashboard', 'https://stripe.com')->withoutConfirmation()->showInline(),
        ];
    }
}
