<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckUsersTable extends Command
{
    protected $signature = 'check:users-table';
    protected $description = 'Check the structure of the users table';

    public function handle()
    {
        $columns = DB::select('SHOW COLUMNS FROM users');
        foreach ($columns as $column) {
            $this->info($column->Field . ' - ' . $column->Type);
        }
    }
} 