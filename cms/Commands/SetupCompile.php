<?php

namespace CMS\Commands;

use Illuminate\Console\Command;

class SetupCompile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:setup:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To compile code before installing the Magento application';

    protected $listCompile = [
        \CMS\Commands\SetupCompile\Hook::class,
        \CMS\Commands\SetupCompile\PostType::class,
    ];

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
        foreach( $this->listCompile as $compile ){

            $compileObject = new $compile($this);
            $result = $compileObject->handle();

            if( $result ){
                $this->info("\n". $compileObject->getSuccessMessage());
            }else{
                $this->error("\n". $compileObject->getErrorMessage());
            }
        }
    }
}
