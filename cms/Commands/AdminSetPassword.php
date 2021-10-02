<?php

namespace CMS\Commands;

use Illuminate\Console\Command;
use App\Support\DripEmailer;
use Hash;

class AdminSetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:account:password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for admin account cms';

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

        $email = $this->argument('email');

        $users = get_posts('user', ['callback'=>function($q) use ($email) {
            $q->where('email', $email);
        }]);

        if( count($users) < 1 ){
            return $this->error('Can\'t find the account with email '.$email);
        }

        $password = $this->secret('What is new the password?');
        
        while ( strlen($password) < 8 ) {
            $this->warn('Password length should not be less than 8');
            $password = $this->secret('Please re-enter password!');
        }
        
        $users[0]->password = Hash::make($password);
        
        $users[0]->save();

        $this->info('Change password successfully.');
        
    }
}
