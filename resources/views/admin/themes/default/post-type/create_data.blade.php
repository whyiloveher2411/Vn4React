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

    View::share('admin_object',$postTypeConfig);

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
        echo '<a href="'.route('admin.show_data',['type'=>$post_type]).$requetParameter.'" class="vn4-btn vn4-btn-img"><i class="fa fa-list-ul" aria-hidden="true"></i> '.__('Back to List').'</a> <a href="'.route('admin.create_data',['type'=>$post_type]).$requetParameter.'" class="vn4-btn vn4-btn-img"><i class="fa fa-plus" aria-hidden="true"></i> '.__('Add New').'</a>';
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

  $index = 998;

?>


@section('content')

  <div class="create_data">
      <form class="form-horizontal form-label-left input_mask" id="form_create" method="POST" >
        {!!duplicate_submission()!!}
        

        <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
        <div class="row">

          <div class="col-md-9 col-xs-12 column-left">

           
            <div class="x_panel vn4-bg-trans">
                <div class="x_title">
                  <h2></h2>
                   <ul class="pull-right advance-feature">
                      <li class="dropdown ">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-eye"></i></a>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="{!!$post_type!!}">
                             <?php 
                                $after = strpos(URL::full(), "?");
                                if( $after !== false ){
                                  $after = substr(URL::full(), $after);
                                }else{
                                  $after = '';
                                }
                              ?>
                              @if( check_permission($post_type.'_list') )
                              <li><a href="{!!route('admin.show_data',$post_type),$after?$after.'&noSeeDetail=true':''!!}" class="only_show_data"><label>@__('Show Data')</a></label></li>
                              <li><a href="{!!route('admin.create_and_show_data',$post_type),$after!!}" class="create_and_show_data" ><label>@__('Create And Show Data')</a></label></li>
                              @endif
                          </ul>
                      </li>

                      <li class="dropdown ">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-edit"></i></a>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="{!!$post_type!!}">
                              @if( $post )
                              <li><a href="javascript:void(0)" onclick="window.location.href = replaceUrlParam(window.location.href,'type_view','fields');" class="create_data" ><label>@__('Fields')</a></label></li>
                              <li><a href="javascript:void(0)" onclick="window.location.href = replaceUrlParam(window.location.href,'type_view','custom-fields');" class="create_data" ><label>@__('Custom Fields')</a></label></li>
                              @endif

                          </ul>
                      </li>


                   </ul>
                   <div class="clearfix"></div>
                </div>

                 @if( Request::get('type_view') === 'custom-fields' && $post)
                 <div class="warper-meta-field">
                  <?php 
                      $meta = $post->getMeta();
                      if( !is_array($meta) ) $meta = [];

                      $value = [];

                      foreach ($meta as $key => $value_meta) {
                        $value[] = [
                          'delete'=>0,
                          'key'=>$key,
                          'value'=>!$value_meta || is_string($value_meta) ? $value_meta : json_encode($value_meta,JSON_PRETTY_PRINT)
                        ];
                      }

                      echo get_field('repeater',[
                        'button_label'=>'Add Field',
                        'value'=>$value,
                        'key'=>'meta',
                        'button_trash'=>false,
                        'sub_fields'=>[
                          'key'=>['title'=>'Key'],
                          'value'=>['title'=>'Value','view'=>'textarea','rows'=>6],
                        ]
                      ]);
                   ?>
                  </div>
                @else


                <div class="x_content" style="box-shadow:none;">

                  <?php 

                    if( isset($postTypeConfig['tabs']) ){
                      $list_tab = [];
                      foreach ($postTypeConfig['tabs'] as $key => $value) {
                        $list_tab[$key] = ['title'=>$value['title'],'content'=>function() use ($value) { echo '<input class="layout_tab_content" value=".form-input-'.implode(',.form-input-', $value['fields']).'" type="hidden" />'; }];
                      }
                      vn4_tabs_left($list_tab,false,'layout_tab_crud_data');
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

                @endif

            </div>

          </div>
          <div class="col-md-3 col-xs-12">
            
            <?php  do_action('add_meta_box_right_top',$postTypeConfig, $post, $post_type); ?>

            @include( backend_theme('post-type.input-status'))


            @if( !(Request::get('type_view') === 'custom-fields' && $post) )

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

            @endif

          </div>
                
        </div>

      </form>

  </div>
@stop
