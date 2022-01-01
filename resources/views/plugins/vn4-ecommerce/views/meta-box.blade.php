<section data-section="#data-info-ecommerce-product">
<?php


$post = Request::get('post');

if( $post ){
	$post = get_post('ecommerce_product',$post);
	$value = $post->getMeta('product-info');
}else{
	$value = null;
}

add_action('vn4_footer',function() use ($plugin) {
	echo '<script src="'.plugin_asset($plugin, 'main.js' ).'"></script>';
});

vn4_tabs_left([
	'chung'=>[
		'title'=>'<i class="fa fa-globe" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Chung',
		'class'=>'product-simple product-grouped product-external ',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Giá bán thường</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[price]" value="{{$value['price']??''}}" class="form-control"></div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Giá khuyến mãi</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[sale_price]" value="{{$value['sale_price']??''}}" class="form-control"></div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Ngày giảm giá</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">
					<input placeholder="Từ... YYYY-MM-DD" type="date" value="{{$value['sale_price_dates_from']??''}}" name="data-product[sale_price_dates_from]" class="form-control" style="margin-bottom: 10px;">
					<input placeholder="Đến... YYYY-MM-DD" type="date" value="{{$value['sale_price_dates_to']??''}}" name="data-product[sale_price_dates_to]" class="form-control">
				</div>
			</div>
			<?php
		}
	],
	'san-pham-ngoai'=>[
		'title'=>'<i class="fa fa-external-link" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Sản phẩm ngoài website',
		'class'=>'product-external',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">URL sản phẩm</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[external][product_url]" value="{{$value['external']['product_url']??''}}" class="form-control"></div>
				<div class="col-sm-12 col-md-4 col-lg-3">
					<p class="note">Nhập URL bên ngoài cho sản phẩm.</p>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Nội dung nút bấm</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[external][button_text]" value="{{$value['external']['button_text']??''}}" class="form-control"></div>
				<div class="col-sm-12 col-md-4 col-lg-3">
					<p class="note">Nội dung này sẽ được hiển thị trên các nút liên kết với các sản phẩm bên ngoài.</p>
				</div>
			</div>
			<?php
		}
	],

	'san-pham-tai-xuong'=>[
		'title'=>'<i class="fa fa-cloud-download" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Tập tin tải xuống',
		'class'=>'product-simple show-when-product-downloadable',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Các tập tin có thể tải xuống</label> 
				<div class="col-md-9">
					<?php 
						echo get_field('repeater',[
							'title'=>'File',
							'key'=>'download_file',
							'name'=>'data-product[download_file]',
							'value'=>$value['download_file']??'',
							'sub_fields'=>[
								'name'=>['title'=>'Name'],
								'file'=>['title'=>'File','view'=>'asset-file'],
							]
						]);
					 ?>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Giới hạn số lần tải xuống</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input placeholder="Không giới hạn" type="number" value="{{$value['download_limit']??''}}" name="data-product[download_limit]" class="form-control"></div>
				<div class="col-sm-12 col-md-4 col-lg-3">
					<p class="note">Để trống nếu không giới hạn việc tải xuống lại.</p>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Giới hạn ngày tải xuống</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input placeholder="Chưa bao giờ" type="number" value="{{$value['download_expiry']??''}}" name="data-product[download_expiry]" class="form-control"></div>
				<div class="col-sm-12 col-md-4 col-lg-3">
					<p class="note">Nhập số ngày trước khi một liên kết tải xuống hết hạn, hoặc để trống.</p>
				</div>
			</div>
			<?php
		}
	],


	'kiem-ke-kho-hang'=>[
		'title'=>'<i class="fa fa-home" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Kiểm kê kho hàng',
		'class'=>'product-simple',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Mã sản phẩm</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[sku]" value="{{$value['sku']??''}}" class="form-control"></div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Số lượng trong kho</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[stock]" value="{{$value['stock']??''}}" class="form-control"></div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Cho phép đặt hàng trước?</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">

					<select class="form-control" name="data-product[backorders]">
						<option @if( isset($value['backorders']) && $value['backorders'] === 'no' ) selected="selected" @endif value="no">Không cho phép</option>
						<option @if( isset($value['backorders']) && $value['backorders'] === 'notify' ) selected="selected" @endif value="notify">Cho phép, nhưng phải thông báo cho khách hàng</option>
						<option @if( isset($value['backorders']) && $value['backorders'] === 'yes' ) selected="selected" @endif  value="yes">Cho phép</option>
					</select>
					<p class="note">Nếu quản lý kho hàng, điều này sẽ kiểm soát việc có cho phép đặt hàng trước cho các sản phẩm đã hết hàng hay không. Nếu được bật, số lượng hàng trong kho có thể để ở giá trị dưới 0.</p>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Ngưỡng sắp hết hàng</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">
					<input type="text" name="data-product[low_stock_amount]" value="{{$value['low_stock_amount']??''}}" class="form-control">
					<p class="note">Khi số hàng còn trong kho đạt đến con số này, bạn sẽ được thông báo qua email</p>
				</div>
			</div>
			<?php
		}
	],
	
	'giao-hang'=>[
		'title'=>'<i class="fa fa-truck" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Giao hàng',
		'class'=>'product-simple product-variable hide-when-product-virtual',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Trọng lượng (kg)</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="text" name="data-product[weight]" value="{{$value['weight']??''}}" class="form-control"></div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Kích thước (cm)</label> 
				<div class="col-md-2"><input type="text" name="data-product[length]" value="{{$value['length']??''}}" class="form-control" placeholder="Dài"></div>
				<div class="col-md-2"><input type="text" name="data-product[width]" value="{{$value['width']??''}}" class="form-control" placeholder="Rộng"></div>
				<div class="col-md-2"><input type="text" name="data-product[height]" value="{{$value['height']??''}}" class="form-control" placeholder="Cao"></div>
			</div>
			<hr>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Lớp giao hàng</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">
					<select class="form-control" name="data-product[product_shipping_class]">
						<option @if( isset($value['product_shipping_class']) && $value['product_shipping_class'] == '-1' ) selected="selected" @endif  value="-1">Không có lớp giao hàng</option>
					</select>
				</div>
			</div>
			<?php
		}
	],
	'nhom-san-pham'=>[
		'title'=>'<i class="fa fa-list" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Nhóm sản phẩm',
		'class'=>'product-grouped',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Nhóm sản phẩm</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">

					<?php 
						echo get_field('relationship_manytomany',[
							'key'=>'product-grouped',
							'name'=>'data-product[product-grouped]',
							'object'=>'ecommerce_product',
							'type_post'=>'ecommerce_product',
							'value'=>$value['product-grouped']??'',
							'where'=>['id','!=',Request::get('post',0)],
						]);

					 ?>

				</div>
			</div>
			<?php
		}
	],
	'cac-san-pham-duoc-ket-noi'=>[
		'title'=>'<i class="fa fa-link" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Các sản phẩm được kết nối',
		'class'=>'product-simple product-grouped product-external product-variable',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Up-Selling</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">

					<?php 
						echo get_field('relationship_manytomany',[
							'key'=>'up-selling',
							'name'=>'data-product[up-selling]',
							'object'=>'ecommerce_product',
							'type_post'=>'ecommerce_product',
							'value'=>$value['up-selling']??'',
							'where'=>['id','!=',Request::get('post',0)],
						]);

					 ?>

				</div>
			</div>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Cross-Selling</label> 
				<div class="col-sm-12 col-md-8 col-lg-6">

					<?php 
						echo get_field('relationship_manytomany',[
							'key'=>'cross-selling',
							'name'=>'data-product[cross-selling]',
							'object'=>'ecommerce_product',
							'type_post'=>'ecommerce_product',
							'value'=>$value['cross-selling']??'',
							'where'=>['id','!=',Request::get('post',0)],
						]);
					 ?>

				</div>
			</div>
			<?php
		}
	],
	'cac-thuoc-tinh'=>[
		'title'=>'<i class="fa fa-share-alt" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Các thuộc tính',
		'class'=>'product-simple product-grouped product-external product-variable',
		'content'=>function() use ($__env, $plugin, $value){
				$ecommerce_product_attribute = get_posts('ecommerce_product_attribute',100);
				$controller = include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/controllers/meta-box.php');

			?>

			<div class="row">
				<label class="col-sm-12 col-md-8 col-lg-6">
					<select class="form-control" id="selectAttribute" >
						@foreach($ecommerce_product_attribute as $a)
							<option value="{!!$a->id!!}">{!!$a->title!!}</option>
						@endforeach
					</select>
				</label> 
				<div class="col-sm-12 col-md-4 col-lg-3"> <span class="vn4-btn add_selectAttribute" data-url="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word, 'controller'=>'meta-box', 'method'=>'add-attribute'])!!}" style="line-height: 32px;height: 32px;">Thêm</span> </div>
			</div>

			<div id="ecommerce_product_attribute-content" class='list-attribute' style="padding: 0;">

				@if( isset($value['ecommerce_product_attribute']) )
				@foreach( $value['ecommerce_product_attribute'] as $attribute)
					<?php 
						$controller['add-attribute']($attribute);
					 ?>
				@endforeach
				@endif

			</div>
			<?php
		}
	],
	'cac-bien-the'=>[
		'title'=>'<i class="fa fa-table" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Các biến thể',
		'class'=>'product-variable',
		'content'=>function() use ($__env, $plugin, $value, $post){

			?>
				<div id="variable_product">Trước khi bạn có thể thêm sản phẩm biến thể, bạn cần phải thêm một số thuộc tính của sản phẩm này trên thẻ Thuộc tính. <br> 
					<span class="vn4-btn load_all_variable_product" data-url="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'meta-box','method'=>'load-variable-template'])!!}">Load Tempate Variable Product</span> 
					<span class="vn4-btn load_all_variable_product create_all_variable" data-url="{!!route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'meta-box','method'=>'load-variable-template'])!!}">Create all variable from attributes</span>
					<div id="warper-variable" style="margin:20px 0;">
						<?php 

							if( isset($value['ecommerce_product_attribute']) ){


								echo '<div class="load-variable-save" data-url="'.route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'meta-box','method'=>'load-variable-save','post'=>$post->id]).'"></div>';


								// $list_attribute_save = ['value'=> $value['variable']??'', 'attributes'=> [] ];

								// foreach ($value['ecommerce_product_attribute'] as $v) {
								// 	$list_attribute_save['attributes'][] = [
								// 		'id'=>$v['id'],
								// 		'variable'=>$v['attribute_value'],
								// 	];
								// }

								// $controller = include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/controller/meta-box.php');

								// echo $controller['load-variable-template']( $list_attribute_save );

							}
						 ?>
					</div>
				</div>

			<?php
		}
	],
	'nang-cao'=>[
		'title'=>'<i class="fa fa-cogs" aria-hidden="true" style="font-size: 19px;margin-right: 5px;"></i> Nâng cao',
		'class'=>'product-simple product-grouped product-external product-variable',
		'content'=>function() use ($value) {
			?>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Ghi chú thanh toán</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><textarea name="data-product[purchase_note]" class="form-control" rows="3">{!!$value['purchase_note']??''!!}</textarea></div>
			</div>
			<hr>
			<div class="row">
				<label class="col-sm-12 col-md-4 col-lg-3">Cho phép đánh giá</label> 
				<div class="col-sm-12 col-md-8 col-lg-6"><input type="checkbox" @if( isset($value['comment_status']) && $value['comment_status'] === 'open' ) checked="checked" @endif  name="data-product[comment_status]" value="open"></div>
			</div>
			<?php
		}
	],

]);
?>
</section>
<section data-section="body">
<?php

do_action('vn4_footer');

?>
</section>

