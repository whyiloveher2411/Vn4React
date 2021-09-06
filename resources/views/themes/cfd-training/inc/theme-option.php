<?php


add_filter('theme_options',function($theme_options){

    $theme_options['gift_coin'] = [
        'fields'=>[
            'gift'=>[
                'view'=>'repeater',
                'sub_fields'=>[
                    'label'=>['title'=>'Title','view'=>'text'],
                    'coin'=>['title'=>'COIN','view'=>'number'],
                ]
            ],
        ]
    ];

    return $theme_options;

});


