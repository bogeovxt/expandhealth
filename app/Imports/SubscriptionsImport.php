<?php

namespace App\Imports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\ToModel;

class SubscriptionsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subscription([
            'sim'                   => $row[2],
            'number'                => $row[1],
            'observations'          => '',
            'subscriptiontype_id'   => $row[0],
            'is_active'             => 1,
        ]);
    }
}
