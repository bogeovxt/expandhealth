<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Queue\SerializesModels;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Heading;
// use Laravel\Nova\Fields\BelongsTo;

use App\Models\Inventory;
use App\Models\Phone;
use App\Models\Laptop;
use App\Models\Tablet;
use App\Models\Monitor;
use App\Models\Desktop;
use App\Models\Projector;
use App\Models\Usbstick;


use Whitecube\NovaFlexibleContent\Flexible;

// use Illuminate\Support\Str;
use Str;

class InventoryReplaceEquipment extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Inlocuire Echipament';

    public $modelId;

    public function __construct($modelId)
    {
        $this->modelId = $modelId;
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        if ($models->count() > 1) {
            return Action::danger('Please run this on only one user resource.');
        }

        return Action::message($fields->subject);
    }


    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $inventorySelected = Inventory::find($this->modelId);

        $devicesIds = [];
        $devices = ['phone','laptop','tablet','monitor','desktop','projector','usbstick'];
        $inventoryObj = Inventory::ofActive()->get();

        if(!empty($inventoryObj)){
            foreach($inventoryObj as $inventory){
                foreach($devices as $deviceField){
                    $field = $deviceField.'_id';
                    if(!empty($inventory->$field))
                        $devicesIds[$deviceField][] = $inventory->$field;
                }
            }
        }

        $devicesObj['phone'] = Phone::with('device')->ofWithoutSelected($devicesIds['phone'])->ofActive()->get();
        $devicesObj['laptop'] = Laptop::with('device')->ofWithoutSelected($devicesIds['laptop'])->ofActive()->get();
        $devicesObj['tablet'] = Tablet::with('device')->ofWithoutSelected($devicesIds['tablet'])->ofActive()->get();
        $devicesObj['monitor'] = Monitor::with('device')->ofWithoutSelected($devicesIds['monitor'])->ofActive()->get();
        $devicesObj['desktop'] = Desktop::with('device')->ofWithoutSelected($devicesIds['desktop'])->ofActive()->get();
        $devicesObj['projector'] = Projector::with('device')->ofWithoutSelected($devicesIds['projector'])->ofActive()->get();
        $devicesObj['usbstick'] = Usbstick::with('device')->ofWithoutSelected($devicesIds['usbstick'])->ofActive()->get();

        $devicesAvailable = [];
        foreach ($devices as $key => $device) {
            $devicesAvailable[$device] = [];
            if(!empty($devicesObj[$device]))
                foreach($devicesObj[$device] as $item)
                    $devicesAvailable[$device][$item->id] = $item->device->name.' - '.$item->serial_number;
        }

        $data = array();
        foreach ($devices as $device) {
            $newField = 'new_'.$device.'_id';

            if(!empty(optional($inventorySelected)->$device)){
                $data[] = Flexible::make('')
                    ->addLayout('Inlocuire '.$device, $device, [
                        Heading::make(Str::ucfirst($device).' actual: '.optional(optional(optional($inventorySelected)->$device)->device)->name),
                        Select::make(Str::ucfirst($device),$newField)
                            ->options($devicesAvailable[$device])
                            ->searchable(),
                        Text::make('Motiv','reason'),
                    ])
                    ->limit(1)
                    ->confirmRemove()
                    ->fullWidth()
                    ->button(Str::ucfirst($device));
            }
        }
        return $data;
    }
}
