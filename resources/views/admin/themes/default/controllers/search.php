<?php

return [
	'index'=>function($r){

		$admin_object = get_admin_object();

        $search = trim($r->get('search'));

        $stringSearchArray = explode(':', $search);

        $keySearch = mb_strtolower( str_replace(' ', '', preg_replace( '/[^ \w]+/', '', $stringSearchArray[0])));

        $searchArray = include backend_resources('page/search/search.php');

        $channel = 'default';

        if( $stringSearchArray[0] !== 'post' ){

            if( isset($searchArray[$keySearch]) && isset($stringSearchArray[1]) ){
                $channel = $keySearch;
            }elseif( isset($searchArray[$keySearch]) ){
                $channel = $keySearch;
            }

        }


        $data = [];

        if( is_array($searchArray[$channel]) && isset($searchArray[$channel]['callback']) ){

            if( is_callable($searchArray[$channel]['callback']) ){
                $data = $searchArray[$channel]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
            }elseif( isset( $searchArray[$searchArray[$channel]['callback']] ) ){
                $data = $searchArray[$searchArray[$channel]['callback']]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
            }

        }

        return response()->json(['data'=>$data,'learn_more'=>['title'=>__t('Learn More'),'link'=>route('admin.page',['page'=>'search','vn4-tab-left-keyword'=>$channel,'q'=>$stringSearchArray[1]??''])]]);
        
	}
];