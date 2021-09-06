@extends(backend_theme('master'))

@section('css')
  <style type="text/css">
    hr{
      margin: 4px 0 9px 0;
      border-top: 1px solid #d8d8d8;
    }

  </style>
@stop
<?php 

  title_head('Detail '.$postTypeConfig['title']);
    $action_post = Request::get('action_post',false);
    $wiget = [];
    $core = [];

    $hasPost = true;

    if( !$post ){
      $post = null;
      $hasPost = false;
    }



  ?>

    @foreach($postTypeConfig['fields'] as $key => $field)
    
      @if( !isset($field['not_create_and_update']) || $field['not_create_and_update'] !== true )

      @if(!isset($field['advance']))


          <?php $core[$key] = $field;$core[$key]['key'] = $key; ?>

          @if( $hasPost )

            @if(!isset($field['data_view']))
              <?php $core[$key]['value'] = $post[$key];?>
            @else
              <?php   $core[$key]['value'] = $value['value_'.$key];?>
            @endif

          @else
            <?php $core[$key]['value'] = '';?>
          @endif

      @else
        
        <?php $wiget[$field['advance']][$key] = $field; ?>

      @endif
      @endif
      
    @endforeach


@section('content')


  <div class="create_data">
      <form class="form-horizontal form-label-left input_mask" id="form_create" method="POST">
        {!!duplicate_submission()!!}
        <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
        <div class="row">
          <div class="col-md-8 col-xs-12 column-left">
            <div class="x_panel vn4-bg-trans">
              <div class="x_title">

                <h2>{!!__('Detail'),' ',$postTypeConfig['title']!!}
                  
                  @if( $hasPost )

                    @if(isset($postTypeConfig['callback_button']['create']))
                      @if(is_callable($postTypeConfig['callback_button']['create']))
                        <a href="{!!$postTypeConfig['callback_button']['create']()!!}" class="vn4-btn-white">{!!__('Add New'),' ',$postTypeConfig['title']!!}</a>
                      @else
                        <a href="{!!$postTypeConfig['callback_button']['create']!!}" class="vn4-btn-white">{!!__('Add New'),' ',$postTypeConfig['title']!!}</a>
                      @endif

                    @else

                    &nbsp;<a href="{!!route('admin.create_data',['type'=>$post_type])!!}" class="vn4-btn-white">{!!__('Add New'),' ',$postTypeConfig['title']!!}</a>
                    
                    @endif

                    @if( check_permission($post_type.'_edit') )
                      &nbsp;<a href="{!!route('admin.create_data',['type'=>$post_type,'post'=>$post->id,'action_post'=>'edit'])!!}" class="vn4-btn-white">{!!__('Edit Post')!!}</a>
                    @endif
                        
                  @endif</h2>
                <ul class="nav navbar-right panel_toolbox">
                  
                  @if( check_post_layout($post_type,'create_and_show_data') )
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <a href="#" class="create_and_show_data">@__('Layout Create And Show Data')</a>
                      </li>
                    </ul>
                  </li>
                  @endif
                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content" style="display: block;">
                <br>
                  <?php $wiget; ?>

                    @foreach($core as $key => $field)

                        <?php 
                          if( !isset($field['view']) ) $field['view'] = 'input';
                         ?>

                         <div class="row">
                           <div class="col-md-3 text-right">
                             <label class="" for="{!!$key!!}"> {!!$field['title']!!} :</label>
                           </div>

                           <div class="col-md-9">
                              
                              @if( is_array($field['view']) )

                                @if( isset($field['view']['detail']) && is_callable($field['view']['detail']) )
                                  {!!call_user_func_array($field['view']['detail'],[$field])!!}
                                @else
                                  {!!$post->{$key}!!}
                                @endif

                              @else
                                @if( view()->exists(backend_theme('particle.input_field.'.$field['view'].'.detail')))
                                {!!view(backend_theme('particle.input_field.'.$field['view'].'.detail'), $field)!!}
                                @else
                                {!!$post->{$key}!!}
                                @endif
                              @endif
                              @if($field['view'] != 'image')
                              <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
                              @endif
                           </div>


                         </div>
                          <hr>
                          
                    @endforeach
              </div>
            </div>
            
            @if(!empty($wiget) && isset($wiget['left']))
               @foreach($wiget['left'] as $key => $field)
                <div class="x_panel">
                  <div class="x_title">
                    <?php 
                        $action = do_action($post_type.'_fields_'.$key,'<label>'.$field['title'].'</label>');
                     ?>
                     @if( $action )
                      <h2>{!!$action!!}</h2>
                     @else
                      <h2><label>{!!$field['title']!!}</label></h2>
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
                  <div class="x_content">
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
                      
                       @if( is_array($field['view']) )
                       
                        @if( isset($field['view']['detail']) && is_callable($field['view']['detail']) )
                          {!!call_user_func_array($field['view']['detail'],[$field])!!}
                        @else
                          {!!$post->{$key}!!}
                        @endif

                      @else
                        @if( view()->exists(backend_theme('particle.input_field.'.$field['view'].'.detail')))
                        {!!view(backend_theme('particle.input_field.'.$field['view'].'.detail'), $field)!!}
                        @else
                        {!!$post->{$key}!!}
                        @endif
                      @endif

                      <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
                  </div>
                </div>
              @endforeach
            @endif
              

            <?php  do_action('add_meta_box_left',$postTypeConfig, $post, $post_type); ?>

          </div>
          <div class="col-md-4 col-xs-12">
            
            <?php  do_action('add_meta_box_right_top',$postTypeConfig, $post, $post_type); ?>

            <div class="x_panel">
                <div class="x_title">
                  <h2>@__('Status')</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                   <div class="vn4-published-status">
                     <p><i class="fa fa-key" aria-hidden="true"></i>  @__('Status'): <strong class="text-publish-status" style="text-transform: capitalize;" >{!!$post->status!!}</strong></p>
                     <p><i class="fa fa-eye" aria-hidden="true"></i> @__('Visibility'): <strong class="text-publish-password">
                       @if( !$hasPost || $post->visibility === 'publish' || trim($post->visibility) === '' ) @__('Public Key') @endif
                       @if( $hasPost && $post->visibility === 'password'  ) @__('Password protected') @endif
                       @if( $hasPost && $post->visibility === 'private'  ) @__('Private') @endif
                     </strong>
                     </p>
                     <p><i class="fa fa-calendar" aria-hidden="true"></i>  @__('Published on'):  <strong class="text-publish-date">

                      <?php 
                        $date = null;
                        $hour = null;

                        if( $hasPost && $post->post_date_gmt ){
                          $data = date('Y-m-d', $post->post_date_gmt);
                          $hour = date('H:i', $post->post_date_gmt);
                        }

                      ?>

                      @if( $date && $hour )
                        {!!$date,' ',$hour!!}
                      @else
                        @if( $hasPost )
                        {!!date_format($post->created_at, 'Y-m-d H:i')!!}
                        @else
                        @__('immediately')
                        @endif
                      @endif
                     </strong>
                     </p>
                   </div>
                    
                </div>
                <div class="clearfix"></div>
              </div>


            @if(!empty($wiget) && isset($wiget['right']))
               @foreach($wiget['right'] as $key => $field)
                <div class="x_panel">
                  <div class="x_title">
                    
                    <?php 
                        $action = do_action($post_type.'_fields_'.$key,$field['title']);
                     ?>
                     @if( $action )
                      <h2>{!!$action!!}</h2>
                     @else
                      <h2>{!!$field['title']!!}</h2>
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
                      if( !isset($field['view']) ) $field['view'] = 'input';
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
                      
                      @if( is_array($field['view']) )
                        @if( isset($field['view']['detail']) && is_callable($field['view']['detail']) )
                          {!!call_user_func_array($field['view']['detail'],[$field])!!}
                        @else
                          {!!$post->{$key}!!}
                        @endif

                      @else
                        @if( view()->exists(backend_theme('particle.input_field.'.$field['view'].'.detail')))
                        {!!view(backend_theme('particle.input_field.'.$field['view'].'.detail'), $field)!!}
                        @else
                        {!!$post->{$key}!!}
                        @endif
                      @endif

                      <p class="note">{!!isset($field['note'])?$field['note']:''!!}</p>
                  </div>
                </div>
              @endforeach
            @endif

             <?php  do_action('add_meta_box_right',$postTypeConfig, $post, $post_type); ?>

          </div>
                
        </div>

      </form>

  </div>
@stop
