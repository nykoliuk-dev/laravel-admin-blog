<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportOldBlogData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:import-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from old blog database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Import started');

        return Command::SUCCESS;
    }
}
