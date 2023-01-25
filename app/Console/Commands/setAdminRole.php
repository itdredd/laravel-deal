<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class setAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:setadmin {user} {--value=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting is_admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));
        if($user)
        {
            $user->is_admin = $this->option('value') ?? 1;
            $user->save();
            return Command::SUCCESS;
        }
        else {
            return Command::FAILURE;
        }
    }
}
