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
		$post->sale_price = $input['general']['sale_price'];
	}

	$meta = [];

	if( $post->product_type === 'variable' ){

		$price = [];
		$sale_price = [];

		$productDetail = $request->get('ecom_prod_detail');

		if( isset($productDetail['variations']) && !empty( $productDetail['variations'] ) ){

			$list_attribute = [];
			
			if( !is_array($productDetail['variations']) ){
				$productDetail['variations'] = json_decode( $productDetail['variations'], true);
			}

			if( $productDetail['variations'] ){
				
				foreach ( $productDetail['variations'] as $variationKey => $variable) {

					if( $variable['price']*1 ) $price[] = $variable['price']*1;

					if( $variable['sale_price']*1 ){
						$sale_price[] = $variable['sale_price']*1;
					}else{
						$sale_price[] = $variable['price']*1;
					}
				}
			}

			if( !isset($sale_price[0]) ) $sale_price[] = 0;

			if( isset($price[0]) ){
				$meta['price_max'] = max($price);
				$meta['price_min'] = min($price);

				$meta['sale_price_max'] = max($sale_price);
				$meta['sale_price_min'] = min($sale_price);
			}else{
				$meta['price_max'] = 0;
				$meta['price_min'] = 0;
				$meta['sale_price_max'] = 0;
				$meta['sale_price_min'] = 0;
			}

			$meta['discount'] = number_format( 100 - ( ( $meta['sale_price_max'] + $meta['sale_price_min'] ) * 100 / (($meta['price_max'] + $meta['price_min'] )||1) ) ).'%';
			
		}else{
			$meta['price_max'] = 0;
			$meta['price_min'] = 0;
			$meta['sale_price_max'] = 0;
			$meta['sale_price_min'] = 0;
			$meta['discount'] = '0%';
		}
	}else{

		$meta['price_max'] = $meta['price_min'] = $request->get('price');
		$meta['sale_price_max'] = $meta['sale_price_min'] = $request->get('sale_price');
		
		if( $post->price && $post->sale_price ){
			$meta['discount'] = number_format( 100 - ( $post->sale_price * 100 / $post->price ) ).'%';
		}

	}

	$post->updateMeta('product-detail',$meta);
	$post->save();

	return $post;

	// $data_product = $r->get('data-product');

	if( $input ){ 

		$names = [];

		//update title of attribute and attribute value
		if( isset($data_product['ecommerce_product_attribute']) && !empty($data_product['ecommerce_product_attribute']) ){

			foreach ($data_product['ecommerce_product_attribute'] as $k => $value) {

				$attribute = get_post('ecommerce_product_attribute',$value['id']);	

				$list_attribute_values = get_posts('ecommerce_product_attribute_value',['count'=>100,'select'=>[Vn4Model::$id,'title'],'callback'=>function($q) use ($value) {
					$q->whereIn(Vn4Model::$id, $value['attribute_value']);
				}])->pluck('title','id');

				$data_product['ecommerce_product_attribute'][$k]['title'] = $attribute->title;
				$data_product['ecommerce_product_attribute'][$k]['template'] = $attribute->template;

				foreach ( $value['attribute_value'] as $id) {

					if( isset($list_attribute_values[$id]) ){
						$data_product['ecommerce_product_attribute'][$k]['attribute_detail'][$id] = $list_attribute_values[$id];
					}
				}
			}
		}

		//update info of attribute for variable
		if( !empty($data_product['variable']) ){

			foreach ($data_product['variable'] as $key => $value) {

				$name = [];
				$nameID = [];

				foreach ($data_product['ecommerce_product_attribute'] as $attribute_id => $attribute_value_id) {

					$attribute = get_post('ecommerce_product_attribute',$attribute_id);	
					$attribute_value = get_post('ecommerce_product_attribute_value',$value['attribute_'.$attribute_id]);


					$data_product['variable'][$key]['attribute'][$attribute_id] = [
						'attribute_title'=>$attribute->title,
						'attribute_value_id'=>$attribute_value->id,
						'attribute_value_title'=>$attribute_value->title,
					];

					$name[] = $attribute_value->title;
					$nameID[] = $attribute_value->id;

				}

				$name = implode(',',$name);


				if( !isset($names[$name]) ){
					$names[$name] = $key;
					$data_product['variable'][$key]['name'] = $name;
					$data_product['variable'][$key]['nameID'] = implode(',',$nameID);
				}else{
					unset($data_product['variable'][$key]);
				}
			}
		}

		// dd($data_product);
		if( $category = get_post('ecommerce_category',$post->ecommerce_category) ){
			$list_category = [ ['id'=>$category->id, 'title'=>$category->title, 'slug'=>$category->slug, 'type'=>'ecommerce_category' ] ];

			while ( $category && $category->parent ) {
				$category = get_post('ecommerce_category',$category->parent);

				if( $category ){
					array_unshift($list_category,[
						'id'=>$category->id,
						'title'=>$category->title,
						'slug'=>$category->slug,
						'type'=>'ecommerce_category',
					]);
				}
			}

		}else{
			$list_category = [];
		}
		

		if( $data_product['product-type'] === 'variable' ){

			$price = [];
			$sale_price = [];

			if( isset($data_product['variable'][0]) ){

				$list_attribute = [];

				foreach ($data_product['variable'] as $variable) {
					if( $variable['price']*1 ) $price[] = $variable['price']*1;

					if( $variable['sale_price']*1 ){
						$sale_price[] = $variable['sale_price']*1;
					}else{
						$sale_price[] = $variable['price']*1;
					}
				}

				if( !isset($sale_price[0]) ) $sale_price[] = 0;

				if( isset($price[0]) ){
					$data_product['price_max'] = max($price);
					$data_product['price_min'] = min($price);

					$data_product['sale_price_max'] = max($sale_price);
					$data_product['sale_price_min'] = min($sale_price);
				}else{
					$data_product['price_max'] = 0;
					$data_product['price_min'] = 0;
					$data_product['sale_price_max'] = 0;
					$data_product['sale_price_min'] = 0;
				}

				$data_product['discount'] = number_format( 100 - ( ( $data_product['sale_price_max'] + $data_product['sale_price_min'] ) * 100 / (($data_product['price_max'] + $data_product['price_min'] )||1) ) ).'%';

			}else{
				$data_product['price_max'] = 0;
				$data_product['price_min'] = 0;
				$data_product['sale_price_max'] = 0;
				$data_product['sale_price_min'] = 0;
				$data_product['discount'] = '0%';
			}

		}else{

			$data_product['price_max'] = $data_product['price'];
			$data_product['price_min'] = $data_product['price'];

			$data_product['sale_price_max'] = $data_product['sale_price'];
			$data_product['sale_price_min'] = $data_product['sale_price'];
			
			$post->price = $data_product['price'];
			$post->sale_price = $data_product['sale_price'];

			if( $post->price && $post->sale_price ){
				$data_product['discount'] = number_format( 100 - ( $post->sale_price * 100 / $post->price ) ).'%';
			}

		}

		

		$post->product_type = $data_product['product-type'];
		$data_product['categories'] = $list_category;

		$post->updateMeta('product-info',$data_product);
		$post->save();
	}
	return $post;

});