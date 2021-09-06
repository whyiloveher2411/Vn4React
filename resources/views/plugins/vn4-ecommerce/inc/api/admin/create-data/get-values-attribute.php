<?php

$input = $r->all();

if( isset($input['ids'][0]) ){ 

    $values = get_posts( 'ecom_prod_attr_value' , ['select'=>['id','title', 'ecom_prod_attr'], 'orderBy'=>['id','asc'], 'count'=>1000, 'callback'=>function($q) use ($input) {
        $q->whereIn('ecom_prod_attr',$input['ids'])->orderBy('id','asc');
    }])->groupBy('ecom_prod_attr');

    $groupAttribute = get_posts('ecom_prod_attr', ['select'=>['id','title'], 'count'=>1000, 'callback'=>function($q) use ($input) {
        $q->whereIn('id', $input['ids']);
    }])->groupBy('id');

    $result = [];


    foreach($values as $key => $v){
        $result['id_'.$key] = $groupAttribute[$key][0];
        $result['id_'.$key]['values'] = $v;
    }

    return [
        'attributes'=>$result
    ];

}

return [
    'attributes'=>[]
];
