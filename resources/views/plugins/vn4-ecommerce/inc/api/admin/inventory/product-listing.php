<?php

if( !$r->has('setQuantity') ){

    $config = get_admin_object('ecom_prod');
    
    $rowsPerPage = $r->get('per_page')??10;

    $page = $r->get('page')??0;
    
    Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
        return $page;
    });

    $products = DB::table($config['table'])->where('type','ecom_prod')->orderBy('id','desc')->paginate($rowsPerPage);

    $productsResult = [];

    foreach($products as $product ){

        $productDetail = get_post('ecom_prod_detail', $product->id);

        // if( $productDetail->variations ) $productDetail->variations = json_decode( $productDetail->variations, true ) ?? [];

        if( $product->product_type === Vn4Ecom\Product\Model\Product::$productType['SIMPLE'] ){

            $productsResult[] = [
                'key'=>$product->id,
                'identifier'=>[
                    'id'=>$product->id
                ],
                'product_type'=>$product->product_type,
                'title'=>$product->title,
                'variationLabel'=>false,
                'sku'=>$productDetail->warehouse_sku,
                'when_sold_out'=>$productDetail->warehouse_pre_order_allowed??'no',
                'warehouse_quantity'=>$productDetail->warehouse_quantity,
                'thumbnail'=>$product->thumbnail,
                'warehouse_manage_stock'=>$productDetail->warehouse_manage_stock??0,
                'stock_status'=>$productDetail->stock_status??false,
            ];

        }elseif( $product->product_type === Vn4Ecom\Product\Model\Product::$productType['VARIABLE'] ){

            $variations = json_decode( $productDetail->variations, true ) ?? [];

            $productVariable = [
                'key'=>$product->id,
                'title'=>$product->title,
                'identifier'=>[
                    'id'=>$product->id,
                ],
                'product_type'=>$product->product_type,
                'thumbnail'=>$product->thumbnail,
                'variables'=>[]
            ];
            
            foreach( $variations as $key => $variation ){

                if(!$variation['delete']){
                    $productVariable['variables'][] = [
                        'key'=>$product->id.'#'.$key,
                        'title'=>$variation['title'],
                        'identifier'=>[
                            'id'=>$product->id,
                            'variationKey'=>$key,
                        ],
                        'variationLabel'=>$variation['label'],
                        'sku'=>$variation['sku'],
                        'when_sold_out'=>$variation['warehouse_pre_order_allowed']??'no',
                        'warehouse_manage_stock'=>$variation['warehouse_manage_stock']??0,
                        'warehouse_quantity'=>$variation['warehouse_quantity']??0,
                        'stock_status'=>$variation['stock_status']??null,
                        'thumbnail'=>$variation['images']??null,
                    ];
                }
            }

            $productsResult[] = $productVariable;
        }
    }

    return [
        'products'=>$productsResult,
        'paginate'=>$products,
    ];

}

$identifier = $r->get('identifier');

$product = get_post( 'ecom_prod', $identifier['id'] );

$productDetail = get_post('ecom_prod_detail', $product->id);

if( isset($identifier['variationKey']) ){


    $variations = json_decode( $productDetail->variations, true ) ?? [];

    if( $r->get('setType') === 'add' ){
        $variations[$identifier['variationKey']]['warehouse_quantity'] += intval( $r->get('count') );
    }else{
        $variations[$identifier['variationKey']]['warehouse_quantity'] = intval( $r->get('count') );
    }

    $productDetail->variations = json_encode( $variations );

    $productDetail->save();

    $productService = new \Vn4Ecom\Product\Model\Product( $product );

    $productService->setVariations( $variations );
    
    $productService->standardized();

    $product->save();

    return [
        'message'=>apiMessage('save successfully'),
        'warehouse_quantity'=>$variations[$identifier['variationKey']]['warehouse_quantity'],
    ];

}else{

    if( $r->get('setType') === 'add' ){
        $productDetail->warehouse_quantity += intval( $r->get('count') );
    }else{
        $productDetail->warehouse_quantity = intval( $r->get('count') );
    }

    $productDetail->save();
    
    $productService = new \Vn4Ecom\Product\Model\Product( $product );

    $productService->setRequsetProductDetail($productDetail);
    
    $productService->standardized();

    $product->save();

    return [
        'message'=>apiMessage('save successfully'),
        'warehouse_quantity'=>$productDetail->warehouse_quantity,
    ];
}