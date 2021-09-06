<?php

namespace CMS\Commands\SetupCompile;

class Compile{
    
    protected $command;

    protected $messageSuccess;
    protected $messageError;

    public function __construct(\CMS\Commands\SetupCompile $command)
    {
        $this->command = $command;
    }

    public function handle(){
        $this->command->info(get_class($this)." Do nothing\n");
    }

    protected function line($message){
        $this->command->line("\n".$message);
    }

    public function getSuccessMessage(){
        return $this->messageSuccess;
    }

    public function getErrorMessage(){
        return $this->messageError;
    }

}