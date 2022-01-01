<?php

$id = $r->get('id');

$variable = \Vn4Ecom\Product\Model\Product::getProductVariations($id);

if( $variable === false ){
    return [
        'message'=>apiMessage('This product was not found','error')
    ];
}

return [
    'items'=>$variable
];