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
    protected $signature = 'cms:install:gui {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '"disable" or "enable" installation by gui';

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
        $action = $this->argument('action');

        if( !is_writable($coreFile = cms_path('root', 'cms/core.php')) ){
            return $this->error('Do not have permission to write file cms/core.php');
        }

        if( $action === 'enable' ){
            file_put_contents( $coreFile, file_get_contents( cms_path('root','cms/temporarySample/install.txt')) );
            return $this->info('Install CMS by GUI  has been turned on, please visit URL "/install" with a web browser to proceed with the installation');
        }elseif( $action === 'disable' ){
            file_put_contents( $coreFile, file_get_contents( cms_path('root','cms/temporarySample/core.txt')) );
            return $this->info('The function install CMS by GUI has been turned off.');
        }else{
            return $this->error('don\'t understand action "'.$action.'". Please review the list of support actions: disable, enable');
        }

    }
}
