<?php

$type = $r->get('type');

if( $type && $postType = get_admin_object($type)){
    
    $result = [];

    foreach( $postType['fields'] as $k => $field ){

        if( !isset($field['view']) ) $field['view'] = 'text';
        
        $result[$k] = $field;
        // switch ($field['view']) {
        //     case 'relationship_onetoone':
        //         $result[$k] = [
        //             'title'=> $field['title'],
        //         ];
        //         break;
        //     case 'relationship_onetomany':
        //         $result[$k] = ['title'=> $field['title'],  ];
        //         break;
        //     case 'relationship_manytomany':
        //         $result[$k] = ['title'=> $field['title']];
        //         break;
        //     case 'select':
        //         $result[$k] = ['title'=> $field['title']];
        //         break;
        //     default:
        //         $result[$k] = ['title'=> $field['title']];
        //         break;
        // }
    }
    
    return ['fields'=> $result];
}