<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

//

// fetch command classes from different sources and  register it here.
if (app()->runningInConsole()) {
    Illuminate\Console\Application::starting(function ($artisan){
        $artisan->resolveCommands(\CMS\Commands\DbBackup::class);
        $artisan->resolveCommands(\CMS\Commands\DbCheck::class);
        $artisan->resolveCommands(\CMS\Commands\DeployAsset::class);
        $artisan->resolveCommands(\CMS\Commands\Install::class);
        $artisan->resolveCommands(\CMS\Commands\SetupCompile::class);
        $artisan->resolveCommands(\CMS\Commands\ViewClear::class);
        $artisan->resolveCommands(\CMS\Commands\ViewMinify::class);
        $artisan->resolveCommands(\CMS\Commands\AdminSetPassword::class);
    });
}

