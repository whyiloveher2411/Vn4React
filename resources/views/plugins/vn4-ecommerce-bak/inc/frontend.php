<?php

function ecommerce_show_attribute($meta) {
	$admin_object = get_admin_object('ecommerce_product_attribute');
	if( isset($meta['ecommerce_product_attribute']) ){
	?>
	<div class="product_attribute">
		<?php 
			foreach(  $meta['ecommerce_product_attribute'] as $attribute ){
				if( isset($attribute['template']) ){
					echo vn4_view( $admin_object['template'].'.'.$attribute['template'], ['data'=>$attribute] );
				}else{
					echo vn4_view( $admin_object['template'].'._default', ['data'=>$attribute]);
				}
			}
		 ?>
    </div>
	<?php
	}
}

function ecommerce_reviews($product, $param = []){

	$callback = function($q) use ($param) {
		$q->where('review_status','approved');

		if( isset($param['callback']) ){
			$param['callback']($q);
		}
	};

	$param['callback'] = $callback;

	return $product->related('ecommerce_review', 'ecommerce_product' , $param );

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

function ecommerce_the_price($meta){

	if( isset($meta['price_min']) && isset($meta['sale_price_min']) ){

		if( $meta['price_min'] === $meta['price_max'] ) $price = ecommerce_price($meta['price_min']);
		else $price = ecommerce_price($meta['price_min']).' - '.ecommerce_price($meta['price_max']);

		if( $meta['sale_price_min'] === $meta['sale_price_max'] ) $sale_price = ecommerce_price($meta['sale_price_min']);
		else $sale_price = ecommerce_price($meta['sale_price_min']).' - '.ecommerce_price($meta['sale_price_max']);

		return [
			'price'=>$price,
			'sale_price'=>$sale_price,
		];

	}
}