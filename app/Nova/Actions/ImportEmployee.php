<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use Maatwebsite\Excel\Facades\Excel;

use Lednerb\ActionButtonSelector\ShowAsButton;

use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;

use App\Imports\EmployeeImport;


class ImportEmployee extends Action
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    public $name = 'Importa';
    public $standalone = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Excel::import(new EmployeeImport, $fields->file);

        return Action::message('It worked!')->redirect('https://inventar.vextor.eu/cms/resources/employees');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            File::make('Fisier','file')->disk('public'),
        ];
    }
}
