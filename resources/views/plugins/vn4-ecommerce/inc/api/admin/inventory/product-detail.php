<?php

if( !$r->has('setQuantity') ){

    $product = get_post('ecom_prod', $r->get('id'));

    if( $product ){

        $productDetail = get_post('ecom_prod_detail', $product->id);
        
        $productsResult = [];

        // if( $productDetail->variations ) $productDetail->variations = json_decode( $productDetail->variations, true ) ?? [];

        if( $product->product_type === Vn4Ecom\Product\Model\Product::$productType['SIMPLE'] ){

            $productsResult[] = [
                'key'=>$product->id,
                'identifier'=>[
                    'id'=>$product->id
                ],
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

            foreach( $variations as $key => $variation ){

                if(!$variation['delete']){
                    $productsResult[] = [
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
        }
        
        return [
            'products'=>$productsResult
        ];

    }


}

$identifier = $r->get('identifier');

$product = get_post( 'ecom_prod', $identifier['id'] );

if( $product ){

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
}

return [
    'message'=>apiMessage('No products were found','error')
];
