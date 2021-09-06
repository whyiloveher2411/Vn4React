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
    title_head( __('Static Info') );

    $user = Auth::user();

    $edit = Request::get('edit');
   ?>
</style>
<form class="form-horizontal form-label-left" method="POST">
  <input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  <div class="row">
    <div class="col-xs-12">
      <div class="row">
      <div class="col-sm-2">
        <h3 class="title">@__('Files')</h3>

        <?php 

            function scandir_info($address_dir, $except = null){

                $list_file = scandir($address_dir);

                $result = ['folder'=>[],'file'=>[]];

                foreach ($list_file as $file) {

                    if( $file !== '.' && $file !== '..' && $except !== $file ){
                      $info = pathinfo($file);

                      if( isset($info['extension']) && $info['extension'] === 'php' &&  substr($info['basename'], -10) === '.blade.php' ){
                        $result['file'][] = ['name'=>substr($info['basename'], 0, -10)];
                      }elseif ( !isset($info['extension']) ){
                        $child = scandir_info($address_dir.'/'.$info['basename']);
                        $result['folder'][] = ['name'=>$file, 'child'=>$child];
                      }
                    }
                }

                return $result;

            }

            function show_dir($list, $dir = '',$edit){
              $str = '';
              foreach ($list['folder'] as $f) {
                $str .= '<li class="folder '.( strpos($edit, $dir.'.'.$f['name']) === 0 ?'active':'').'"><span>'.$f['name'].'</span><ul>'.show_dir($f['child'],$dir.'.'.$f['name'],$edit).'</ul></li>';
              }
              foreach ($list['file'] as $f) {
                $str .= '<li><span class="file_detail '.( $dir.'.'.$f['name'] === $edit ?'active':'').'"  data-value="'.$dir.'.'.$f['name'].'">'.$f['name'].'</span></li>';
              }

              return $str;
            }

            $theme_name = theme_name();
            $dir_info = scandir_info(cms_path('resource','views/themes/'.$theme_name),'public');

         ?>

          <ul class="tree-folder">
            <li class="root">
              Root 
            </li>
            {!!show_dir($dir_info,'',$edit)!!}
          </ul>



      </div>
      <div class="col-sm-7">
        <form method="POST">
          <input type="hidden" name="_token" value="{!!csrf_token()!!}">
          <h3 class="title">@__('Content')</h3>
          <?php 

              $file_detail = str_replace('.', '/', trim($edit,'.')).'.blade.php';

              if( file_exists($path_name = cms_path('resource').'/views/themes/'.$theme_name.'/'.$file_detail ) ){

                $pattern = '/\{(?:[^{}]|(?R))*\}/x';

                // include __DIR__.'/variable.php';

                  $content = file_get_contents($path_name);

                  $content = preg_replace(['/[\/\*\r\n\t]/',"[\']"], ['','"'], $content);

                  preg_match_all($pattern, $content, $matches);
                    
                  if( isset($matches[0][0]) ){

                    $dataTemplate = json_decode($matches[0][0],true);

                    if( isset($dataTemplate['config']) ){
                      ?>

                      @foreach($dataTemplate['config'] as $key => $field)
                      <div class="form-group form-field form-{!!$key!!}">
                        <label class="label-input" for="{!!$key!!}"> {!!$field['title']!!} @if(isset($field['note_image'])) <a href="{!!$field['note_image']!!}" onclick="return !window.open(this.href, 'Image', 'width=640,height=580')"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> @endif
                          </label>
                          <?php 
                            if( !isset($field['view']) ) $field['view'] = 'input';
                            $field['key'] =  $key;
                            $field['value'] = '';
                          ?>
                          {!!get_field($field['view'], $field)!!}
                      </div>
                      @endforeach
                      <?php
                    }
                  }

              }
           ?>
          <p class="note"><button type="submit" name="save_change" class="vn4-btn vn4-btn-blue"> @__('Update')</button></p>
        </form>
      </div>
      </div>
      

    </div>
    
    
  </div>
</form>
  
@stop

@section('js')
  
  <script>
    $('.btn-create-password').click(function(event) {
      var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz!@#$%^&*()_+<>?~";
      var string_length = 24;
      var randomstring = '';
      for (var i=0; i<string_length; i++) {
          var rnum = Math.floor(Math.random() * chars.length);
          randomstring += chars.substring(rnum,rnum+1);
      }

      $('#text_password').val(randomstring);
    });

    $('.folder').click(function(event){
      event.stopPropagation();
      $(this).toggleClass('active');
    });

    $('.file_detail').click(function(){
      event.stopPropagation();
      window.location.href = '?edit='+$(this).data('value');
    });
  </script>

@stop

