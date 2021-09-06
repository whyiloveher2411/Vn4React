<?php

namespace CMS\Commands\SetupCompile;

class PostType extends Compile{

    protected $messageSuccess = 'Compile PostType successful!';
    protected $messageError = 'Compile PostType error!';

    public function handle(){
        $this->line('Start compiling post type');


        $this->line('Fisnished compiling post type');
        return true;
    }
}