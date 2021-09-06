<?php

namespace CMS\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:instal {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toggle installation mode by gui';

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
        // $answer = $this->ask('What is your name?');
        // $name = $this->choice('What is your name?', ['Trang', 'Boo'], 0);

        if ($this->confirm('Is Trang correct, do you wish to continue? [y|N]')) {
            $this->info('Success!');
        }else{
            $this->error('Error!');
        }

        // $this->line('Hello '.$name);
        // $this->info('Success!');
        // $this->comment('Success!');
        // $this->error('Success!');
        // $this->question('Success!');
    }
}
