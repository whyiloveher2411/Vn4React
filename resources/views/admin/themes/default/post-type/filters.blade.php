<!DOCTYPE html>

<html lang="{!!App::getLocale()!!}">

  <head>

    <script>

      window.startTime = (new Date).getTime();

    </script>

    <link rel="icon" href="{!!asset('admin/favicon.ico')!!}">

    <?php

    $user = Auth::user();

    $mode =  $user->getMeta('admin_mode',['light-mode','Light Mode']);

    $post_type = $r->get('post_type');

    $admin_object = get_admin_object($post_type);

    $filter_added = setting('filters_post_type_'.$post_type);

    if( $filter_added ){
        $filter_added = json_decode($filter_added,true)??[];
    }else{
        $filter_added = [];
    }

    $valueFlexible = [];

    foreach ($filter_added as $value) {

        $content = [];

        foreach ($value['content'] as $key => $value2) {

            if( isset($admin_object['fields'][$key]) ){

                if( !isset($admin_object['fields'][$key]['view']) ) $admin_object['fields'][$key]['view'] = 'input';

                if( $admin_object['fields'][$key]['view'] === 'number' || $admin_object['fields'][$key]['view'] === 'date' ){

                    $content[] = [
                        'delete'=>0,
                        'type'=>$key,
                        'from'=>$value2['from']??null,
                        'to'=>$value2['to']??null,
                    ];

                }else{
                    $content[] = [
                        'delete'=>0,
                        'type'=>$key,
                        $key=>$value2
                    ];
                }
                
            }
        }



        $valueFlexible[] = [
            'delete'=>0,
            'title'=>$value['title'],
            'content'=>$content
        ];
    }

    $templates = [];

    $argViewNotSearch = ['relationship_onetoone_show'=>1, 'relationship_onetomany_show'=>1, 'relationship_manytomany_show'=>1];
    $argViewChangeToInput = ['repeater'=>1,'flexible'=>1,'editor'=>1];

    $admin_object['fields'] = array_merge(['id'=>['title'=>'ID','view'=>'number'], 'created_at'=>['title'=>'Created At','view'=>'date'],'author'=>['title'=>'Author','view'=>'relationship_onetomany','object'=>'user','type'=>'many_record','data'=>['columns'=>['email']]]], $admin_object['fields']);

    foreach ($admin_object['fields'] as $k => $f) {
        
        if( !isset($f['view']) || !is_string($f['view']) || isset($argViewChangeToInput[$f['view']])  ){
            $f['view'] = 'input';
        }

        if( isset($argViewNotSearch[$f['view']]) ) continue;

        $f['key'] = $f['name'] = $k;
        $f['postDetail'] = null;
        $f['type_post'] = $post_type;

        if( $f['view'] === 'number' ){
            $templates[$k] = [
                'title'=>$f['title'],
                'items'=>[
                    'from'=>['title'=>'From','view'=>'number'],
                    'to'=>['title'=>'To','view'=>'number'],
                ]
            ];

            continue;
        }elseif( $f['view'] === 'date' ){
            $templates[$k] = [
                'title'=>$f['title'],
                'items'=>[
                    'from'=>['title'=>'From','view'=>'date'],
                    'to'=>['title'=>'To','view'=>'date'],
                ]
            ];
            continue;
        }


        if( $f['view'] === 'relationship_onetomany' ){
            $f['view'] = 'relationship_manytomany';
        }

        if( $f['view'] === 'select' ){
            // $f['view'] = 'checkbox';
            $f['multiple'] = true;
        }



        // if( view()->exists( $view = backend_theme('particle.input_field.'.$f['view'].'.search') ) ){
        //     $html[] = '<div class="col-xs-12 flex-item inpnut-'.$k.'" style="margin-bottom: 10px;'.(!$active?'display:none;':'').'"><label>'.$f['title'].'</label><div>'.vn4_view($view,$f).'</div></div>';
        // }else{
        //     $html[] = '<div class="col-xs-12 flex-item inpnut-'.$k.'"" style="margin-bottom: 10px;'.(!$active?'display:none;':'').'"><label>'.$f['title'].'</label><div>'.get_field($f['view'],$f).'</div></div>';
        // }
        
        $templates[$k] = [
            'title'=>$f['title'],
            'items'=>[
                $k => $f
            ]
        ];

    }

    $flexible = get_field('repeater',[
                        'key'=>'filters_added',
                        'value'=>$valueFlexible,
                        'button_label'=>'Add Filter',
                        'class'=>'p-repeater',
                        'sub_fields'=>[
                            'title'=>['title'=>'Title'],
                            'content'=>[
                                'title'=>'Condition',
                                'view'=>'flexible',
                                'layout'=>'block',
                                'dropdown_type'=>'dropdown',
                                'templates'=>$templates
                            ]
                        ]
                    ]);

    do_action('admin_after_open_head'); 

    ?>

    @if( isset($mode[0]) && $mode[0] === 'dark-mode')
    <style type="text/css" id="style-darkmode-default">
      *{
        background: rgb(24, 26, 27) !important;
        border-color:rgb(48, 52, 54) !important;
      }
      svg *{
        fill: transparent !important;
      }
    </style>
    @endif

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    

    <title>{!!strip_tags(vn4_one_or(do_action('title_head'),'Quản trị admin')),' &lsaquo; ',setting('general_site_title','Site title')!!}</title>

     <link href="@asset(vendors/bootstrap/css/bootstrap.min.css)" rel="stylesheet">

     <link href="@asset(admin/css/custom.min.css)" rel="stylesheet">

     <link href="@asset(admin/css/default.css)" rel="stylesheet">

     <link rel="stylesheet" type="text/css" href="{!!asset('admin/css/mode/'.$mode[0].'.css')!!}">

      <meta name="domain" content="{!!url('/')!!}">

      <meta name="url_create_thumbnail" content="{!!route('admin.controller',['controller'=>'image','method'=>'filemanager-create-thumbnail'])!!}">

      <meta class="load-more" data-type="js" content="{!!route('admin.controller',['controller'=>'javascript','method'=>'load-more'])!!}">

      <meta name="url_filemanagerUploadFileDirect" content="{!!route('admin.controller',array_merge(['controller'=>'image','method'=>'filemanager-upload-file-direct'],Route::current()->parameters()))!!}">

      <link href="@asset()vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"><link href="{!!asset('admin/css/nav-top-login.css')!!}" rel="stylesheet">


    <?php 

       do_action('vn4_head');

     ?>

    <style type="text/css">
        .flex-container {
          display: flex;
          flex-wrap: wrap;
        }

        .flex-item {
            background: none #fff;
            border-radius: 5px;
            cursor: pointer;
            -webkit-box-shadow: 0 4px 4px -5px #c8c8c8;
            box-shadow: 0 4px 4px -5px #c8c8c8;
            padding: 10px;
            margin: 5px;
        }
    </style>


  </head>



  <body class="custom_scroll">


    <input type="text" id="laravel-token" value="{!!csrf_token()!!}" hidden>

    <input type="text" id="text-download" value="{{__('Download')}}" hidden>

    <input type="text" id="text-edit" value="{{__('Edit')}}" hidden>

    <input type="text" id="text-remove" value="{{__('Remove')}}" hidden>



    <input type="text" id="is_link_admin_vn4_cms" value="true" hidden>
    


    <div class="container body">

      <div class="main_container">


          <form id="form">
          <div class="right_col" style="display: flex;flex-wrap: wrap;margin: 0;"  role="main">
                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <div class="col-xs-12">

                </div>
              <div class="col-xs-12">
                    <h2>Filters</h2>
                    {!!$flexible!!}

                    <div style="width: 100%;display: flex;margin: 5px;"> <span class="vn4-btn">Cancel</span><span class="vn4-btn vn4-btn-blue submit_form" style="margin-left:10px;">Apply Filters</span> </div>

              </div>

            <div class="clearfix"></div>
          </div>
          </form>


        </div>

    </div>






    <div class="popup-loadding">

        

        <div class="content-warper">

            <img data-src="{!!asset('/admin/images/image-loading-data-1.svg')!!}">

            <p class="content">

              .... <span>@__('Loading')</span> ...

            </p>

        </div>

    </div>



    <div class="vn4-message">

        <span class="hide_message"><i class="fa fa-times" aria-hidden="true"></i></span>

      <h4></h4>

    </div>



    <div class="popup-fixed">

        <div class="popup-warper">

            <div class="popup-header">

              <a href="#" class="a-poupup-title">

                <span class="popup-title"></span>

              </a>

               <span class="icon-close"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></span>



            </div>

            <div class="popup-content" style="margin-right: 40px;padding-right: 0;overflow:hidden;">

               

            </div>

            <div class="popup-footer">

                <span class="vn4-btn">Cancel</span>

                <span class="vn4-btn vn4-btn-blue">Create</span>

            </div>

        </div>

    </div>

    

    <script src="@asset()vendors/jquery/jquery.min.js?v=1"></script>

    <script src="@asset()vendors/bootstrap/js/bootstrap.min.js?v=1"></script>

    <script src="@asset()admin/js/main.js?v=1"></script>

    <?php do_action('vn4_footer'); ?>

    <script type="text/javascript">
        $(window).load(function(){
            $('input[name="fields[]"]').on('click',function(){
                if( $(this).prop('checked') ){
                    $('.inpnut-'+$(this).val()).show();
                }else{
                    $('.inpnut-'+$(this).val()).hide();
                }
            });

            $('.submit_form').on('click',function(){
                // let input = $('#form').serializeArray(),data = {};

                // $.each(input, function() {
                //     data[this.name] = this.value;
                // });

                // console.log(data);
                $.ajax({
                    url: '{!!route('admin.controller',['controller'=>'post-type','method'=>'save-filters','post-type'=>$post_type])!!}',
                    method:'POST',
                    dataType:'Json',
                    data: $('#form').serialize(),
                    success:function(result){
                        if( result.success ){
                            alert('Update Filters Success.');
                        }
                    }
                });
            });
        });
    </script>
    
    @if( isset($mode[0]) && $mode[0] === 'dark-mode')

    <script src="@asset()admin/js/darkreader.js"></script>
    <script>
      $(window).load(function(){
        if ($(".darkreader")[0]){
             console.log("Darkreader Extension detected");
        } else {
            setTimeout(function() {
               DarkReader.setFetchMethod('GET');
               DarkReader.enable({
                  brightness: 100,
                  contrast: 100,
                  sepia: 0
               });

               $('#style-darkmode-default').remove();
             }, 10);
        }
      });
    </script>
    @endif


  </body>

</html>
