<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class createUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user 
                            {username : user name} 
                            {--teacher : wheather the user role is teacher}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user['name'] = $this->argument('username');
        $user['email'] = $this->ask('enter user email');
        $user['password'] = Hash::make($this->secret('enter user password'));
        $user['is_teacher'] = $this->option('teacher');

        User::create($user);

        $this->info('User created successful');

        return Command::SUCCESS;
    }
}
