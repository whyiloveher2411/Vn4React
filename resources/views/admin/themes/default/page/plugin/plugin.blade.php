@extends(backend_theme('master'))
@section('content')
<?php 
   $plugin_status = Request::get('plugin_status','all');
   
   $plugin_status_all = ['all','active','inactive','update'];
   
   $plugin_status = array_search($plugin_status, $plugin_status_all) !== false ? $plugin_status : 'all';
   
   title_head( __('Plugins') );
   
   $strTable2 = '';
   
    $obj->setTable(vn4_tbpf().'setting');
   
   
    $list = File::directories(Config::get('view.paths')[0].'/plugins/');
    sort($list);
   
    $all = 0;
    $active = 0;
    $inactive = 0;
    $update = 0;
    
    $button ='';

     $permission_plugin_action = check_permission('plugin_action');

    $listPlugin = plugins()->keyBy('key_word');

    foreach ($list as $value) {

       $folder_theme = basename($value);
   
       $fileName = $value.'/info.json';
   
       if( !file_exists( $fileName ) ){
   
           continue;
   
       }
   
       ++$all;
   
       $info = json_decode(File::get($fileName));
   
       $isActive = isset($listPlugin[$folder_theme]);
   
       $class = '';
       if($isActive !== false){
          $plugin = $listPlugin[$folder_theme];
         ++$active;
         $class = 'active';
       }else{
          $plugin = null;
          ++$inactive;
       }
   
       if( $plugin_status !== 'all' ){
   
         if( ($isActive && $plugin_status !== 'active') || (!$isActive && $plugin_status !== 'inactive') ){
           continue;
         }
   
       }

      if( $permission_plugin_action ){
             $button =  '<button type="submit" name="plugin" value="'.$folder_theme.'" value="'.$folder_theme.'"  class="vn4-btn '.($isActive?'vn4-btn-blue':'').' ">'.($isActive?__('Activated'):__('Activate')).'</button>';
      }


       $strTable2 .= '<div class="plugin-item '.$class.'" style="z-index:'.(1000 - $all).';">
         <div><small class="author">By <a href="'.$info->author_url.'" target="_blank">'.$info->author.'</a></small><small class="version">(v'.$info->version.')</small><img data-src="'.plugin_asset($folder_theme, 'plugin.png').'"></div>
         <h3>'.$info->name.'</h3>
         <p>'.__p($info->description, $folder_theme).'</p>
         <div class="p-footer">
         <div>
         <a href="https://www.google.com/search?'.http_build_query(['q'=>'vn4cms.com '.$info->name]).'" target="_blank">'.__('Read Docs').'</a>';


         if( $isActive && file_exists($file = $value.'/inc/setting.php') ){

            $GLOBALS['filter']['settings_link'] = [];

            include $file;

            $settings = apply_filter('settings_link',[]);

           

            foreach ($settings as $link) {

                if( isset($link['submenu']) ){

                   $strTable2 .= ' <span class="arrow-right">&#187;</span> <span class="dropdown"><a href="#" data-href="https://www.google.com/search?'.http_build_query(['q'=>'vn4cms.com '.$info->name]).'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" target="_blank">'.__('Settings').'</a>';

                  $strTable2 .= '<ul class="dropdown-menu " role="menu">';

                  foreach ($link['submenu'] as $link2) {
                    $strTable2 .= '<li><a href="'.$link2['link'].'"><label>'.$link2['title'].'</label></a></li>';
                  }

                  $strTable2 .= '</ul></span>';

                }else{
                  $strTable2 .= ' <span class="arrow-right">&#187;</span> <a href="'.$link['link'].'">'.$link['title'].'</a>';
                }
            }

          }

        $strTable2 .= '</div>';
        
        $strTable2 .=  $button;

        $strTable2 .= '</div></div>';
   }
   
   ?>
<style>
   .plugins{
   margin: 0 auto;
   display: grid;
   justify-content: center;
   flex-wrap: wrap;
   grid-template-columns: 1fr 1fr 1fr;
   margin-bottom: 20px;
   justify-content: space-around;
   width: 100%;
   }
   .plugin-item{
   text-align: center;
   padding-top: 22px;
   background: #e9ebee;
   border-radius: 3px;
    box-shadow: 0 1px 2px 0 rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
   font-family: -apple-system, BlinkMacSystemFont, Roboto, Arial, Helvetica, sans-serif;
   margin-bottom: 16px;
   display: flex;
   flex-direction: column;
   height: 300px;
   justify-content: space-between;
   position: relative;
   transition: all .15s ease-in;
   width: 95%;
   opacity: .6;
   }
   .plugin-item.active{
    background: white;
   }
   .plugin-add{
    cursor: pointer;
   }
  
    .plugin-item small{
      position: absolute;
      left: 16px;
      top: 10px;
      font-size: 10px;
      color: rgb(96, 103, 112);
      font-weight: bold;
      display: none;
    }
    .plugin-item small.version {
        right: 16px;
        left: auto;
    }

    .plugin-item small.author{

    }
    
   .plugin-item img{
     box-shadow: none;
     height: 128px;
     filter: grayscale(100%);
   }
   .plugin-item.active img{
     filter: grayscale(0%);
   }
   .plugin-item.active, .plugin-item:hover{
    opacity: 1;
    background: white;
   }
    .plugin-item:hover{
      box-shadow: 0 2px 14px 0 rgba(0, 0, 0, .1);
      transform: scale(1.02);
      transition-timing-function: ease-out;
      z-index: 1;
     }
     .plugin-item:hover .plugin-add-title{
      color: #4080ff;
     }
     .plugin-item:hover small{
      display: block;
     }
     .plugin-item:hover img{
        filter: grayscale(0%);
     }


   .plugin-item h3{
   font-family: Arial, sans-serif;
   font-size: 14px;
   line-height: 18px;
   letter-spacing: normal;
   font-weight: bold;
   overflow-wrap: normal;
   text-align: center;
   color: rgb(29, 33, 41);
   }
   .plugin-item p{
   font-family: Arial, sans-serif;
   font-size: 12px;
   line-height: 16px;
   letter-spacing: normal;
   overflow-wrap: normal;
   text-align: center;
   padding: 0 15px;
   width: 100%;
   display: -webkit-box;
   text-overflow: ellipsis;
   overflow: hidden;
   -webkit-line-clamp: 3;
   -webkit-box-orient: vertical;
   color: rgb(96, 103, 112);
   height: 48px;
   }
   .plugin-item a{
    line-height: 23px;
   }
   .plugin-item .p-footer{
   align-items: center;
   border-top: 1px solid #dadde1;
   display: flex;
   font-size: 12px;
   height: 48px;
   justify-content: space-between;
   margin-left: 16px;
   margin-right: 16px;
   }
   .p-footer .arrow-right{
      display: inline-block;
      height: 23px;
      vertical-align: middle;
   }
   .img_over_1{
   margin: -1px -1px 0 -1px;
   height: 180px;
   overflow: hidden;
   position: relative;
   }
   .img_over_1 img{
   position: absolute;
   top:50%;
   left: 50%;
   -webkit-transform: translate(-50%,-50%);
   -moz-transform: translate(-50%,-50%);
   -ms-transform: translate(-50%,-50%);
   -o-transform: translate(-50%,-50%);
   transform: translate(-50%,-50%);;
   }
   .profile_details .profile_view{
   padding:0;
   width: 100%;
   }
   .list_status{
    padding: 0;
    margin-bottom: 10px;
   }
   .page-title .title_right .pull-right, .list_status .post-status{
   margin: 0;
   }
   .list_status .post-status:not(.active){
   background-color: buttonface;
   color: black;
   font-weight: normal;
   }
   .page-title .title_right, .page-title .title_left{
   width: auto;
   }
   .notify-plugin{
   padding: 10px;
   border-left: 5px solid;
   background: #fff8e5;
   margin-bottom: 10px;
   color: black;
   }
   .tr_notify td{
   border-top: none !important;
   padding: 0;
   }
</style>
<div class="">
   <div class="row">
     
      <div class="col-md-12">

         <div class="x_content" style="max-width: 1000px;margin: 0 auto;">
            <form action="" method="POST">
               <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

               <div class="title_left list_status btn-group">
                   <a class="btn btn-sm post-status @if( $plugin_status === 'all') btn-primary active @endif" href="?plugin_status=all"> @__('All') ({!!$all!!})</a>

                   @if($active)
                   <a class="btn btn-sm post-status @if( $plugin_status === 'active') btn-primary active @endif" type="button" href="?plugin_status=active" > @__('Active') ({!!$active!!})</a>
                   @endif

                   @if( $inactive )
                   <a class="btn btn-sm post-status @if( $plugin_status === 'inactive') btn-primary active @endif" type="button" href="?plugin_status=inactive" > @__('Inactive') ({!!$inactive!!})</a>
                   @endif

                   @if( $update )
                   <a class="btn btn-sm post-status @if( $plugin_status === 'update') btn-primary active @endif" type="button" href="?plugin_status=update" > @__('Update Available') ({!!$update!!})</a>
                   @endif

                </div>


               <div class="plugins">

                  <div class="plugin-item plugin-add " style="display: flex;justify-content: center;padding: 0;align-items: center;" data-max-width="800px" data-popup="1" data-iframe="{!!route('admin.controller',['controller'=>'plugin','method'=>'create'])!!}" data-title="@__('Create a new plugin')">
                      <h3 class="plugin-add-title" style="font-size: 18px;line-height: 40px;">
                         <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 70px;display: block;"></i>
                          @__('Add new plugin')
                      </h3>
                  </div>

                  {!!$strTable2!!}
               </div>

               
            </form>
         </div>
      </div>
   </div>
</div>
<!-- <div class="data-iframe" data-url="{!!route('admin.page',['page'=>'tool-genaral','action'=>'check-plugin'])!!}"></div> -->
@stop
@section('js')
<script type="text/javascript">
   function show_message_plugin(data){
   
     for (var i = 0; i < data.length; i++) {
       if( data[i].product && data[i].message_plugin ){
   
           $('.td_notify[data-contains="'+data[i].product+'"]').closest('tr').css({'display':'table-row'});
           $('.td_notify[data-contains="'+data[i].product+'"]').html( $('.td_notify[data-contains="'+data[i].product+'"]').html() + '<div class="notify-plugin" style="border-left-color:'+data[i].color+' !important;">'+data[i].message_plugin+'</div>' );
   
       }     
     }
   }
</script>
@stop