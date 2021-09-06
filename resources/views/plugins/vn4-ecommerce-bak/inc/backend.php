<?php
add_sidebar_admin(function() use ($plugin) {


	$sidebar['vn4-ecommerce-orders'] = [
		'title'=>'Orders',
		'icon'=>'fa-usd',
		'url'=>'#'
	];

	$sidebar['vn4-ecommerce-products'] = [
		'title'=>'Products',
		'icon'=>'fa-shopping-cart',
		'submenu'=>[
			['title'=>'Products','url'=>route('admin.show_data','ecommerce_product')],
			['title'=>'Category','url'=>route('admin.show_data','ecommerce_category')],
			['title'=>'Tag','url'=>route('admin.show_data','ecommerce_tag')],
			['title'=>'Attributes','url'=>route('admin.show_data','ecommerce_product_attribute')],
			['title'=>'Filters','url'=>route('admin.show_data','ecommerce_filter')],
			// ['title'=>'Product Variable','url'=>route('admin.show_data','ecommerce_product_variable')],
		],
	];

	$sidebar['vn4-ecommerce-customers'] = [
		'title'=>'Customers',
		'icon'=>'fa-users',
		'url'=>route('admin.show_data','ecommerce_customer')
	];

	$sidebar['vn4-ecommerce-marketing'] = [
		'title'=>'Marketing',
		'icon'=>'fa-bell',
		'submenu'=>[
			['title'=>'Promotions','url'=>route('admin.show_data','ecommerce_promotion')],
			['title'=>'Reviews','url'=>route('admin.show_data','ecommerce_review')],
		]
	];

	$sidebar['vn4-ecommerce-reports'] = [
		'title'=>'Reports',
		'icon'=>'fa-line-chart',
		'url'=>'#'
	];

	return $sidebar;
	
});



add_meta_box(
	'plugin-vn4-ecommerce',
	function($customePostConfig, $post) use ($plugin) {


		if($post){
			$value = $post->getMeta('product-info');
		}

		$product_type = $value['product-type']??'simple';
		$virtual = $value['product-simple']['virtual']??'off';
		$downloadable = $value['product-simple']['downloadable']??'off';

		return '<meta id="ecommerce_controller_url" content="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'meta-box', 'method'=>'']).'">Dữ liệu sản phẩm <label style="padding-right:10px;border-right:1px solid #dedede;margin-right:10px;"><select class="form-control select_product_type" name="data-product[product-type]"><option '.($product_type === 'simple'?'selected="selected"':'').' value="simple">Sản phẩm đơn giản</option><option '.($product_type === 'grouped'?'selected="selected"':'').' value="grouped">Sản phẩm nhóm</option><option '.($product_type === 'external'?'selected="selected"':'').' value="external">Sản phẩm liên kết ngoài</option><option '.($product_type === 'variable'?'selected="selected"':'').' value="variable">Sản phẩm có biến thể</option></select></label><label style="padding-right:10px;border-right:1px solid #dedede;margin-right:10px;" class="checked_product_virtual1"><input type="checkbox" '.($virtual === 'on'?'checked="checked"':'').' name="data-product[product-simple][virtual]" class="onoff_input" data-input="product-virtual" value="on" > Sản phẩm ảo</label><label class="checked_product_downloadable1"><input type="checkbox" '.($downloadable === 'on'?'checked="checked"':'').' name="data-product[product-simple][downloadable]" class="onoff_input" data-input="product-downloadable" value="on" > Có thể tải xuống</label>';
	},
	'ecommerce_product',
	'left',
	'aplugin-vn4-ecommerce' ,
	function($customePostConfig, $post) use ($plugin){


		use_module('many_record');

		echo '<div id="data-info-ecommerce-product" data-url="'.route('admin.plugin.controller',array_merge(Request::all(),['plugin'=>$plugin->key_word,'controller'=>'meta-box','method'=>'get'])).'">Loading..</div>';
		add_action('vn4_footer',function() use ($plugin) {
			echo '<script src="'.plugin_asset($plugin, 'main.js' ).'"></script>';
		});

	}, 
	function($post, $r){

		$data_product = $r->get('data-product');

		if( array_key_exists('price', $data_product) ){ 

			if( $specifications = $r->get('specifications') ){
				$post->detailed_specifications = json_encode($specifications);
			}

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
	}
);

