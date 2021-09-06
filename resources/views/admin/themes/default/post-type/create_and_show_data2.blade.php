@extends(backend_theme('master'))

<?php 
    if( isset($postTypeConfig['link_create']) ){
        return vn4_redirect($postTypeConfig['link_create']);
    }

    $action_post = Request::get('action_post',false);
    $wiget = [];
    $core = [];

    $requetParameter = get_param(['edit_id']);

    if($requetParameter  != ''){
      $requetParameter = '?'.$requetParameter;
    }

    $hasPost = true;

    if( $action_post === 'copy' ){
      $post = get_post($post_type,Request::get('post'));
    }

    if( !isset($post) ){
      $post = null;
      $hasPost = false;
      title_head('Add New '.$postTypeConfig['title']);
    }else{

      if( isset($postTypeConfig['public_view']) && $postTypeConfig['public_view'] ){
        add_action('vn4_adminbar',function() use ($post) {
          echo '<li class="li-title"><a href="'.get_permalinks($post).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>'.__('View Post').'</a></li>';
        });
      }

      title_head('Edit '.$postTypeConfig['title']);

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

    if( check_permission($post_type.'_create') &&  ( !isset($postTypeConfig['layout']) 
      || ( (is_string($postTypeConfig['layout']) && $postTypeConfig['layout'] === 'create_data') 
      || (is_array($postTypeConfig['layout']) && array_search('create_data', $postTypeConfig['layout']) !== false) )) ){

      add_action('vn4_heading',function() use ($post_type, $requetParameter,$postTypeConfig) {
        echo '<a href="'.route('admin.create_data',['type'=>$post_type]).$requetParameter.'" class="pull-left vn4-btn vn4-btn-img"><i class="fa fa-plus" aria-hidden="true"></i> '.__('Add New').'</a>';
      });
            
    }

    View::share(['postDetail'=>$post]);


  foreach($postTypeConfig['fields'] as $key => $field){

     if( !isset($field['view']) ) $field['view'] = 'input';

     if( $field['view'] === 'hidden' ) continue;

      $field['type_post'] = $post_type;
      if( !isset($field['not_create_and_update']) || $field['not_create_and_update'] !== true ){
        if(!isset($field['advance'])){
            $core[$key] = $field;$core[$key]['key'] = $key;
            if( $hasPost ){
              if(!isset($field['data_view'])){
                $core[$key]['value'] = $post[$key];
              }else{
                $core[$key]['value'] = $value['value_'.$key];
              }
            }else{
              $core[$key]['value'] = '';
            }
        }else{
          $wiget[$field['advance']][$key] = $field;
        }
      }
      
  }
?>


@section('content')
	<style type="text/css">
		.vn4_tabs_top>.content-bottom{
			background: none;
	  		border-width: 1px 0 0 0;
		}
	</style>
  <div class="create_data">

  	<?php 
  		vn4_tabs_top([
  			'list'=>[
  				'title'=>'<i class="fa fa-list-ul"></i> List',
  				'content'=>function() use ($post_type) {
  					admin_data_table($post_type);
  				}
  			],
  			'create'=>[
  				'title'=>'<i class="fa fa-edit"></i> Create',
  				'content'=>function() use ($post_type,$core, $__env, $post, $postTypeConfig, $action_post, $hasPost, $wiget ) {
  					?>
  						 <form class="form-horizontal form-label-left input_mask" id="form_create" method="POST" >
					        {!!duplicate_submission()!!}
					        <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
					        <div class="row">

					          <div class="col-md-9 col-xs-12 column-left">
					            <div class="x_panel vn4-bg-trans">
					                <div class="x_content" style="box-shadow:none;">
					                  <?php 

					                    if( isset($postTypeConfig['tabs']) ){
					                      $list_tab = [];
					                      foreach ($postTypeConfig['tabs'] as $key => $value) {
					                        $list_tab[$key] = ['title'=>$value['title'],'content'=>function() use ($value) { echo '<input class="layout_tab_content" value=".form-input-'.implode(',.form-input-', $value['fields']).'" type="hidden" />'; }];
					                      }
					                      vn4_tabs_top($list_tab,false,'layout_tab_crud_data');
					                      echo '<br>';
					                    }

					                   ?>

					                  @foreach($core as $key => $field)

					                      <div class="form-group form-field form-input-{!!$key!!}">
					                        <label class="" for="{!!$key!!}"> {!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif
					                        </label>
					                        <div class="col-md-12 col-sm-12 col-xs-12 vn4-pd0">
					                            
					                            <?php 
					                                $action = do_action($post_type.'_fields_'.$key, $field, $post);
					                             ?>

					                             @if( $action )
					                                {!!$action!!}
					                             @else
					                                {!!get_field($field['view'], $field, $post)!!}
					                             @endif


					                            @if($field['view'] != 'image')
					                            <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
					                            @endif
					                        </div>
					                      </div>
					                  @endforeach
					                  <?php 
					                    $index = 998;
					                   ?>
					                  @if(!empty($wiget) && isset($wiget['left']))
					                     @foreach($wiget['left'] as $key => $field)
					                      <div class="x_panel form-input-{!!$key!!}" style="z-index:{!!$index--!!}">
					                        <div class="x_title">
					                          <?php 
					                              $action = do_action($post_type.'_fields_'.$key,'<label>'.$field['title'].'</label>');
					                           ?>
					                           @if( $action )
					                            <h2>{!!$action!!}</h2>
					                           @else
					                            <h2><label>{!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif</label></h2>
					                           @endif

					                          <ul class="nav navbar-right panel_toolbox">
					                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					                            </li>
					                            <li class="dropdown">
					                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
					                              <ul class="dropdown-menu" role="menu">
					                                <li><a href="#">Settings 1</a>
					                                </li>
					                                <li><a href="#">Settings 2</a>
					                                </li>
					                              </ul>
					                            </li>
					                            <li><a class="close-link"><i class="fa fa-close"></i></a>
					                            </li>
					                          </ul>
					                          <div class="clearfix"></div>
					                        </div>
					                        <div class="x_content ">
					                           <?php $field['key'] =  $key;?>
					                           
					                            @if( $hasPost )

					                              @if(!isset($field['data_view']))

					                                <?php $field['value'] = $post[$key];?>
					                              @else
					                                <?php $field['value'] = $value['value_'.$key];?>
					                              @endif
					                            @else
					                              <?php $field['value'] = '';?>
					                            @endif
					                            
					                            {!! get_field($field['view'], $field, $post) !!}

					                            <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
					                        </div>
					                      </div>
					                    @endforeach
					                  @endif
					                    

					                  <?php  do_action('add_meta_box_left',$postTypeConfig, $post, $post_type); ?>
					                </div>
					              </div>
					          </div>
					          <div class="col-md-3 col-xs-12">
					            
					            <?php  do_action('add_meta_box_right_top',$postTypeConfig, $post, $post_type); ?>

					            @include( backend_theme('post-type.input-status'))


					            @if(!empty($wiget) && isset($wiget['right']))
					               @foreach($wiget['right'] as $key => $field)
					                <div class="x_panel form-input-{!!$key!!}"  style="z-index:{!!$index--!!}">
					                  <div class="x_title">
					                    
					                    <?php 
					                        $action = do_action($post_type.'_fields_'.$key,$field['title']);
					                     ?>
					                     @if( $action )
					                      <h2>{!!$action!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif</h2>
					                     @else
					                      <h2>{!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif</h2>
					                     @endif

					                    <ul class="nav navbar-right panel_toolbox">
					                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					                      </li>
					                    </ul>
					                    <div class="clearfix"></div>
					                  </div>
					                  <div class="x_content">
					                     <?php 
					                      $field['key'] =  $key;
					                     ?>
					                     
					                      @if( $hasPost )

					                        @if(!isset($field['data_view']))

					                          <?php $field['value'] = $post[$key];?>
					                        @else
					                          <?php $field['value'] = $value['value_'.$key];?>
					                        @endif

					                      @else
					                        <?php $field['value'] = '';?>
					                      @endif
					                      
					                      {!! get_field($field['view'], $field, $post) !!}

					                      <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
					                  </div>
					                </div>
					              @endforeach
					            @endif

					             <?php  do_action('add_meta_box_right',$postTypeConfig, $post, $post_type); ?>

					          </div>
					                
					        </div>

					      </form>
  					<?php
  				}
  			]
  		]);
  	 ?>
     

  </div>
@stop
