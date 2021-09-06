<?php namespace App\Module;

use Illuminate\Support\ServiceProvider;

class AppModule extends ServiceProvider {

    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/Module/*.php') as $filename){
            require_once($filename);
        }
    }

}
