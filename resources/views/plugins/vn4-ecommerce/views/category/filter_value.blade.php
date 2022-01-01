<?php
if( !empty($ids) ){

	$posts = get_posts('ecommerce_filter',['callback'=>function($q) use ($ids){
		$q->whereIn('id',$ids);
	}])->keyBy('id');

	foreach( $ids as $id){

		if( isset($posts[$id]) ){
			echo '<div class="col-md-12 col-sm-12 col-xs-12 vn4-pd0" id="filter_value_'.$id.'" ><h3 style="margin-bottom: 10px;">'.$posts[$id]->title.'</h3>'.get_field('relationship_manytomany',[
				'title'=>'Filters',
				'key'=>'filter_value_'.$id,
				'name'=>'filter_value_['.$id.']',
				'type_post'=>'ecommerce_category',
				'object'=>'ecommerce_filter_value',
				'where'=>[
					['ecommerce_filter',$id]
				],
				'value'=>$filter_value[$id]??'',
			]).'</div>';
		}
	}
}

