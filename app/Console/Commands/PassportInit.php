<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\Passport;

class PassportInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dms:passport-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init passport package';

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
        $this->call('passport:keys', ['--force' => true]);

        $client = Passport::client()->forceFill([
            'user_id' => null,
            'name' => 'Password Grant',
            'secret' => 'PASSWORD_GRANT_CLIENT_SECRET_PUBLIC',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);

        $client->save();
    }
}
