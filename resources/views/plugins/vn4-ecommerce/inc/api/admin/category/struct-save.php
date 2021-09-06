<?php

$posts = $r->get('posts');

if( is_array($posts) ){

    $admin_object = get_admin_object('ecom_prod_cate');


    function getIdWithParent(&$listUpdateIds, $posts, $parent, &$indexLeft ){
        

        foreach( $posts as $index => $p ){
            
            $listUpdateIds[$p['id']] = [
                'title'=>$p['title'],
                'parent'=>$parent,
                'order'=> $index + 1,
                'indexLeft' => $indexLeft,
            ];

            ++$indexLeft;

            if( isset($p['children']) ){
                getIdWithParent( $listUpdateIds, $p['children'], $p['id'], $indexLeft );
                $listUpdateIds[$p['id']]['indexRight'] = $indexLeft;
            }else{
                $listUpdateIds[$p['id']]['indexRight'] = $indexLeft;
            }

            ++$indexLeft;
        }
    }


    $listUpdateIds = [];

    $index = 1;

    getIdWithParent($listUpdateIds, $posts, 0, $index);
    
    // $temp = [];

    // foreach( $listUpdateIds as $p ){
    //     if( !isset($temp[$p['indexLeft']]) && !isset($temp[$p['indexRight']]) ){
    //         $temp[$p['indexLeft']] = 1;
    //         $temp[$p['indexRight']] = 1;
    //     }else{
    //         dd($p);
    //     }
    // }

    $updateSqlParentID = '';
    $updateSqlParentData = '';
    $updateSqlOrder = '';
    $updateParent_lft = '';
    $updateParent_rgt = '';

    $posts = DB::table( $admin_object['table'] )->whereIn('id',array_keys($listUpdateIds) )->get()->keyBy('id');

    foreach( $listUpdateIds as $id => $dataID ){

        $parent = $dataID['parent'];
        $order = $dataID['order'];

        $updateSqlParentID .= ' WHEN '.$id.' THEN '.$parent;
        $updateSqlOrder .= ' WHEN '.$id.' THEN '.$order;

        $updateParent_lft .= ' WHEN '.$id.' THEN '.$dataID['indexLeft'];
        $updateParent_rgt .= ' WHEN '.$id.' THEN '.$dataID['indexRight'];


        if( $parent && isset($posts[$parent]) ){
            $updateSqlParentData .= ' WHEN '.$id.' THEN \''.json_encode([
                'id'=>$parent,
                'title'=>$posts[$parent]->title,
                'type'=>$posts[$parent]->type,
                'slug'=>$posts[$parent]->slug
            ], JSON_UNESCAPED_UNICODE ).'\'';
        }else{
            $updateSqlParentData .= ' WHEN '.$id.' THEN \'\'';
        }

    }

    $updateSqlParentID .= ' END';
    $updateSqlParentData .= ' END';
    $updateSqlOrder .= ' END';
    $updateParent_lft .= ' END';
    $updateParent_rgt .= ' END';

    DB::select(DB::raw(
        'UPDATE '.$admin_object['table'].
        ' SET `parent` = CASE id '.$updateSqlParentID.',
            `parent_detail` = CASE id '.$updateSqlParentData.',
            `parent_lft` = CASE id '.$updateParent_lft.',
            `parent_rgt` = CASE id '.$updateParent_rgt.',
            `order` = CASE id '.$updateSqlOrder.
        ' WHERE id IN('. join(',',array_keys($listUpdateIds)) .')'
    ));
    
    return [
        'message'=>apiMessage('Save changes successfully')
    ];

}

return [
    'message'=>apiMessage('Save Changes Error','error')
];