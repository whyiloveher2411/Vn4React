<?php

namespace CMS\Commands;

use Illuminate\Console\Command;

class DbCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:db:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically check and create tables in the database';

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

        $this->line("\n".'Start Check Database...');
        if( config('database.default') === 'mysql' ){
            use_module('check_database_mysql');
            $this->info("\n".'The database is ready to be used.');
        }else{
            $this->error("\n".'Check Database valid only on mysql database management system');
        }
    }
}
