<?php

namespace CMS\Commands\Development;

use Illuminate\Console\Command;

use File;

class ThemeGenerator extends Command{

     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:dev:theme:create {name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically create a new theme based on the standard theme structure';

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
        $name = $this->argument('name');
        $description = $this->argument('description');

        $theme_name = str_slug($name);

        $author = '[Theme Generator]';
        $author_url = '[URL]';
        $tags = '';

        if( !File::exists( cms_path('resource').'views/themes/'.str_slug($theme_name)) ) {

            $success = File::copyDirectory( cms_path('resource').'views/default/theme-struct', cms_path('resource').'views/themes/'.$theme_name);

            File::copyDirectory(cms_path('resource').'views/themes/'.$theme_name.'/public/', cms_path().'themes/'.$theme_name.'/');

            $content_json = [
                'name' => $name,
                'description' => $description,
                'author' => $author,
                'author_url' => $author_url,
                'version' => '1.0.0',
                'tags'=>$tags
            ];

            file_put_contents(  cms_path('resource').'views/themes/'.$theme_name.'/info.json', json_encode($content_json, JSON_PRETTY_PRINT) );

            if (!file_exists( $public_folder_theme = cms_path().'themes/'.$theme_name )) {
                mkdir( $public_folder_theme, 0777, true);
            }

            $this->info('Create new theme successfully');
            return $this->info('Please fully update the plugin\'s information when everything is complete at "'.'views/themes/'.$theme_name.'/info.json'.'"');


        }else{
            return $this->error('Theme directory name "'.$title.'" already exists, please choose another one');
        }

    }
}