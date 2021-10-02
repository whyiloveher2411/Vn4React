<?php
if( !function_exists('updatePostRelationship') ){

    function updatePostRelationship($post){

        $admin_object = get_admin_object();

        $callbackView = [
            'relationship_onetoone'=>function($post, $postType, $fieldKey, $field){

            },
            'relationship_onetomany'=>function($post, $postType, $fieldKey, $field){

                $posts = $post->related( $postType, $fieldKey );

                $fieldRelationship = getJsonFieldRelationship($field);

                $valueUpdate = json_encode( get_post($post->type, $post->id, $fieldRelationship) );

                foreach( $posts as $p ){
                    $p->{$fieldKey.'_detail'} = $valueUpdate;
                    $p->save();
                }
                

            },
            'relationship_manytomany'=>function($post, $postType, $fieldKey, $field){

                $posts = $post->related( $postType, $fieldKey, ['select'=> ['id','type'] ] );

                $fieldRelationship = getJsonFieldRelationship($field);

                foreach( $posts as $p ){
                    $valueUpdate = json_encode( $p->relationship( $fieldKey, ['select'=>$fieldRelationship] )->toArray() );
                    $p->{$fieldKey} = $valueUpdate;
                    $p->save();
                }
            }
        ];

        foreach( $admin_object as $key => $config ){

            foreach( $config['fields']  as $fieldKey => $field ){
                if( isset($field['view']) 
                    && is_string( $field['view'] )
                    && isset( $callbackView[ $field['view'] ])
                    && isset( $field['object'] )
                    && $field['object'] === $post->type )
                {
                    if( !isset($field['isUpdateWhenChangePost']) || $field['isUpdateWhenChangePost'] ){
                        $callbackView[ $field['view'] ]($post, $key, $fieldKey, $field);
                    }
                }
            }
        }
    }

    function getJsonFieldRelationship( $field ){

        $admin_object = get_admin_object();

        if( !isset($field['fields_related']) ){
            $field['fields_related'] = [];
        }
        if( !isset($field['fields_related']) ){
            $field['fields_related'] = [];
        }

        if( array_search('id', $field['fields_related']) === false ){
            $field['fields_related'][] = 'id';
        }

        if( array_search('title', $field['fields_related']) === false ){
            $field['fields_related'][] = 'title';
        }

        if( array_search('type', $field['fields_related']) === false ){
            $field['fields_related'][] = 'type';
        }

        if( isset($admin_object[$field['object']]['fields']['slug']) && array_search('slug', $field['fields_related']) === false ){
            $field['fields_related'][] = 'slug';
        }

        return $field['fields_related'];
    }
}