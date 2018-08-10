<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class InitTestDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dms:create-test-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init test database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::connection()->statement('CREATE DATABASE dms_test');
        return true;
    }
}
