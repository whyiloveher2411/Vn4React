<?php

if( !function_exists('load_variable_template') ){
	function load_variable_template($r){

		$id = Vn4Model::$id;

		if( isset($r['attributes']) ){
			$variable_product = $r['attributes'];
			$value_repeater = $r['value'];
		}else{
			$variable_product = $r->get('variable_product');
			$value_repeater = '';
		}

		$sub_fields = [];

		$sub_fields_variable = [];

		if( is_array($variable_product) ){

			$terms = false;

			//Load các biến thể
			foreach ($variable_product as $value) {

				if( isset($value['variable']) ){

					$terms = true;
				
					$attribute = get_post('ecommerce_product_attribute',$value['id']);



					$valueOfAttribute = get_posts('ecommerce_product_attribute_value',['select'=>[$id,'title'],'count'=>count($value['variable']),'callback'=>function($q) use ($id, $value, $attribute) {
						$q->where('ecommerce_product_attribute',$attribute->id)->whereIn($id, $value['variable']);
					}])->pluck('title',$id);

					$sub_fields['attribute_'.$attribute->id] = [
						'title'=>$attribute->title,
						// 'name'=>'data-product[variable]',
						// 'key'=>'variable',
						'data'=>'data-sku="'.$attribute->sku_code.'"',
						'view'=>'select',
						'class'=>'variable_value',
						'list_option'=>$valueOfAttribute,
					];

					$sub_fields_variable[] = 'attribute_'.$attribute->id;

				}
				// foreach ($valueOfAttribute as $key => $value) {
					# code...
				// }
				
			}


			//Nếu có biến thể
			if( $terms ){

				$admin_object = get_admin_object('ecommerce_product_variable');

				$sub_fields =  array_merge($sub_fields, $admin_object['fields']);
				unset($sub_fields['ecommerce_product']);
				unset($sub_fields['attribute_value']);
				
				$argTemplateColumn = $admin_object['layout_custom'];

				//Cấu trúc của form nhập biến thể
				function show_template( $row, $fields, $config, $dep ){

					$result = '';


					foreach ($row as $columns) {
						$result .= '<div class="row" '.($dep == 1 ? 'style="margin-top:25px;"' : '' ).'>';

						foreach ($columns as $column) {
							$result .= '<div style="margin-bottom:15px;" class="'.$column[0].'">';

							if( is_string($column[1]) ){
								$result .= '<label>'.$config[$column[1]]['title'].'&nbsp;&nbsp;&nbsp;</label>'.$fields[$column[1]];
							}else{
								$result .= show_template([$column[1]], $fields, $config, $dep + 1);
							}

							$result .= '</div>';
						}
						$result .= '</div>';
					}


					return $result;


				}

				$field = get_field('repeater',[
					'title'=>'Variable',
					'view'=>'repeater',
					'key'=>'variable',
					'name'=>'data-product[variable]',
					'layout'=>'custom',
					'custom'=>function($fields) use ($sub_fields_variable, $sub_fields, $argTemplateColumn) {

						$result = '<div class="choose_attribute_value" style="margin: -10px;padding: 10px;background: #F2F0F0;">';

						foreach ($sub_fields_variable as $key) {
							$result .= '<label style="margin-right:10px;"> '.$sub_fields[$key]['title'].$fields[$key].'</label> ';
		        			unset($fields[$key]);
						}

						$result .= '</div><hr style="margin: 10px -10px;">'.show_template($argTemplateColumn, $fields, $sub_fields, 1 );

		        		return $result;
					},
					'value'=>$value_repeater,
					'sub_fields'=>$sub_fields,

				]);


				// if( $value_repeater ){
				// 	return $field;
				// }

				echo '<section data-section="body">';
				do_action('vn4_footer');
				echo '</section>';

				return '<section data-section="#warper-variable">'.$field.'</section>';

			}
			return ['message'=>['content'=>'Please Add Attribute Value before add variable!','title'=>'Error','icon'=>'fa-times','color'=>'#CA2121']];
		}


		return ['message'=>['content'=>'Please set attribute of product','title'=>'Error','icon'=>'fa-times','color'=>'#CA2121']];
	}
}
return [
	
	// Get Meta box
	'get'=>function($r, $plugin ){

		return view_plugin($plugin, 'views.meta-box');

	},

	// Add Attribute to product
	'add-attribute'=>function( $r ) use ($plugin)  {

		$ecommerce_product_attribute = get_post('ecommerce_product_attribute',$r['id']??$r->get('value'));

		$view = 'plugins.'.$plugin->key_word.'.views.backend.meta-box-attributes';

		if( view()->exists($temp = 'themes.'.theme_name().'.'.$plugin->key_word.'.backend.attributes.'.$ecommerce_product_attribute->slug) ){
			$view = $temp;
		}

		$inputAttribute = get_field('relationship_manytomany',[
							'key'=>'ecommerce_product_attribute-'.$ecommerce_product_attribute->id,
							'name'=>'data-product[ecommerce_product_attribute]['.$ecommerce_product_attribute->id.'][attribute_value]',
							'object'=>'ecommerce_product_attribute_value',
							'type_post'=>'ecommerce_product',
							'value'=>$r['attribute_value']??'',
							'where'=>[['ecommerce_product_attribute',$ecommerce_product_attribute->id]],
							'data'=>[
								'template'=>$view
							]
						]);


		?>

		<div class="row attribute-item" style="padding: 5px 10px;margin:0;border-top:1px solid #dedede;background:white;position:relative;">
			<img class="icon-svg-close remove" src="<?php echo asset(''); ?>admin/images/close-24px.svg">
			<div class="col-md-6 info">
				<input type="hidden" class="id_attribute" name="data-product[ecommerce_product_attribute][<?php echo $ecommerce_product_attribute->id; ?>][id]" value="<?php echo $ecommerce_product_attribute->id; ?>">
				<h3><?php echo $ecommerce_product_attribute->title; ?></h3>
				<label>
				<input type="checkbox" name="data-product[ecommerce_product_attribute][<?php echo $ecommerce_product_attribute->id; ?>][visibility]" <?php if( isset($r['visibility']) && $r['visibility'] === 'on' ){ echo 'checked="checked"'; } ?> value="on" class="form-control" > Có thể nhìn thấy trên trang sản phẩm</label>
				<label>
				<input type="checkbox" class="use_for_variable" name="data-product[ecommerce_product_attribute][<?php echo $ecommerce_product_attribute->id; ?>][is_attribute_variation]" <?php if( isset($r['is_attribute_variation']) && $r['is_attribute_variation'] === 'on' ){ echo 'checked="checked"'; } ?> value="on" class="form-control" > Dùng cho nhiều biến thể</label>
			</div>
			<div class="col-md-6">
				<?php echo $inputAttribute; ?>
			</div>
		</div>

		<?php
		// return $values;
	},

	// Load Variable for Product
	'load-variable-template'=>function( $r ){
		return load_variable_template($r);
	},


	'load-variable-save' => function( $r ){

		$post = Request::get('post');

		if( $post ){
			$post = get_post('ecommerce_product',$post);
			$value = $post->getMeta('product-info');
		}else{
			$value = null;
		}

		if( isset($value['ecommerce_product_attribute']) ){

			$list_attribute_save = ['value'=> $value['variable']??'', 'attributes'=> [] ];

			foreach ($value['ecommerce_product_attribute'] as $v) {
				$list_attribute_save['attributes'][] = [
					'id'=>$v['id'],
					'variable'=>$v['attribute_value'],
				];
			}
			
			echo load_variable_template($list_attribute_save);

		}
	},

	'load-attribute-sets'=>function($r) use ($plugin) {

		$id = $r->get('id');
		$product = $r->get('product');

		if( $product ){
			$product = get_post('ecommerce_product',$product);
		}

		$category = get_post('ecommerce_category',$id);

		$groups_attribute = json_decode($category->groups_attribute,true);

		$specifications = view_plugin($plugin, 'views.attribute-sets',['groups_attribute'=>$groups_attribute, 'product'=>$product]);

		$filters = view_plugin($plugin, 'views.filters',['category'=>$category, 'product'=>$product]);

		return ['specifications'=>$specifications,'filters'=>$filters];
	}

];