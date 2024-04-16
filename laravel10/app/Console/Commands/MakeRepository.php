<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $repositoryName = ucfirst($name);
        $repositoryPath = app_path("Repositories/{$repositoryName}.php");

        if (File::exists($repositoryPath)) {
            $this->error('Repository already exists!');
            return;
        }

        File::put($repositoryPath, $this->repositoryTemplate($repositoryName));
        $this->info('Repository created successfully.');
    }

    protected function repositoryTemplate($repositoryName)
    {
        return <<<EOT
        <?php
        
        namespace App\Repositories;
        
        class {$repositoryName}
        {

        }
        
        EOT;
    }
}
