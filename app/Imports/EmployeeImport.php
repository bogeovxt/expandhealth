<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $collection->shift();

        foreach ($collection->all() as $row)
        {
            if (!isset($row[0]) || !isset($row[1]))
                continue;

            //data
            $tdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[12]);
            $ndate = $tdate->format('Y-m-d');

            $tdate2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[13]);
            $ndate2 = $tdate2->format('Y-m-d');

            Employee::create([
                'fullname' => isset($row[0])?$this->cleanCol($row[0]):null,
                'fname' => isset($row[11])?$this->cleanCol($row[11]):null,
                'lname' => isset($row[10])?$this->cleanCol($row[10]):null,
                'cnp' => isset($row[1])?$this->cleanCol($row[1]):null,

                'email' => isset($row[3])?$this->cleanCol($row[3]):null,
                'email2' => isset($row[4])?$this->cleanCol($row[4]):null,

                'phone' => isset($row[5])?$this->cleanColPhone($row[5]):null,
                'phone2' => isset($row[6])?$this->cleanColPhone($row[6]):null,

                'birthday' => $ndate2,
                'employment_at' => $ndate,

                'location' => isset($row[14])?$this->cleanCol($row[14]):null,

                'nextup_id' => isset($row[7])?$this->cleanCol($row[7]):null,
                'colorful_id' => isset($row[9])?$this->cleanCol($row[9]):null,

                'division_id' => isset($row[8])?$this->cleanCol($row[8]):null,
                'is_active' => 1,
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

    protected function cleanColPhone($str)
    {
        $str = trim($str);
        $str=str_replace("\r\n","",$str);
        $str=str_replace(" ","",$str);
        return $str;
    }
}
