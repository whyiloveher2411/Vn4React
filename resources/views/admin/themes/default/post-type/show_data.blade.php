@extends(backend_theme('master'))

<?php 
    $requetParameter = get_param(['edit_id']);

    if($requetParameter  != ''){
      $requetParameter = '?'.$requetParameter;
    }

    title_head($tag['title']);


    if( check_permission($type.'_create') &&  ( !isset($tag['layout']) 
      || ( (is_string($tag['layout']) && $tag['layout'] === 'create_data') 
      || (is_array($tag['layout']) && array_search('create_data', $tag['layout']) !== false) )) ){

      if( !isset($tag['link_create']) ){
        $link_create = route('admin.create_data',['type'=>$type]).$requetParameter;
      }else{
        $link_create = $tag['link_create'];
      }

      add_action('vn4_heading',function() use ($type, $requetParameter,$tag, $link_create) {
        echo '<a href="'.$link_create.'" class="pull-left vn4-btn btn-create-data"><i class="fa fa-plus" aria-hidden="true"></i> '.__('Add New').'</a>';
      });

    }elseif( isset($tag['route_update']) ){
      add_action('vn4_heading',function() use ($type, $requetParameter,$tag) {
        echo '<a href="'.route($tag['route_update'],['type'=>$type]).$requetParameter.'" class="pull-left vn4-btn btn-create-data"><i class="fa fa-plus" aria-hidden="true"></i> '.__('Add New').'</a>';
      });
    }

?>
@section('content')

<div class="">
  <div class="show_data_warrper">
       <?php admin_data_table($type);?>
  </div>
</div>

@stop

@section('js')

  <?php add_action('vn4_footer',function(){ ?>
     <script>
        $(document).on('click','.create_and_show_data',function(){

          href = window.location.href;
          href = href.replace('show_data', 'create_and_show_data');
          window.location.href = href;

          return false;
        });
    </script>
  <?php
},'show_data_setting_change',true);
?>

@stop


