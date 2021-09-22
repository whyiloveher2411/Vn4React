<?php

add_action('api_save_post_type_ecom_prod',function($post){

    $request = request();

	$input = $request->get('_vn4ecommerce');
	$dataProductDetail = ['title'=>$post->title];

	if( isset($input['product_type']) ){
		$post->product_type = $input['product_type'];
	}

	if( isset($input['general']['price']) ){
		$post->price = $input['general']['price'];
		$post->compare_price = $input['general']['compare_price'];
	}

	$meta = [];

	if( $post->product_type === 'variable' ){

		$price = [];
		$compare_price = [];

		$productDetail = $request->get('ecom_prod_detail');

		if( isset($productDetail['variations']) && !empty( $productDetail['variations'] ) ){

			$list_attribute = [];
			
			if( !is_array($productDetail['variations']) ){
				$productDetail['variations'] = json_decode( $productDetail['variations'], true);
			}

			if( $productDetail['variations'] ){
				
				foreach ( $productDetail['variations'] as $variationKey => $variable) {
					
					if( isset($variable['price']) && $variable['price']*1 ) $price[] = $variable['price']*1;

					if( isset($variable['compare_price']) && $variable['compare_price']*1 ){
						$compare_price[] = $variable['compare_price']*1;
					}else{
						$compare_price[] = $variable['price']*1;
					}
				}
			}

			if( !isset($compare_price[0]) ) $compare_price[] = 0;

			if( isset($price[0]) ){
				$meta['price_max'] = max($price);
				$meta['price_min'] = min($price);

				$meta['compare_price_max'] = max($compare_price);
				$meta['compare_price_min'] = min($compare_price);
			}else{
				$meta['price_max'] = 0;
				$meta['price_min'] = 0;
				$meta['compare_price_max'] = 0;
				$meta['compare_price_min'] = 0;
			}

			$meta['discount'] = number_format( 100 - ( ( $meta['compare_price_max'] + $meta['compare_price_min'] ) * 100 / (($meta['price_max'] + $meta['price_min'] )||1) ) ).'%';
			
		}else{
			$meta['price_max'] = 0;
			$meta['price_min'] = 0;
			$meta['compare_price_max'] = 0;
			$meta['compare_price_min'] = 0;
			$meta['discount'] = '0%';
		}
	}else{

		$meta['price_max'] = $meta['price_min'] = $request->get('price');
		$meta['compare_price_max'] = $meta['compare_price_min'] = $request->get('compare_price');
		
		if( $post->price && $post->compare_price ){
			$meta['discount'] = number_format( 100 - ( $post->compare_price * 100 / $post->price ) ).'%';
		}

	}

	$post->updateMeta('product-detail',$meta);
	$post->save();

	return $post;
});