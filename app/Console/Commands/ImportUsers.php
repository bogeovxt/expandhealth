<?php

namespace App\Console\Commands;

use App\Imports\UsersImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Excel;

class ImportUsers extends Command
{
    protected $signature = 'import:users';

    protected $description = 'Laravel User Import';

    public function handle()
    {
        $this->output->title('Starting import');
        (new UsersImport)->withOutput($this->output)->import('users.csv', 'local', \Maatwebsite\Excel\Excel::CSV);
        $this->output->success('Import successful');
    }
}
