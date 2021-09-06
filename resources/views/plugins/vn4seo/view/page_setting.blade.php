@extends(backend_theme('master'))

@section('content')
<style>
  
ul.tree-folder {
  margin: 0px 0px 0px 20px;
  list-style: none;
  line-height: 2em;
  font-family: Arial;
}
ul.tree-folder li {
  font-size: 16px;
  position: relative;
  cursor: pointer;
}
li.folder span{
  display: block;
}
li.folder:hover:first-child>span{
  background: #dedede;
  cursor: pointer;
}
ul.tree-folder li:before {
  position: absolute;
  left: -15px;
  top: 0px;
  content: '';
  display: block;
  border-left: 1px solid #000;
  height: 1em;
  border-bottom: 1px solid #000;
  width: 10px;
}
ul.tree-folder li:after {
  position: absolute;
  left: -15px;
  bottom: -7px;
  content: '';
  display: block;
  border-left: 1px solid #000;
  height: 100%;
}
ul.tree-folder ul{
  display: none;
}
ul.tree-folder li.active>ul{
  display: block;
}
.file_detail.active{
  text-decoration: underline;
  color: blue;
}
ul.tree-folder li.root {
  margin: 0px 0px 0px -20px;
}
ul.tree-folder li.root:before {
  display: none;
}
ul.tree-folder li.root:after {
  display: none;
}
ul.tree-folder li:last-child:after {
  display: none;
}
ul.tree-folder ul{
  margin-left: 20px;
}
li.folder>span:before{
  content: "";
  display: inline-block;
  background: url("{!!asset('admin/images/folder.png')!!}") no-repeat center center;
  background-size: cover;
  width: 20px;
  height: 20px;
  position: absolute;
  left:-2px;
}
li.folder>span{
  margin-left: 21px;
}
 <?php 
    title_head( __p('Page',$plugin->key_word) );

    $user = Auth::user();


   ?>
</style>
<form class="form-horizontal form-label-left" method="POST">
  <input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  <div class="row">
    <div class="col-xs-12">
      <div class="row">
      <div class="col-sm-2">

        <?php 

            function scandir_info($address_dir){

                if( !file_exists($address_dir) ) return [];
                
                $list_file = scandir($address_dir);

                $result = [];

                foreach ($list_file as $file) {

                    if( $file !== '.' && $file !== '..'){
                      $info = pathinfo($file);

                      if( isset($info['extension']) && $info['extension'] === 'php' &&  substr($info['basename'], -10) === '.blade.php' ){
                        $result[] = substr($info['basename'], 0, -10);
                      }
                    }
                }

                return $result;

            }

            function show_dir($list, $edit){
              $str = '';
              foreach ($list as $f) {
                $str .= '<li><span class="file_detail '.( $f === $edit ?'active':'').'"  data-value="'.$f.'">'.$f.'</span> <a target="_blank" href="'.route('page',$f).'"><i class="fa fa-link" aria-hidden="true"></i></a></li>';
              }

              return $str;
            }

            $theme_name = theme_name();
            $dir_info = scandir_info(cms_path('resource','views/themes/'.$theme_name.'/page'));
            $edit = Request::get('edit','');

            if( array_search($edit, $dir_info) === false ){

              if( isset($dir_info[0]) ){
                $edit = $dir_info[0];
              }else{
                $edit = '';
              }
            }

         ?>

          <ul class="tree-folder">
            {!!show_dir($dir_info,$edit)!!}
          </ul>



      </div>
      <div class="col-sm-7">
        <form method="POST">
          <input type="hidden" name="_token" value="{!!csrf_token()!!}">
          <input type="hidden" name="file_page" value="{!!$edit!!}">
          <?php 
            $value = do_action('admin.page.theme-options.get-value',$edit.'_page');
            // dd(theme_options($edit.'_page'));
              $data = [
                'plugin_vn4seo_google_title'=>isset($value['plugin_vn4seo_google_title'])?$value['plugin_vn4seo_google_title']:title_head(),
                'plugin_vn4seo_google_description'=>isset($value['plugin_vn4seo_google_description'])?$value['plugin_vn4seo_google_description']:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam dolor, natus! Tempora facilis quis magni consequatur? Adipisci porro debitis placeat numquam mollitia quos quibusdam, id inventore magnam. Minima, tempora, beatae.',
                'plugin_vn4seo_focus_keyword'=>isset($value['plugin_vn4seo_focus_keyword'])?$value['plugin_vn4seo_focus_keyword']:'',
                'link'=>route('page',$edit),
                'plugin_vn4seo_facebook_title'=>isset($value['plugin_vn4seo_facebook_title'])?$value['plugin_vn4seo_facebook_title']:'',
                'plugin_vn4seo_facebook_description'=>isset($value['plugin_vn4seo_facebook_description'])?$value['plugin_vn4seo_facebook_description']:'',
                'plugin_vn4seo_facebook_image'=>isset($value['plugin_vn4seo_facebook_image'])?$value['plugin_vn4seo_facebook_image']:'',
                'plugin_vn4seo_twitter_title'=>isset($value['plugin_vn4seo_twitter_title'])?$value['plugin_vn4seo_twitter_title']:'',
                'plugin_vn4seo_twitter_description'=>isset($value['plugin_vn4seo_twitter_description'])?$value['plugin_vn4seo_twitter_description']:'',
                'plugin_vn4seo_twitter_image'=>isset($value['plugin_vn4seo_twitter_image'])?$value['plugin_vn4seo_twitter_image']:'',
                'plugin_vn4seo_canonical_url'=>$value['plugin_vn4seo_canonical_url']??'',
              ];

              echo view_plugin($plugin,'view.post-type.master', ['plugin_keyword'=>$plugin->key_word,'post'=>null,'data'=>$data]);
           ?>
        </form>
      </div>
      <div class="col-sm-3">
        <?php 
        do_action('admin.page.theme-options');
        
        vn4_panel('Action',function(){
          echo '<button class="vn4-btn vn4-btn-blue">Update</button>';
        });
       ?>
      </div>
      </div>
      

    </div>
    
    
  </div>
</form>
  
@stop

@section('js')
  
  <script>
     $(document).on('click','.folder',function(event){
      event.stopPropagation();
      $(this).toggleClass('active');
    });

    $(document).on('click','.file_detail',function(){
      event.stopPropagation();
      window.location.href = '?edit='+$(this).data('value');
    });
  </script>

@stop

