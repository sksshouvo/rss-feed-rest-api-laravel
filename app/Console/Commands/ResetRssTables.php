<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class ResetRssTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:rss-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate specific tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Truncate specific tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rss_feed_details')->truncate();
        DB::table('rss_feeds')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Tables truncated successfully.');
    }
}
