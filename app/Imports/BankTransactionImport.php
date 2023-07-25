<?php

namespace App\Imports;

use App\Models\BankTransaction;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class BankTransactionImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        //preluare angajati
        $employees = Employee::whereNotNull('nextup_id')->pluck('id','nextup_id');

        $collection->shift();

        foreach ($collection->all() as $row)
        {
            if (!isset($row[0]) || !isset($row[1]) || !isset($row[7]))
                continue;

            //data
            $tdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]);
            $ndate = $tdate->format('Y-m-d');

            BankTransaction::create([
                'employee_id' => !empty($employees[$this->cleanCol($row[7])])?$employees[$this->cleanCol($row[7])]:0,
                'no_document' => isset($row[3])?$this->cleanCol($row[3]):null,
                'debit' => isset($row[4])?$this->cleanCol($row[4]):null,
                'credit' => isset($row[5])?$this->cleanCol($row[5]):null,
                'description' => isset($row[6])?$this->cleanCol($row[6]):null,
                'account' => isset($row[7])?$this->cleanCol($row[7]):null,
                'purchased_at' => $ndate,
                'bank' => 'ING',
                'is_processed' => 0,
             ]);
            //  return true;
        }
    }

    protected function cleanCol($str)
    {
        $str = trim($str);
        $str=str_replace("\r\n","",$str);
        return $str;
    }
}
