<?php

namespace App\Console\Commands;

use Barryvdh\Debugbar\Console\ClearCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AppOptimizeClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->components->info('Clearing everything cache, logs.');

        $this->callSilent('optimize:clear');
        File::deleteDirectory(storage_path('logs'));
        File::makeDirectory(storage_path('logs'), 0755, true, true);

        if (class_exists(ClearCommand::class)) {
            $this->callSilent('debugbar:clear');
        }

        $this->components->info('All cache/logs cleared successfully.');
    }
}
