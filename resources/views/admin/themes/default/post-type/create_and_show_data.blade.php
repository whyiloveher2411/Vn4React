@extends(backend_theme('master'))

<?php 
	
	if( isset($postTypeConfig['link_create']) ){
        return vn4_redirect($postTypeConfig['link_create']);
    }
    
    $action_post = Request::get('action_post',false);

	$hasPost = true;

    if( !isset($post) ){

      $post = null;
      $hasPost = false;

    }else{

		if( $postTypeConfig['public_view'] ){
    	
	        add_action('vn4_adminbar',function() use ($post) {
	          echo '<li class="li-title"><a href="'.get_permalinks($post).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>'.__('View Post').'</a></li>';
	        });
        }
    }

	$postTypeConfig['fields']['template'] = [
		'title'=>'Attributes',
		'view'=>[
			'form'=>function($field){
				return view(backend_theme('post-type.input-attributes'),$field);
			},
		],
		'advance'=>'right',
		'show_data'=>false,
	];


    $requetParameter = get_param(['page']);
         
     if($requetParameter  != ''){
       $requetParameter = '?'.$requetParameter;
     }
	
	if( check_permission($post_type.'_create') &&  ( !isset($postTypeConfig['layout']) 
      || ( (is_string($postTypeConfig['layout']) && $postTypeConfig['layout'] === 'create_data') 
      || (is_array($postTypeConfig['layout']) && array_search('create_data', $postTypeConfig['layout']) !== false) )) ){

      add_action('vn4_heading',function() use ($post_type, $requetParameter,$postTypeConfig) {
        echo '<a href="'.route('admin.create_and_show_data',['type'=>$post_type]).$requetParameter.'" class="pull-left vn4-btn vn4-btn-img"><i class="fa fa-plus" aria-hidden="true"></i> '.__('Add New').'</a>';
      });
    }

	title_head($postTypeConfig['title']);

    View::share('admin_object',$postTypeConfig);
    View::share(['postDetail'=>$post]);

 ?>

@section('css')
	<style>
		.label-input{
			margin: 0;
		}
	</style>
@stop

@section('content')

<div class="create_and_show_data" role="main" >
   <div class="row sortable">
      	<div class="col-md-4 col-xs-12 wapper-panel col-left">

      		<form method="POST" id="form_create">
        		{!!duplicate_submission()!!}
      			@if( $hasPost ) <input type="text" name="status" value="{!!$post->status!!}" hidden>  @endif
      			
         	<div class="x_panel vn4-bg-trans">
	            <div class="x_title">

					@if( $hasPost )
						<?php $title = 'Edit' ?>
					@else
					<?php $title = 'Add' ?>
					@endif
	            	<h2>
		                {!!$title!!}
		            </h2>
	               <div class="clearfix"></div>
	            </div>
	            <div class="x_content" style="box-shadow:none;">
	               <br>
	                  <input type="text" value="{!!csrf_token()!!}" name="_token" hidden >

                    <?php 

                        if( isset($postTypeConfig['tabs']) ){
                          $list_tab = [];
                          foreach ($postTypeConfig['tabs'] as $key => $value) {
                            $list_tab[$key] = ['title'=>$value['title'],'content'=>function() use ($value) { echo '<input class="layout_tab_content" value=".form-input-'.implode(',.form-input-',$value['fields']).'" type="hidden" />'; }];
                          }
                          vn4_tabs_left($list_tab,false,'layout_tab_crud_data');
                          echo '<br>';
                        }

                     ?>


	                  @foreach($postTypeConfig['fields'] as $key => $field)
	                  	<?php 
	                		if( !isset($field['view']) ) $field['view'] = 'input';
     						if( $field['view'] === 'hidden' ) continue;

	                     	$field['key'] =  $key;
	                 		$field['type_post'] =  $post_type;
	             		?>

						@if( !isset($field['not_create_and_update']) || $field['not_create_and_update'] !== true )
						
		                  <div class="form-group form-field form-input-{!!$key!!}">
		                    <label class="label-input" for="{!!$key!!}"> {!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif
		                    </label>
	                    	
		                     @if( $hasPost )
		                     @if(!isset($field['data_view']))
		                     <?php $field['value'] = $post[$key];?>
		                     @else
		                     <?php $field['value'] = $value['value_'.$key];?>
		                     @endif
		                     @else
		                     <?php $field['value'] = '';?>
		                     @endif
							
							<?php 
								$action = do_action($post_type.'_fields_'.$key, $field, $post);
							 ?>
							 @if( $action )
								{!!$action!!}
							 @else
								{!!get_field($field['view'], $field, $post)!!}
							 @endif

	                        @if($field['view'] != 'image')
	                        <p class="note">{!!@$field['note']!!}</p>
	                        @endif
		                     <div class="clearfix"></div>
		                  </div>
						@endif
	                  @endforeach
	                  <?php 
		                do_action('add_meta_box_left',$postTypeConfig,$post, $post_type);
		                do_action('add_meta_box_right_top',$postTypeConfig, $post, $post_type);
		                do_action('add_meta_box_right',$postTypeConfig,$post, $post_type);
			         ?>

            		@include( backend_theme('post-type.input-status'))
		         
	            </div>
	         </div>
          </form>
      	</div>
		<div class="col-md-8 col-xs-12 wapper-panel col-right">
	       <?php admin_data_table($post_type); ?>
		</div>
   </div>
</div>


@stop


@section('js')
	
	<script>
	   $('.show_full_width').click(function(event) {
	    $(this).closest('.wapper-panel').toggleClass('width_100');
	    $(this).toggleClass('btn-primary');
	     event.preventDefault();
	   });
	</script>

@stop