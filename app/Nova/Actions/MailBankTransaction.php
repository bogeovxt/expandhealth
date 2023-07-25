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

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\DecontEmail;


class MailBankTransaction extends Action
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    public $name = 'Trimite emailuri';
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
        $rows = [];
        $rows[] = [
            'date' => '2023-05-31',
            'debit' => '0 lei',
            'credit' => '100 lei',
            'descriere' => '5581 ING OFFICE T PALLADY Retragere numerar BUCURESTI RO',
        ];
        $rows[] = [
            'date' => '2023-05-01',
            'debit' => '0 lei',
            'credit' => '100 lei',
            'descriere' => '5589 OFFICE SV NORDIC Retragere numerar SUCEAVA RO',
        ];
        $rows[] = [
            'date' => '2023-05-15',
            'debit' => '0 lei',
            'credit' => '130 lei',
            'descriere' => '5675 OFFICE GL ENERGIEI Retragere numerar GALATI RO',
        ];
        $rows[] = [
            'date' => '2023-05-23',
            'debit' => '0 lei',
            'credit' => '100 lei',
            'descriere' => 'DOMINOS PIZZA MARGEANULUI Cumparare POS BUCURESTI RO',
        ];
        $rows[] = [
            'date' => '2023-05-23',
            'debit' => '262 lei',
            'credit' => '0 lei',
            'descriere' => 'Juncu Stefania Incasare restituire avans decont',
        ];

        $maildata = [
            'title' => 'George Chelaru',
            'period' => '2023-05-01 - 2023-05-30',
            'rows' => $rows
        ];
        $email_to = 'bogdanchelaru@gmail.com';
        // $email_to = 'geroge.chelaru@expand.ro';

        Mail::to($email_to)->send(new DecontEmail($maildata));



        // foreach (['bogdanchelaru@gmail.com'] as $recipient) {
        //     Mail::to($email_to)->send(new DecontEmail($decont));
        // }

        return Action::message('It worked!');
        dd('Merge');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
