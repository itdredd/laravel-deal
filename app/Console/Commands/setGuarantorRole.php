<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class setGuarantorRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:setguarantor {user} {--value=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting is_guarantor';

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
            $user->is_guarantor = $this->option('value') ?? 1;
            $user->save();
            return Command::SUCCESS;
        }
        else {
            return Command::FAILURE;
        }
    }
}
