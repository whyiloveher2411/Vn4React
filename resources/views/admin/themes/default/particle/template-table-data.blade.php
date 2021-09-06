<?php 

  if( file_exists( $data_table = cms_path('resource','views/themes/'.theme_name().'/inc/datatable.php') ) ){
    include $data_table;
  }

  $plugins = plugins();

  foreach ($plugins as $plugin) {
    if( file_exists( $data_table = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/datatable.php')) ){
        include $data_table;
    }
  }

 $admin_object = get_admin_object($type);
 do_action('before_get_data_'.$type);
  $admin_object2 = do_action('custome-post-table',$type, $admin_object);
  if( $admin_object2 ) $admin_object = $admin_object2;
   $permission_create = check_permission($type.'_create');
   $permission_list = check_permission($type.'_list');
   $show_column = Auth::user()->getMeta('show_fields_show_template_table_'.$type);
   $groupby_column = Auth::user()->getMeta('show_fields_groupby_template_table_'.$type);
   $show_array = [];
   $groupby_array = [];
   foreach($admin_object['fields'] as $k => $f){
      $checked = '';
      if( $show_column ){
        if( array_search($k,$show_column) !== false ){
          $checked = 'checked="checked"';
        }
      }else{
        if( !isset($f['show_data']) || $f['show_data'] ){
          $checked = 'checked="checked"';
        }
      }
      $show_array[] = '<li><a href="javascript:void(0)"><label><input type="checkbox" name="list_data[]" '.$checked.' value="'.$k.'"> '.$f['title'].'</label></a></li>';
      $checked = '';
      if( $groupby_column ){
        if( $k === $groupby_column ){
          $checked = 'checked="checked"';
        }
      }
      if( isset($f['view']) && ($f['view'] === 'relationship_onetomany' || $f['view'] === 'select') ){
        $groupby_array[] = '<li><a href="javascript:void(0)"><label><input type="checkbox" name="group_data" '.$checked.' value="'.$k.'"> '.$f['title'].'</label></a></li>';
      }
   }
 ?>
<div class="x_panel vn4-bg-trans">
  <div class="x_content" style="box-shadow:none;">
      <?php 
      $key_word_post_type = preg_replace('/-/', '_', str_slug($type));
      $fields = $admin_object['fields'];
      use_module(['post']);
      $order_by_default = isset($admin_object['order_by_default'])?$admin_object['order_by_default']:['created_at','desc'];
      ?>
      @if(!isset($show_toolbar_status) || $show_toolbar_status == true)
      <div class="template-table-data">
          
      <h4>
      <div class="list_status btn-group">
      </div>
      <ul class="pull-right advance-feature">
          
          <li class="filters" data-popup="1" data-iframe="{!!route('admin.controller',['controller'=>'post-type','method'=>'load-filter-template','post_type'=>$type])!!}" data-title="Filters: {!!$admin_object['title']!!}" data-type="{!!$type!!}">
              <a href="javascript:void(0)"><i class="fa fa-filter" aria-hidden="true"></i> @__('Filters')</a>
              <!-- <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="{!!$type!!}">
                <li>
                  <label>@__('From')</label>
                  <div style="padding:0 10px;"><input type="date" id="date_from" value="{{Request::get('date_from')}}" class="form-control" name=""></div>
                </li>
                <li>
                  <label>@__('To')</label>
                  <div style="padding:0 10px 10px 10px;"><input type="date" id="date_to" value="{{Request::get('date_to')}}" class="form-control" name=""></div>
                </li>
                <li>
                  <div class="text-right" style="padding:0 10px 10px 10px;"><button type="button" class="vn4-btn vn4-btn-blue apply-filter">@__('Apply')</button></div>
                </li>
              </ul> -->
          </li>

         
          <li class="dropdown ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i> @__('Groups By')</a>
              <ul class="dropdown-menu dropdown-menu-right ul-fields-groupby" role="menu" data-type="{!!$type!!}">

                @if( isset($groupby_array[0]) )
                {!!implode('',$groupby_array)!!}
                @else
                <li><a href="#" class="only_show_data"><label>@__('Nothing')</label></a></li>
                @endif
              </ul>
          </li>
          <li class="dropdown ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cog"></i> @__('Columns')</a>
              <ul class="dropdown-menu dropdown-menu-right ul-fields-show" role="menu" data-type="{!!$type!!}">
                {!!implode('',$show_array)!!}
              </ul>
          </li>
          <li class="dropdown ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-eye"></i> @__('View')</a>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="{!!$type!!}">
                 <?php 
                    $after = strpos(URL::full(), "?");
                    if( $after !== false ){
                      $after = substr(URL::full(), $after);
                    }else{
                      $after = '';
                    }
                  ?>
                  @if( $permission_list )
                  <li><a href="{!!route('admin.show_data',$type),$after?$after.'&noSeeDetail=true':''!!}" class="only_show_data"><label>@__('Show Data')</label></a></li>
                  @endif
                  @if( $permission_list && $permission_create )
                  <li><a href="{!!route('admin.create_and_show_data',$type),$after!!}" class="create_and_show_data" ><label>@__('Create And Show Data')</label></a></li>
                  @endif
                  @if( $permission_create )
                  <li><a href="{!!route('admin.create_data',$type),$after!!}" class="only_create_data" ><label>@__('Create Data')</label></a></li>
                  @endif
              </ul>
          </li>
           <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cloud-download" aria-hidden="true"></i> @__('Export')</a>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" data-type="{!!$type!!}">
                <li><a href="#" data-file="csv" class="export-data"><label>CSV</label></a></li>
                <li><a href="#" data-file="xlsx" class="export-data"><label>Excel</label></a></li>
                <li><a href="#" data-file="json" class="export-data"><label>Json</label></a></li>
              </ul>
          </li>
          <li class="">
            <a href="{!!route('admin.page',['page'=>'post-type-report','post-type'=>$type])!!}"><i class="fa fa-pie-chart" aria-hidden="true"></i> @__('Report')</a>
          </li>
          <?php do_action('datatable-advance-feature', $type) ?>
          <li class="refresh-data-table"><a href="#"><i class="fa fa-refresh" aria-hidden="true"></i> @__('Refresh')</a></li>
      </ul>
      </h4>
      <div class="filter-warper" data-post-type="{!!$type!!}">
      </div>
      @endif
      <div class="quan_table_control_top">
          <div class="row">
              <div class="col-sm-6">
                  <div class="quan_table_length">
                      <label>
                          <?php 
                              $length = 10;
                              if(Request::has('length')){
                                  $length = intval(Request::get('length'));
                              }
                              $argLength = [10,25,50,100];
                              if(in_array($length,$argLength) !== true){
                                  $argLength[] = $length;
                              }
                              sort($argLength);
                              $select_length = '<select name="datatable_length" aria-controls="datatable" class="quan_select_table_length form-control input-sm">';
                              $selected = '';
                              foreach ($argLength as $key => $value) {
                                  $selected = '';
                                  if($length == $value){
                                      $selected = 'selected';
                                  }
                                  $select_length = $select_length.'<option '.$selected.' value="'.e($value).'">'.e($value).'</option>';
                              }
                              $select_length = $select_length.'</select>';
                              $show_count_per_page = str_replace( '##length##', $select_length, __('Show ##length## entries'));
                           ?>
                          {!!$show_count_per_page!!}
                      </label>
                       @if(!isset($show_toolbar_status) || $show_toolbar_status == true)
                          
                          <div class="info-table-top info_table_{!!$type!!}" style="">
                              <div class="clearfix"></div>
                          </div>
                      @endif
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="quan_table_filter">
                      <label>@__('Search'): <input type="search" class="form-control input-sm input-search" value="{{Request::get('search','')}}"  placeholder="{{__('Enter something')}}" aria-controls="datatable">
                      </label>
                  </div>
              </div>
          </div>
      </div>
      </div>
      <div class="table_data_{!!$type!!} quan-table-wapper ">
     
      <div class="table-wapper show_loading">
        <table id="datatable" class="table-responsive table table-striped quan-table">
            <thead class="data_thead_{!!$type!!}">
                <tr>
                <?php 
                    $theader = '<th><input type="checkbox" class="show-data-checkall" ></th>';
                    foreach($fields as $key => $value){
                        $width = '';
                        if( isset($value['width_column_table']) ){
                            $width = 'style="width:'.$value['width_column_table'].'px"';
                        }
                        if( ( $show_column && array_search($key, $show_column) !== false ) ||  (!$show_column && (!isset($value['show_data']) || $value['show_data'])) ){
                            $theader = $theader.'<th class="sorting '. ($order_by_default[0] == $key ? 'sorting_'.$order_by_default[1]: '') .'" data-field="'.$key.'" '.$width.'>'.$value['title'].'</th>';
                        }
                    }
                    $theader = $theader.'<th>'.__('Edit history').'</th>';
                 ?>
                {!!$theader!!}
                </tr>
            </thead>
            <tfoot class="data_tfoot_{!!$type!!}">
                {!!$theader!!}
            </tfoot>
            <tbody class="data_tbody_{!!$type!!} ">
              <tr class="odd"><td valign="top" colspan="1000" class="dataTables_empty" style="height: 75px;"></td></tr>
            </tbody>
        </table>
        <div class="loader"><img src="{!!asset('admin/images/loading.gif')!!}"></div>
      </div>

      <div class="info_table_{!!$type!!} info-table-bottom">
      </div>
      </div>
      <div class="clearfix"></div>

      <?php
      add_action('vn4_footer',function() use ($type,$key_word_post_type, $__env){
      ?>
      <script>
          $(window).load(function(){
              $show_item_form = $('.show_item_form').text();
              $show_item_to = $('.show_item_to').text();
              $total_item = $('.total_item').text();
              @if(Request::has('order_field'))
                 $('.sorting_desc').removeClass('sorting_desc');
                 $('.sorting[data-field={!!Request::get('order_field')!!}]').addClass('sorting_{!!Request::get('order_value')!!}');
              @endif
              $dataSearch{!!$key_word_post_type!!} = [];
              
              window.load_data_table = function(url, callback, data_i, pushState = true, first = false ){
                  $('.table-wapper').addClass('show_loading');

                  url = url.split('#')[0];

                  if ( pushState ){
                      if( first ){
                        window.history.pushState( {url:url,page: 'Page template table First'}, "Page template table",  url);
                      }else{
                        window.history.pushState( {url:url,page: 'Page template table'}, "Page template table",  url);
                      }
                  }
                  
                  url = replaceUrlParam(url,'post_type', '{!!$type!!}');
                  <?php  $param_of_route = Route::current()->parameters(); ?>
                   @foreach($param_of_route as $key_param => $param)
                      url = replaceUrlParam(url,'param_of_route_{!!$key_param!!}', '{!!$param!!}');
                   @endforeach
                  var data = $dataSearch{!!$key_word_post_type!!}+'&type={!!$type!!}&_token={!!csrf_token()!!}';
                  if( data_i ){
                      data = data + data_i;
                  }
                  url = replaceUrlParam(url, 'getJsonData',true);
                  $.ajax({
                      url: url,
                      data: data,
                      type: 'POST',
                      dataType: 'Json',
                      beforeSend:function(){
                      },
                      success:function(result){

                          if( result.message ){
                              show_message(result.message);
                              return;
                          }

                          $('.show-data-checkall').prop({checked:false});
                          $('.data_tbody_{!!$type!!}, .info_table_{!!$type!!}').empty();
                          $('.data_tbody_{!!$type!!}').html(result.data);
                          $('.data_thead_{!!$type!!} tr').html(result.thead);
                          $('.data_tfoot_{!!$type!!} tr').html(result.thead);
                          
                          $('.info_table_{!!$type!!}').html(result.pagination+'<div class="clearfix"></div>');
                          $('.template-table-data .list_status').empty().append(result.status_count);
                        
                          if (typeof callback === "function") {
                             callback(result);
                          }
                      }
                  }).always(function(){
                      $('.table-wapper').removeClass('show_loading');
                  });
              };

              $(window).on("popstate", function () {
                if (history.state && "Page template table" === history.state.page) {
                  load_data_table(history.state.url, null, null, false);
                }else if (history.state && "Page template table First" === history.state.page) {
                  load_data_table(history.state.url, null, null, false);
                    history.back();
                }
              });

              $(document).on('click','.refresh-data-table',function(){
                  load_data_table(window.location.href);
              });

              $(document).on('change','.quan_select_table_length',function(){
                 
                  var url = replaceUrlParam(window.location.href,'length', $(this).val());
                  load_data_table(url);
              });


              $('.quan-table-wapper').on('click','.quan-table .sorting', function(){
                  if($(this).hasClass('sorting_desc')){
                      $(this).removeClass('sorting_desc').addClass('sorting_asc');
                  }else{
                      if($(this).hasClass('sorting_asc')){
                          $(this).removeClass('sorting_asc').addClass('sorting_desc');
                      }else{
                          $('.quan-table .sorting_desc').removeClass('sorting_desc');
                          $('.quan-table .sorting_asc').removeClass('sorting_asc');
                          $(this).addClass('sorting_asc');
                      }
                  }
                  $defineSort = $(this).hasClass('sorting_asc')?'asc':'desc';
                  var order_field = $(this).attr('data-field');
                  var order_value = $defineSort;
                  var url = replaceUrlParam(window.location.href,'order_field', order_field);
                      url = replaceUrlParam(url,'order_value', order_value);
                  
                  load_data_table(url);
              });
              $linkEdit = replaceUrlParam(window.location.href,'page',1);
              $linkDelete = replaceUrlParam(window.location.href,'page',1);
              $linkDetail = replaceUrlParam(window.location.href,'page',1);
              
              $('.quan-table').on('click','.action_post',function(event){
                  
                  id = $(this).closest('tr').attr('data-id');
                  $url = replaceUrlParam(window.location.href,'post',id);
                  if($(this).hasClass('detailRow') || $(this).hasClass('editRow')){
                       $url = replaceUrlParam($url,'action_post',$(this).attr('action'));
                       $url = removeParam('noSeeDetail',$url);
                       window.location.href = $url;
                       return false;
                  }
                  var submit_action_post = $(this).attr('action');
                  if($(this).hasClass('delete')){
                      var r = confirm('@__('data_table.message_alert_delete_one'). {'+id+'}');
                  
                      if (r == true) {
                          load_data_table(replaceUrlParam($url,'action_post',$(this).attr('action')),null, '&submit_action_post='+submit_action_post, true );
                      }
                  }else{
                   
                      load_data_table(replaceUrlParam($url,'action_post',$(this).attr('action')),null, '&submit_action_post='+submit_action_post, true );
                      
                  }
                  return false;
              });

              $(document).on('click','.apply-filter',function(){

                  let date_from = $('#date_from').val(),date_to = $('#date_to').val(), url = window.location.href;

                  url = replaceUrlParam(url, 'date_from', date_from);
                  url = replaceUrlParam(url, 'date_to', date_to);

                  load_data_table(url);

              });

              $('body').on('click','.export-data',function(){
                event.stopPropagation();
                event.preventDefault();
                console.log(url_value(window.location.href));

                let param = '?post-type={!!$type!!}&file_type='+ $(this).data('file');

                let param_url = url_value(window.location.href);

                if( param_url ){ 
                    param += '&'+param_url.join('&'); 
                }

                $('body').append('<iframe src="{!!route('admin.controller',['controller'=>'post-type','method'=>'export-data'])!!}'+param+'" style="display:none"></iframe>');
              });

              $(document).on('click','.ul-fields-groupby li, .ul-fields-show li',function(event){
                event.stopPropagation();
              });
              $(document).on('click','.ul-fields-show input',function(){
                  let fields = [];
                  $(this).closest('.ul-fields-show').find('input:checked').each(function(index,el){
                    fields.push($(el).val());
                  });
                   vn4_ajax({
                        data:{
                            fields:fields,
                            type: $(this).closest('.ul-fields-show').data('type'),
                            change_fields_show:true,
                        },
                        callback:function(data){
                            load_data_table(window.location.href);
                        }
                    });
              });
              $(document).on('click','.ul-fields-groupby input',function(){
                  let fields;
                  $(this).closest('.ul-fields-groupby').find('input').not(this).prop('checked',false);

                  $(this).closest('.ul-fields-groupby').find('input:checked').each(function(index,el){
                    fields = $(el).val();
                  });
                   vn4_ajax({
                        data:{
                            fields:fields,
                            type: $(this).closest('.ul-fields-groupby').data('type'),
                            change_fields_groupby:true,
                        },
                        callback:function(data){
                            load_data_table(window.location.href);
                        }
                    });
              });
              $('body').on('keypress', '.input-search', function(event) {
                  if(event.keyCode == 13){
                      if($(this).val() != ''){
                          load_data_table(replaceUrlParam(window.location.href,'search', $(this).val()));
                      }else{
                           load_data_table(removeParam('search', window.location.href));
                      }
                  }
              });
              
              $(document).on('click','.btn-search_{!!$type!!}',function(){
                  $dataSearch{!!$key_word_post_type!!} = $(this).closest('.form-find').serialize();
                  load_data_table(replaceUrlParam(window.location.href,'page',1));
                 
              });
              $(document).on('click','.find-adv, .form-find .cancel-find',function(event) {
                  $( '.form-find' ).slideToggle( 'slow' );
              });
              $('.table_data_{!!$type!!}').on('click','.paginate_button a',function(event){
                  event.stopPropagation();
                  event.preventDefault();
                  $dataSearch{!!$key_word_post_type!!}['type'] = '{!!$type!!}';
                  var page = parseInt(  $(this).text() );
                  if( !Number.isInteger(page) ){
                      page = url_value($(this).attr('href'),'page');
                  }
                  var url = replaceUrlParam(window.location.href,'page',page);
                  load_data_table(url,function(){
                  
                  });
                  return false;
              });
              $('.change_status').on('click','.paginate_button a',function(event){
                  event.stopPropagation();
                  event.preventDefault();
                  $dataSearch{!!$key_word_post_type!!}['type'] = '{!!$type!!}';
                  var url = replaceUrlParam(window.location.href,'page',$(this).text());
                  load_data_table(url);
                  return false;
              });
              $('.quan-table-wapper').on('change','.show-data-checkall',function(event) {
                      $tick_orNo = $(this).prop('checked');
                      $('.quan-table-wapper .data-show-item, .show-data-checkall').prop('checked',$tick_orNo);
                    
              });
              $('body').on('click','.td_show_group_data_table',function(){
                  $(this).toggleClass('active');
                  $('.item_group[data-group="'+$(this).data('key')+'"]').toggle();
              });
              $('body').on('click', '.btn-apply-action-multi-post', function(event) {
                  if( $('.action-multi-post select:first').val() ){
                      var value = $('.action-multi-post select:first').val();
                      if ( value == 'delete'){
                           var r = confirm('@__('Are you sure you want to delete the selected post')');
                  
                          if (r == true) {
                              
                              load_data_table( window.location.href
                              ,null
                              , '&multi_'+$('.action-multi-post select:first').val()+'='+get_val_checkbox('.data-show-item')  );
                                  
                          }
                      }else{
                           load_data_table( window.location.href
                          ,null
                          , '&multi_'+$('.action-multi-post select:first').val()+'='+get_val_checkbox('.data-show-item')  );
                      }
                     
                  }
              });
              
              $('.quan-table-wapper').on('click','.post-star',function(){
                  vn4_ajax({
                      url: '{!!route('admin.controller',['controller'=>'post-type','method'=>'star'])!!}',
                      data:{
                          id:$(this).closest('tr').data('id'),
                          post_type: '{!!$type!!}',
                      },
                      callback:function(data){
                          load_data_table(window.location.href);
                      }
                  });
              });

              $('.list_status').on('click', '.post-status', function(event) {
                event.stopPropagation();
                event.preventDefault();
                
                  if(!$(this).hasClass('active')){
                      var url = replaceUrlParam(window.location.href,'post_filter',$(this).attr('data'));
                      $this = $(this);
                      load_data_table(url);
                      
                  }
              });
              $('.quan-table-wapper').on('keypress','.go_to_page .number_page',function(event) {
                  if(event.keyCode == 13){
                      if($(this).val() != $(this).attr('data-old')){
                          var url = replaceUrlParam(window.location.href,'page',$(this).val());
                          load_data_table(url);
                      }
                  }
              });

              $('body').on('change','.quan-table-wapper .post-col :input',function(){
                  event.stopPropagation();
                  var r = confirm("Are you sure!");
                  if (r == true) {
                      $.fn.serializeObject = function(){
                          var obj = {};
                          $.each( this.serializeArray(), function(i,o){
                            var n = o.name,
                              v = o.value;
                              obj[n] = obj[n] === undefined ? v
                                : $.isArray( obj[n] ) ? obj[n].concat( v )
                                : [ obj[n], v ];
                          });
                          return obj;
                        };
                        
                      let serialize = $(this).closest('tr.post-data').find(':input').serializeArray();
                      var data = $(this).closest('td.post-col').find(':input').serializeObject();
                      
                      data['name'] = $(this).closest('.post-col').data('name');
                      data['live_edit'] = $(this).closest('tr.post-data').data('id');
                      data['post_type'] = $(this).closest('tr.post-data').attr('tag-type');
                      vn4_ajax({
                          data:data,
                          callback:function(data){
                          }
                      });
                  }
                  
              });

              load_data_table(window.location.href, null, null, true, true);
          });
      </script>
      <?php
      },'script-template',true);
do_action('after_show_data_'.$type); ?>
  </div>
  <div class="clearfix"></div>
</div>