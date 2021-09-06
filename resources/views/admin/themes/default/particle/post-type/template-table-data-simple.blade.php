@extends(backend_theme('master'))
@section('content')

  <?php
    use_module('post');

    function vn4_get_tbody_data2( $list_data, $type, $admin_object, $list_column_show = false, $groupBy = false, $data_link = '' ){
      $fields = $admin_object['fields'];
      $post_active = Request::get('post',0);
      
      $str = '';
          
      if( !$groupBy && method_exists($list_data,'total') && $list_data->total() == 0 ){
          $tbody = '<tr class="odd"><td valign="top" colspan="1000" class="dataTables_empty"><h4 style="font-size:18px;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="'.asset('admin/images/data-not-found.png').'"><strong>'.__('Nothing To Display.').' <br> <span style="color:#ababab;font-size: 16px;">Seems like no '.$admin_object['title'].' have been created yet.</span></strong></h4></td></tr>';
      }else{
          $list_post_filter = do_action('post_filter');
          $tbody  = '';
          $post_filter = Request::get('post_filter','all');
          $permission_list = [
              'edit'=>check_permission($type.'_edit'),
              'quick-edit'=>check_permission($type.'_edit'),
              'trash'=>check_permission($type.'_trash'),
              'restore'=>check_permission($type.'_restore'),
              'detail'=>check_permission($type.'_detail'),
              'delete'=>check_permission($type.'_delete')
          ];
          $row_actions_list = [
              'edit' => '<a class="editRow action_post" action="edit" href="#">'.__('Edit').'</a>',
              'quick-edit' =>function($post) use ($type, $admin_object) { return '<a data-popup="1" data-title="Editing: '.$post->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$post->id,'action_post'=>'edit']).'" href="#">'.__('Quick Edit').'</a>';},
              'copy' => '<a class="editRow action_post" action="copy" href="#">'.__('Copy').'</a>',
              'trash' => '<a class="trashRow action_post" href="#" action="trash">'.__('Trash').'</a>',
              'detail' => function($post) use ($type, $admin_object) { return '<a data-popup="1" data-title="Detail: '.$post->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$post->id,'action_post'=>'detail']).'" href="#">'.__('Detail').'</a>';},
              'delete' => '<a class="delete action_post" href="#" action="delete">'.__('Delete').'</a>',
              'restore' => '<a class="restoreRow action_post" href="#" action="restore">'.__('Restore').'</a>',
          ];

          $class_tr = 'item_group';

          if( !$groupBy ){
              $list_data = [$list_data];
              $class_tr = '';
          }
          
          foreach ($list_data as $group => $data) {
              
              if( $groupBy ){
                  $tbody  .= '<tr><td colspan="100" data-key="'.$group.'" class="td_show_group_data_table"><i class="fa fa-caret-right" aria-hidden="true"></i> '.$group.' ('.count($data).')</td></tr>';
              }

              foreach($data as $item){

                  $showed_filter = true;
                  $class = 'post-data';
                  if($item->id == $post_active){
                      $class = 'post-data my-post';
                  }

                  $tbody = $tbody.'<tr data-group="'.$group.'" class="'.$class.' '.$class_tr.'" data-status="'.$item->status.'" data-edit="'.route('admin.create_and_show_data',['type'=>$type]).'"" data-id="'.$item->id.'" post-type="'.$item->group.'" tag-type="'.$item->type.'">';

                  $string_status = '';
                  if( $item->visibility !== 'publish' && $post_filter != 'visibility_'.str_slug($item->visibility) && isset($list_post_filter[str_slug($item->visibility)]['title']) ){
                      $string_status = $string_status.' - '.$list_post_filter[str_slug($item->visibility)]['title'];
                  }
                  if ( $item->post_date_gmt  && $post_filter != 'post_date_gmt_' && isset( $list_post_filter['future']['title'] ) ){
                       $string_status = $string_status.' - '.$list_post_filter['future']['title'];
                  }
                  if( $item->status !== 'publish' && $post_filter != 'status_'.str_slug($item->status)  && isset($list_post_filter[str_slug($item->status)]['title']) ){
                      $string_status = $string_status.' - '.$list_post_filter[str_slug($item->status)]['title'];
                  }
                  if( $item->is_homepage ){
                      $json = json_decode($item->is_homepage,true);
                      $string_status .= ' - '.$json['title'];
                  }

                  $starred = $item->starred;
                  if( $starred ){
                      $starred = '<i class="fa fa-star post-star active" aria-hidden="true"></i>';
                  }else{
                      $starred = '<i class="fa fa-star-o post-star" aria-hidden="true"></i>';
                  }

                  $info_time = $starred.'<p style="font-size:12px;color:#808080;margin:0;">Added: '.get_date_time($item->created_at).'<br>Last Updated: '.get_date_time($item->updated_at).'</p>';
                  $string_status = '<strong style="font-size:14px;"> '.$string_status.'</strong>';
                  $add_row_action = true;

                  foreach($fields as $key => $value){
                      if( !isset($value['view']) ) $value['view'] = 'input';
                      if( ( $list_column_show && array_search($key, $list_column_show) !== false ) || (!$list_column_show && (!isset($value['show_data']) || $value['show_data']) ) ){

                          if( isset($value['live_edit']) && $value['live_edit'] && $permission_list['edit'] ){
                              $value['type_post'] = $item->type;
                              $value['value'] = $item[$key];
                              $value['is_live_edit'] = true;
                              $value['key'] = $key;
                              $content = '<div class="live_edit">'.get_field($value['view'], $value, $item).'</div>';
                          }else{
                              if( isset($value['show_data']) && is_callable( $value['show_data']) ){
                                  $content =  call_user_func_array($value['show_data'],[$item,$item->{$key}]);
                              }else{
                                  if( !is_array($value['view']) ){
                                      if( is_string($value['view']) ){
                                          if( view()->exists( $view = backend_theme('particle.input_field.'.$value['view'].'.view') ) ){
                                              $content = vn4_view($view,['post'=>$item,'key'=>$key, 'field'=>$value, 'value'=> $item->{$key}]);
                                          }else{
                                              $content = e($item[$key]);
                                          }
                                      }else{
                                          $content = e($item[$key]);
                                      }
                                  }else{
                                      $content = e($item[$key]);
                                  }
                              }
                          }
                          if( $add_row_action ){
                              $add_row_action = false;
                              if( $permission_list['edit'] ){
                                  $tbody = $tbody.'<td class="post-col" data-name="'.$key.'"><a href="#" '.$data_link.' data-popup="1" data-title="Editing: '.$item->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$item->id,'action_post'=>'edit']).'">'.$content.'</a>'.$string_status.$info_time.'</td>';
                              }else{
                                   if( $permission_list['detail'] ){
                                      $tbody = $tbody.'<td class="post-col" data-name="'.$key.'"><a href="#" '.$data_link.' data-popup="1" data-title="Editing: '.$item->title.'" data-iframe="'.route('admin.create_data',['type'=>$type,'post'=>$item->id,'action_post'=>'detail']).'">'.$content.'</a>'.$string_status.$info_time.'</td>';
                                  }else{
                                      $tbody = $tbody.'<td class="post-col" data-name="'.$key.'">'.$content.$string_status.$info_time.'</td>';
                                  }
                              }
                          }else{
                              $tbody = $tbody.'<td class="post-col" data-name="'.$key.'">'.$content.'</td>';
                          }
                      }


                  }
                  $tbody = $tbody.'</tr>';
              }

          }
      }
       $str = $str.$tbody;
      return $str;
  }
    
    $admin_object = get_admin_object();

    $title = $r->get('title', $admin_object[$type]['title']);
    
    $callback_reload = $r->get('data_iframe');

    if( is_array($callback_reload) ) $callback_reload = 'data="'.e(json_encode($callback_reload)).'"';

    if( $post_related = $r->get('post_related') ){

      $post = get_post($post_related['type'],$post_related['id']);

      $field = $admin_object[ $post_related['type'] ] ['fields'][$post_related['key']];

      $posts = $post->related( $field['object'], $field['field'],['paginate'=>'page','count'=>5] );

    }else{

      $posts = Vn4Model::table($admin_object[$type]['table']);

      $where = $r->get('where');

      if( $where ){
        foreach ($where as $dk) {
          $posts = $posts->where($dk[0],$dk[1],$dk[2]);
        }
      }
      $posts = $posts->orderBy('created_at','desc')->paginate(5);

    }

    $theader = '';

    $show_column = Auth::user()->getMeta('show_fields_show_template_table_'.$type)??[];

    foreach($admin_object[$type]['fields'] as $key => $value){
        $width = '';
        if( isset($value['width_column_table']) ){
            $width = 'style="width:'.$value['width_column_table'].'px"';
        }
        if( ( $show_column && array_search($key, $show_column) !== false ) ||  (!$show_column && (!isset($value['show_data']) || $value['show_data'])) ){
            $theader = $theader.'<th data-field="'.$key.'" '.$width.'>'.$value['title'].'</th>';
        }
    }

    $list_post_filter = null;

    $post_filter_count = vn4_get_post_count_status( $admin_object[$type] , $type , $list_post_filter, 'all' );

    $body = vn4_get_tbody_data2($posts, $type, $admin_object[$type], $show_column, false, $callback_reload);

  ?>
  <style type="text/css">
    html, body{
      padding-bottom: 10px !important;
    }
    .container.body .right_col{
      padding: 0;
    }
    .message-warper{
      display: none;
    }
    table tr th:first-child{
      width: auto;
    }
    .table>tbody>tr>td:nth-child(2){
      min-width: auto;
    }
  </style>
  <div>
    <div class="table-responsive quan-table">
      <table class="table table-bordered table-hover">
      <thead>
        <tr>
          {!!$theader!!}
        </tr>
      </thead>
      <tbody>
        {!!$body!!}
      </tbody>
    </table>
    </div>

    {!!vn4_view(backend_theme('particle.post-type.paginate-simple'),['list_data'=>$posts])!!}
  </div>

@stop


