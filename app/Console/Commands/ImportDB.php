<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import default database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->components->info('Importing database, please seat tight');
        $this->callSilent('db:seed', ['--class' => 'DatabaseImport']);
        $this->components->info('Database imported successfully');
    }
}
