<?php

namespace CMS\Commands;

use Illuminate\Console\Command;
use File;
use Config;

class DeployAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:deploy:asset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is synchronizing your resource in the development with your copy in the real product';

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

        $this->line("\n");
        $this->line('Start copying theme assets Plugins');

        $plugins = $list = File::directories(Config::get('view.paths')[0].'/plugins/');

        $bar = $this->output->createProgressBar(count($plugins));

        $bar->start();

        foreach ($plugins as $value) {

            $folder_theme = basename($value);
            
            File::copyDirectory(cms_path('resource').'views/plugins/'.$folder_theme.'/public/', cms_path().'plugins/'.$folder_theme.'/');

            $bar->advance();
        }

        $theme = theme_name();

        File::copyDirectory(cms_path('resource').'views/themes/'.$theme.'/public/', cms_path().'themes/'.$theme.'/');


        $themes = $list = File::directories(Config::get('view.paths')[0].'/themes/');

        $this->line("\n\n".'Start copying theme assets Theme');

        foreach ($themes as $value) {

            if( file_exists($file = $value.'/public/screenshot.png') ){
                $folder_theme = basename($value);

                File::isDirectory( cms_path('public').'themes/'.$folder_theme ) or File::makeDirectory( cms_path('public').'themes/'.$folder_theme , 0777, true, true);

                File::copy($file,cms_path('public').'themes/'.$folder_theme.'/screenshot.png');
            }

        }
        $bar->finish();
        $this->line("\n".'The resource has been copied to the directory and ready to use.');
        $this->info("Done\n");

    }
}
