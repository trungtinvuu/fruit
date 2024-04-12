<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetAndClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and clear';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('clear-compiled');
    }
}
