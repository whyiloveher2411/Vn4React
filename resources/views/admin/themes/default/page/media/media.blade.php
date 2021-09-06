 @extends(backend_theme('master'))
 @section('css')
  <style>
    .x_content{
      padding: 0;
    }
  </style>
 @stop
@section('content')
<?php title_head( __('Media Library')); ?>
<style type="text/css">
  .x_content .data-iframe iframe{
    height: 100%;
    overflow: auto;
  }
</style>
<div class="">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>@__('Media Library')<small class="note">@__('Do not delete, rename, move files will affect the post currently using the file')</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

              <div class="data-iframe" style="height: 500px;" data-url="{!!asset('')!!}/filemanager/filemanager/dialog.php"></div>

          </div>
        </div>
      </div>
  </div>
</div>

@stop
