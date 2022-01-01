<?php


//Get product detail from product
function get_product_detail( &$post ){
	if( !$post->__product_detail ){
		$post->__product_detail = $post->relationship('ecom_prod_detail');
	}
	return $post->__product_detail;
}


function ecommerce_show_specifications($post) {

	$product_detail = get_product_detail($post);

	$properties_attributes = json_decode($product_detail->properties_attributes, true);
	$properties_attributes_values = json_decode($product_detail->properties_attributes_values, true);

	if( $properties_attributes ){

		$admin_object = get_admin_object('ecom_prod_attr');

		$argListId = [];
	
		foreach( $properties_attributes as $index => $value ){
			$argListId[$value['id']] = $index;
		}
		
		// $sortValues = array();
		// foreach ($product_detail->properties_attributes_values as $key => $row)
		// {
		// 	$sortValues[$key] = $row['id'];
		// }

		// array_multisort($sortValues, SORT_ASC, $product_detail->properties_attributes_values);
		foreach( $properties_attributes_values as $value ){

			if( !isset($argListId[$value['ecom_prod_attr']]) ) continue;

			if( !isset( $properties_attributes[ $argListId[$value['ecom_prod_attr']] ]['values'] ) ){
				$properties_attributes[ $argListId[$value['ecom_prod_attr']] ]['values'] = [];
			}
			$properties_attributes[ $argListId[$value['ecom_prod_attr']] ]['values'][] = $value;
		}
		
		$product_detail->properties_attributes = $properties_attributes;
		$product_detail->properties_attributes_values = $properties_attributes_values;


	?>
	<div class="product_attribute">
		<?php 
			foreach(  $product_detail->properties_attributes as $attribute ){
				// if( view()->exits() ){

				// }else{

				// }

				echo vn4_view( $admin_object['template'].'._default', ['data'=>$attribute]);
			}
		 ?>
    </div>
	<?php
	}
}

//get review from product
function ecommerce_get_reviews($product, $param = []){

	$callback = function($q) use ($param) {
		$q->where('review_status','approved');

		if( isset($param['callback']) ){
			$param['callback']($q);
		}
	};

	$param['callback'] = $callback;

	return $product->related('ecom_prod_review', 'ecom_prod' , $param );

}

//select default of category
function __ecommerce_get_attr_cate($selects = null){
	if( !$selects ){
		$selects = ['id','title','slug','type'];
	}else{
		$selects = array_merge(['id','title','slug','type'], $selects);
	}

	return $selects;
}

//get categorires struct of product
function ecommerce_categories_breadcrumbs($product, $selects = null){

	$selects = __ecommerce_get_attr_cate($selects);

	$selects = array_map( function($item){
		return 'parent.'.$item.' as '.$item;
	}, $selects);
	
	$result = DB::select(DB::raw(
        'SELECT '.join(', ',$selects).'
        FROM ecom_prod_cate AS node,
            ecom_prod_cate AS parent
        WHERE node.parent_lft BETWEEN parent.parent_lft AND parent.parent_rgt
                AND node.id = '.$product->ecom_prod_cate.'
        ORDER BY parent.parent_lft;
        '
    ));
	
	foreach($result as $key => $item ){
		$result[$key] = (array) $result[$key];
		$result[$key]['link'] = get_permalinks($item);
	}

	return (array) $result;
}

//get variations
function ecommerce_get_variations($product){
	$productDetail = get_product_detail($product);
	return $productDetail->variations;
}

//get categories struct
function ecommerce_categories($parent = null){

	function __createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k=>$l){
			if( isset($l['id']) ){
				if(isset($list[$l['id']]) ) {
					$l['children'] = __createTree($list, $list[$l['id']]);
				}
			}
			$tree[] = $l;
		} 
		return $tree;
	}

	$selects = __ecommerce_get_attr_cate(['parent']);

	$selects = array_map( function($item){
		return 'node.'.$item.' as '.$item;
	}, $selects);
	
	$result = DB::select(DB::raw(
		'SELECT CONCAT( REPEAT( " ", (COUNT(parent.title) - 1) ), node.title) AS title2, '.join(', ',$selects).'
		FROM ecom_prod_cate AS node,
			ecom_prod_cate AS parent
		WHERE node.parent_lft BETWEEN parent.parent_lft AND parent.parent_rgt '
		. ( $parent ? ( gettype($parent) === 'array' 
			? ' AND node.parent in ('.join(',',$parent).') ' 
			: ' AND node.parent = '.$parent.' ' ): '' ).
		'GROUP BY node.id
		ORDER BY node.parent_lft;'
	));
	
	foreach($result as $key => $item ){
		$result[$key] = (array) $result[$key];
		$result[$key]['link'] = get_permalinks($item);
	}

	$new = [];

	foreach ($result as $a){
		$new[$a['parent']][] = $a;
	}
	
	if( $parent ){
		
		$result = [];

		if( gettype($parent) === 'array' ){

			foreach($parent as $id){
				if( isset($new[$id]) ){
					$result[$id] = $new[$id];
				}
			}
			

		}else{
			foreach($new as $n){
				$result = array_merge( $result, $n);
			}
		}

	}else{
		
		$result = __createTree($new, array_filter($result, function($item){
			if( !$item['parent'] ){
				return true;
			}
			return false;
		}));
	}

	return $result;

}

function ecommerce_get_category_parent($category){
	return get_posts( 'ecom_prod_cate' ,['order'=>['parent_lft','asc'], 'callback'=> function($q) use ($category){
		$q->whereRaw('id in (
			SELECT parent.id
			FROM ecom_prod_cate AS node,
				ecom_prod_cate AS parent
			WHERE node.parent_lft BETWEEN parent.parent_lft AND parent.parent_rgt
					AND node.id = '.$category->id.'
			ORDER BY parent.parent_lft
		)');
	}]);
}

function ecommerce_the_form_quantity(){
	?>
	<div class="vn4cms-input-quantity">
		<button class="btn-down">
			<svg class="vn4cms-svg-icon " enable-background="new 0 0 10 10" viewBox="0 0 10 10" x="0" y="0"><polygon points="4.5 4.5 3.5 4.5 0 4.5 0 5.5 3.5 5.5 4.5 5.5 10 5.5 10 4.5"></polygon></svg>
		</button>
		<input class="input-quantity" type="text" value="1">
		<button class="btn-up">
			<svg class="vn4cms-svg-icon icon-plus-sign" enable-background="new 0 0 10 10" viewBox="0 0 10 10" x="0" y="0"><polygon points="10 4.5 5.5 4.5 5.5 0 4.5 0 4.5 4.5 0 4.5 0 5.5 4.5 5.5 4.5 10 5.5 10 5.5 5.5 10 5.5"></polygon></svg>.
		</button>
		<p class="info-stock"></p>
	</div>
	<?php
}

function ecommerce_render_data_javascript($post){

	$plugin = plugin('vn4-ecommerce');

	echo view_plugin($plugin, 'views.frontend.render_data_javascript', [
		'post'=>$post
	]);

	return;
}


function __ecommerce_get_meta_product(&$post){

	if( !$post->_metaProduct ){
		$post->_metaProduct = $post->getMeta('product-detail');
	}

	return $post->_metaProduct;

}
function ecommerce_the_price($post){
	return [
		'price'=>ecommerce_price($post->price),
		'compare_price'=>ecommerce_price($post->compare_price),
	];
}

function ecommerce_get_product($category){

	$result = get_posts('ecom_prod',['callback'=>function($q) use ($category) {
		$q->whereRaw('ecom_prod_cate in (SELECT node.id as id
		FROM ecom_prod_cate AS node,
			ecom_prod_cate AS parent
		WHERE node.parent_lft BETWEEN parent.parent_lft AND parent.parent_rgt
				AND parent.id = '.$category->id.'
		ORDER BY node.parent_lft)');
	}, 'count'=> 9, 'paginate'=>'page']);

	return $result;
}

function ecommerce_get_product_up_selling($product){
	$productDetail = get_product_detail($product);
	return $productDetail->relationship('connected_products_up_selling');
}

function ecommerce_get_product_cross_selling($product){
	$productDetail = get_product_detail($product);
	return $productDetail->relationship('connected_products_cross_selling');
}

function ecommerce_get_product_related($product, $param = []){
	return get_posts('ecom_prod',array_merge(['count'=>9,'callback'=>function($q) use ($product) {
		$q->where('ecom_prod_cate',$product->ecom_prod_cate)->where('id','!=',$product->id);
	}], $param ));
}


function ecommerce_get_specifications( $product ){


	$specifications_sets = $product->relationship('ecom_prod_spec_sets');
	$idSpecificationsSets = $product->ecom_prod_spec_sets;
	$productDetail = get_product_detail( $product );
	
    if( $specifications_sets ){
        $specifications_sets = json_decode($specifications_sets->specifications,true);
    }else{
        $specifications_sets = [];
    }
    $specifications_sets_value = json_decode($productDetail->specifications_values,true);
	
	$result = [];

	foreach( $specifications_sets as $group ){
		if( !isset($group['delete']) || !$group['delete'] ){

			$temp = [
				'title'=>$group['title'],
				'values'=>[]
			];

			foreach( $group['attributes'] as $attribute ){
				if( !isset($attribute['delete']) || !$attribute['delete'] ){

					if( isset( $specifications_sets_value[$idSpecificationsSets.'_'.$group['title'].'_'.$attribute['title']] ) ){
						$temp['values'][] = [
							'title'=>$attribute['title'],
							'value'=>$specifications_sets_value[$idSpecificationsSets.'_'.$group['title'].'_'.$attribute['title']],
						];
					}else{
						$temp['values'][] = [
							'title'=>$attribute['title'],
							'value'=>'',
						];
					}

				}
			}

			$result[] = $temp;

		}
	}

	return $result;
}