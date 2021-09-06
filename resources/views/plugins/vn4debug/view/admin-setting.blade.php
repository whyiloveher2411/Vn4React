@extends(backend_theme('master'))

@section('content')
<style>
  .tab-content .control-label{
    text-align: left;
  }
  .template, .template option{
    text-transform: capitalize;
  }
 <?php 
    $edit_permission = check_permission('plugin_edit_debug_error');
 ?>

</style>
<form class="form-horizontal form-label-left" method="POST">
<input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  <div class="">
    <div class="row">
      <div class="col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Debug Plugin Setting</h2>
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

              <?php $tag = Request::get('tag','general') ?>
             <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-12">
                  <p>All related errors are presented correctly</p>
                  <hr>
                  <div class="form-group">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Debug backend
                      <br>
                    </label>
                    <?php $debug_backend = isset($general['debug_backend'])?$general['debug_backend']:0; ?>

                      

                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="checkbox ckb">
                            <label>
                              <input type="checkbox" name="debug_backend" {!!$debug_backend==1?'checked':''!!} value="1"> Activate
                            </label>
                          </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Debug frontend
                      <br>
                    </label>
                    <?php $debug_frontend = isset($general['debug_frontend'])?$general['debug_frontend']:0; ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="checkbox ckb">
                            <label>
                              <input type="checkbox" name="debug_frontend" {!!$debug_frontend==1?'checked':''!!} value="1"> Activate
                            </label>
                          </div>
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Chuỗi debug</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                       <?php $show_debug_message = isset($general['show_debug_message'])?$general['show_debug_message']:''; ?>
                      <input type="text" class="form-control"  name="show_debug_message" value="{{$show_debug_message}}">
                      <p>If you want to show errors when debugging is not enabled, add this string after the Ex url: http://exampll.com/?active_debug={string}</p>
                    </div>
                  </div>
                  
                  <br>
                  <p>Displaying query lists, times, and totals helps you review your site's performance</p>
                  <hr>
                   <div class="form-group">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Show query backend
                      <br>
                    </label>
                    <?php $show_query_backend = isset($general['show_query_backend'])?$general['show_query_backend']:0; ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="checkbox ckb">
                            <label>
                              <input type="checkbox" name="show_query_backend" {!!$show_query_backend==1?'checked':''!!} value="1"> Activate
                            </label>
                          </div>
                    </div>

                  </div>

                  <div class="form-group">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Show query frontend
                      <br>
                    </label>
                    <?php $show_query_frontend = isset($general['show_query_frontend'])?$general['show_query_frontend']:0; ?>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="checkbox ckb">
                            <label>
                              <input type="checkbox" name="show_query_frontend" {!!$show_query_frontend==1?'checked':''!!} value="1"> Activate
                            </label>
                          </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Chuỗi query</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                       <?php $show_query_message = isset($general['show_query_message'])?$general['show_query_message']:''; ?>
                      <input type="text" class="form-control"  name="show_query_message" value="{{$show_query_message}}">
                      <p>If you want to show the query when the query is not enabled, add this string after the Ex url: http://exampll.com/?active_query={string}</p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>

         @if($edit_permission)
        <button type="submit" class="vn4-btn vn4-btn-blue">@__('Save changes')</button>
        @endif
        
      </div>
    </div>
  </div>
</form>
  
@stop

@section('js')
@if($tag == 'design')
  <script>

    $(window).load(function(){
      $(document).on('click','.restore_fields',function(event) {
        var delete_fields = '{!!$delete_fields!!}';

        delete_fields = delete_fields.split(',');

        var temp = delete_fields.indexOf($(this).attr('data'));
        if(  temp != -1 ) {
          delete delete_fields[temp];
        }

        delete_fields = delete_fields.toString();

        delete_fields = delete_fields.substring(0,delete_fields.length - 1);

        window.location.href = replaceUrlParam(window.location.href,'delete_fields',delete_fields);
      });
      $(document).on('click','.delete_fields',function(event) {

        var delete_fields = '{!!$delete_fields!!}';

        delete_fields = delete_fields.split(',');

        if( delete_fields.indexOf($(this).attr('data')) == -1 ) {
          delete_fields.push($(this).attr('data')); 
        }
        delete_fields.toString();

        window.location.href = replaceUrlParam(window.location.href,'delete_fields',delete_fields);
      });
      $(document).on('click','.add_fields',function(event) {
        window.location.href = replaceUrlParam(window.location.href,'count_add_fields',{!!$add_fields + 1!!});
      });
      $(document).on('change','select.template',function(event) {
          window.location.href = replaceUrlParam(window.location.href,'template',$(this).val());
      });

    });
  </script>
@endif
@stop