<?php 
  $theme_name = theme_name();
 ?>
 <div>
 @if(file_exists(cms_path('resource').'/views/themes/'.$theme_name.'/post-type/'.$type_post) || isset($admin_object['template']) )

<?php 
  $template = $postDetail && $postDetail->template?$postDetail->template:'';

  if( !isset($admin_object['template']) ){
    $file_page = glob(cms_path('resource').'/views/themes/'.$theme_name.'/post-type/'.$type_post.'/*.blade.php');
  }else{
    $file_page = glob( cms_path('resource').'/views/'. str_replace('.', '/', $admin_object['template']).'/*.blade.php');
  }

  sort($file_page);
 ?>

@if( isset($file_page[0]) )
<label for="attributes_template">Template
  <select name="attributes_template" class="form-control" id="attributes_template">

       @foreach($file_page as $page)
       
          <?php 

              $v = basename($page,'.blade.php');

              $name = $v;

              $name = ucwords(preg_replace('/-/', ' ', str_slug($name)));
              preg_match( '|Template Name:(.*)$|mi', file_get_contents( $page ), $header );

              if( isset($header[1]) ){
                  $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
              }

           ?>
           <option @if($v === $template) selected @endif value="{!!$v!!}">{!!$name!!}</option>

       @endforeach
  </select>
</label>
<br>
@endif

 @endif
 <label>Order
  <input type="number" class="form-control" style="width:100px;" name="attributes_order" value="{!!$postDetail && $postDetail->order?$postDetail->order:0!!}">
 </label>
 </div>
 