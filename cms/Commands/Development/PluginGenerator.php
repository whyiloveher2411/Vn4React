<?php

namespace CMS\Commands\Development;

use Illuminate\Console\Command;

use File;

class PluginGenerator extends Command{

     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:dev:plugin:create {name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically create a new plugin based on the standard plugin structure';

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
    
        $title = $this->argument('name');
        $description = $this->argument('description');

        $name = str_slug($title);

        $content_json = [
            'name' => $title,
            'description' => $description,
            'author' => '[Plugin Generator]',
            'author_url' => '[URL]',
            'version' => '1.0.0',
        ];

        if( !File::exists( cms_path('resource').'views/plugins/'.$name) ) {

            $success = File::copyDirectory( cms_path('resource').'views/default/plugin-struct', cms_path('resource').'views/plugins/'.$name);

            File::copyDirectory(cms_path('resource').'views/plugins/'.$name.'/public/', cms_path().'plugins/'.$name.'/');

            file_put_contents(  cms_path('resource').'views/plugins/'.$name.'/info.json', json_encode($content_json, JSON_PRETTY_PRINT) );

            if (!file_exists( $public_folder_theme = cms_path().'plugins/'.$name )) {
                mkdir( $public_folder_theme, 0777, true);
            }

            $this->info('Create the plugin successfully');
            return $this->info('Please fully update the plugin\'s information when everything is complete at "'.'views/plugins/'.$name.'/info.json'.'"');

        }else{
            return $this->error('Plugin directory name "'.$title.'" already exists, please choose another one');
        }
    }

}