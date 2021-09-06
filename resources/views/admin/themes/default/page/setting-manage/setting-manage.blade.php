@extends(backend_theme('master'))
@section('content')
<?php 
 title_head( __('Settings') );

  $plugins = plugins();

  foreach ($plugins as $plugin) {

    if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/setting.php')) ){
      include $file;
    }

  }

  $theme_name = theme_name();

  if( file_exists($file = cms_path('resource','views/themes/'.$theme_name.'/inc/setting.php')) ){
      include $file;
  }

?>

<style type="text/css">
  .settings{
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
    
  }
  .settings .setting-item{
    display: flex;
    padding: 10px;
    align-items: center;
  }
  .setting-item .item-warper{
    display: flex;
    width: 100%;
    padding: 10px;
    height: 100%;
    align-items: center;
    background: white;
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
  }
  .settings .setting-item:hover .item-warper{
    background: #ebedf0;
  }
  .setting-item img{
    box-shadow: none;
  }

  .setting-item .img{
    text-align: center;
    width: 49px;
    overflow: hidden;

  }
  .setting-item .item-warper>a{
    color: black;
  }

  .setting-item .img>*{
    font-size: 34px;
    width: 49px;
    padding: 5px 10px 5px 5px;
    display: inline-block;
  }
  .setting-item>a{
    display: flex;
    color: inherit;
  }

  .setting-item .content{
    padding: 5px;
  }
  .setting-item .title{
    font-weight: bold;
  }
  .setting-item p{
    margin:0;
    color: black;
  }
</style>
    
    <?php 
        $settings = [
            ['title'=>'Settings','icon'=>'<i class="fa fa-cog"></i>','description'=>'General settings for the whole website',
              'submenu'=>[
                ['title'=>'Setting','link'=>route('admin.page','setting')],
                ['title'=>'Environment','link'=>route('admin.page','environment')],
              ]
            ],
            ['title'=>'Cache Management','icon'=>'<i class="fa fa-database"></i>',  'link'=>route('admin.page','cache-management'),'description'=>'Capacity and tools to clear the cache'],
            ['title'=>'Plugin','icon'=>'<svg xmlns="http://www.w3.org/2000/svg" height="64" viewBox="0 0 24 24" width="64"><path d="M0 0h24v24H0z" fill="none"/><path style="" d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/></svg>',  'link'=>route('admin.page',['page'=>'plugin']),'description'=>'Plugins are currently available and used on the website'],
            ['title'=>'Tool','icon'=>'<i class="fa fa-wrench"></i>',  'link'=>route('admin.page',['page'=>'tool-genaral']),'description'=>'Tools to assist in the development and operation process'],
            ['title'=>'Appearance','icon'=>'<i class="fa fa-paint-brush"></i>', 'description'=>'Manage all the settings related to the front-end interface of the website',
              'submenu'=>[
                ['title'=>'Theme','link'=>route('admin.page',['page'=>'appearance-theme'])],
                ['title'=>'Widget','link'=>route('admin.page',['page'=>'appearance-widget'])],
                ['title'=>'Menu','link'=>route('admin.page',['page'=>'appearance-menu'])],
                ['title'=>'Theme Options','link'=>route('admin.page',['page'=>'theme-options'])],
              ]
            ],
            ['title'=>'Mail','icon'=>'<i class="fa fa-envelope"></i>',  'link'=>route('admin.page',['page'=>'mail-templates']),'description'=>'Set up and edit email templates that websites use'],
            ['title'=>'Users','icon'=>'<i class="fa fa-user"></i>','description'=>'Admin account list as well as the permissions of each account',
              'submenu'=>[
                ['title'=>'Users','link'=>route('admin.show_data',['type'=>'user'])],
                ['title'=>'Profile','link'=>route('admin.page',['page'=>'profile'])],
                ['title'=>'User Role Editor','link'=>route('admin.page',['page'=>'user-role-editor'])],
              ]
            ],
            ['title'=>'File','icon'=>'<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style="padding: 0 12px 0 0px;max-width: initial;transform: rotate(45deg);
    transform-origin: center;width: 57px;height: 57px;"><path d="M0 0h24v24H0z" fill="none" data-darkreader-inline-fill="" style="--darkreader-inline-fill:none;"></path><path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z"></path></svg>',  'link'=>route('admin.page',['page'=>'media']),'description'=>'Upload images, videos, and documents'],
            ['title'=>'Log','icon'=>'<i class="fa fa-file-text"></i>',  'link'=>route('admin.page','log'),'description'=>'Management of log files recorded during site operation and development'],
        ];

      $settings = apply_filter('settings_link',$settings);
     ?>
<div class="settings" >
     @foreach($settings as $s)
    <div class="setting-item col-md-4 col-sm-6 ">
        <div class="item-warper">
          <?php 

              if( isset($s['submenu']) ){
                $link = reset($s['submenu'])['link'];
              }else{
                $link = $s['link'];
              }

              if( isset($s['popup']) && $s['popup'] ) {
                $link = '<a href="#" data-iframe="'.$link.'" data-popup="1" data-title="'.$s['title'].'">';
              }else{
                $link = '<a href="'.$link.'">';
              }
           ?>
         
            {!!$link!!}
            <div class="img">
                {!!$s['icon']!!}
            </div>
            </a>
            <div class="content">
              {!!$link!!}
              <p class="title">{!!$s['title']!!}</p>
              <p>{!!$s['description']!!}</p>
              </a>

              <?php  
                  if( isset($s['submenu']) ){
                    $links = [];
                    foreach ($s['submenu'] as $v) {

                      if( isset($v['popup']) && $v['popup'] ){
                        $links[] = '<a href="#" data-popup="1" data-title="'.$v['title'].'" data-iframe="'.$v['link'].'">'.$v['title'].'</a>';
                      }else{
                        $links[] = '<a href="'.$v['link'].'">'.$v['title'].'</a>';
                      }
                    }

                    echo '<p>'.implode(', ', $links).'</p>';
                  }
               ?>

            </div>
          </div>
    </div>
    @endforeach
</div>
@stop
