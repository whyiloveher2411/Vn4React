<?php 

title_head(__('Themes'));

?>



@extends(backend_theme('master'))



@section('content')



<style>

  .img_over_1{

    height: 160px;

    overflow: hidden;

    position: relative;

    border-radius: 3px 3px 0 0;

  }

  .img_over_1 img{

    cursor: pointer;

    object-fit: cover;

    width: 100%;

    height: 100%;

    filter: grayscale(100%);

  }

  .profile_details{

    opacity: .6;

    cursor: pointer;

    z-index: 0;

  }

  .profile_details:hover, .profile_details.active{

    opacity: 1;

  }

  .profile_details:hover .theme-add-new{

    background: white;

  }

  .profile_details:hover .theme-add-title{

      color: #4080ff;

   }

  .profile_details .profile_view{

    padding:0;

    width: 100%;

    height: 214px;

    transition: all .15s ease-in;

    background: transparent;

    border: 1px solid #dddfe2;

  }

  .profile_details .profile_view:hover{

    box-shadow: 0 2px 14px 0 rgba(0, 0, 0, .1);

    transform: scale(1.02);

    transition-timing-function: ease-out;

  }



  .theme-detail p{

    color: #9a9a9a;

  }

  #popup-info-theme .close{

    width: 55px;

    height: 55px;

    padding: 10px 15px;

    position: absolute;

    right: 0;

    top: 0;

    margin: 0;

    border-radius: 0 6px 0 0;

  }

  #popup-info-theme .close:hover{

    background: #ddd;

    border-color: #ccc;

    color: #000;

  }

  .profile_details.active .bottom{

    background: #23282d;

    color: #fff;

    border-radius: 0 0 2px 2px;

  }

  .profile_details:hover img{

     filter: grayscale(0%);

   }

  .profile_details.active img{

    filter: grayscale(0%);

  }

  .profile_details .emphasis .ratings {

    font-size: 13px;

  }

  .profile_details .emphasis .ratings{

    line-height: 33px;

    font-weight: bold;

    text-transform: capitalize;

    overflow: hidden;

    white-space: nowrap;

    text-overflow: ellipsis;

  }

  .profile_details .bottom{

    height: 52px;

  }

  .btn-active-theme{

    position: absolute;

    right: 5px;

    top: 2px;

    display: none;

  }

  .profile_details:hover:not(.active) .btn-active-theme{

    display: block;

  }

 

ul.tree-folder {

  margin: 0px 0px 0px 20px;

  list-style: none;

  line-height: 2em;

  font-family: Arial;

}

ul.tree-folder li {

  font-size: 16px;

  position: relative;

}

li.folder span{

  display: block;

}

li.folder:hover>span{

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

ul.tree-folder li.folder:not(.has-data)>span:after{

    content: '+';

    display: inline-block;

    border: 1px solid #b7b7b7;

    position: absolute;

    margin-left: 10px;

    line-height: 10px;

    margin-top: 7px;

    cursor: pointer;

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

  left:23px;

}

li.folder span{

  margin-left: 50px;

}

.chose1{

  float: left;

  margin: 0 !important;

}

</style>

<div class="">

  <div class="row">



    <?php 

      $list = File::directories(Config::get('view.paths')[0].'/themes/');



      $themeActive = theme_name();

     ?>



    <div class="col-md-12" style="z-index: 0;">

        <div class="x_content" style="max-width: 1000px;margin: 0 auto;">

          <form action="" method="POST">

            <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

            <div class="row">





              <div class="col-md-4 col-sm-4 col-xs-12 profile_details"  data-max-width="800px" data-popup="1" data-iframe="{!!route('admin.controller',['controller'=>'theme','method'=>'create'])!!}" data-title="@__('Create a new theme')">

                  <div class="profile_view theme-add-new" style="display: flex;justify-content: center;padding: 0;text-align: center;align-items: center;">

                    <h3 class="theme-add-title" style="font-size: 18px;line-height: 40px;">

                       <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 70px;display: block;"></i>

                        @__('Add new theme')

                    </h3>

                  </div>

              </div>



              <?php 

              foreach ($list as $value) {

                $folder_theme = explode(DIRECTORY_SEPARATOR, $value);



                $folder_theme = end($folder_theme);



                $fileName = $value.'/info.json';

                $info = [];



                if( file_exists( $fileName ) ){



                  $info = json_decode(File::get($fileName), true);



                }

                ?>



                







                <div class="col-md-4 col-sm-4 col-xs-12 profile_details @if($themeActive === $folder_theme) active @endif">

                  <div class="well profile_view">

                    <div class="img_over_1 load-info-theme" data-theme="{!!$folder_theme!!}">

                      {!! file_exists( cms_path().'themes/'.$folder_theme.'/screenshot.png' ) ? '<img data-src="'.asset('themes/'.$folder_theme.'/screenshot.png').'" class="img-responsive">' : '<img data-src="'.asset('admin/images/no-image-icon.png').'" style="box-shadow: none;width: auto;height: 100%;margin: 0 auto;"  class="img-responsive">' !!}" 

                    </div>

                    <div class="col-xs-12 bottom text-center">

                      <div class="col-xs-12 emphasis">

                        <p class="ratings">

                          {!!$themeActive === $folder_theme?'<strong>Activated:</strong>':''!!} {!!$info['name']??$folder_theme !!} <small style="text-transform: initial;color: rgb(96, 103, 112);font-weight: 100;font-size: 10px;">(v{!!$info['version']??'1.0.0'!!})</small>

                          <button type="submit" name="general_client_theme" value="{!!$folder_theme!!}" class="btn-active-theme pull-right {!!$themeActive === $folder_theme?'':'vn4-btn-blue'!!} vn4-btn ">

                            <i class="fa fa-user"> </i> {!!$themeActive == $folder_theme?'Activated':'Active'!!} 

                          </button>

                        </p>

                      </div>



                    </div>

                  </div>

                </div>



                <?php

              }



              ?>

            </div>

          </form>

        </div>

    </div>



  </div>

</div>



<!-- Modal -->

<form action="" method="POST">

 <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

 <div id="popup-info-theme" class="modal fade" role="dialog" >

  <div class="modal-dialog" style="left: 50%;top:50%;transform: translate(-50%,-50%);margin: 0;max-width:1100px;width:auto;padding:10px;padding-top: 40px;">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><img style="box-shadow: none;" data-src="@asset()admin/images/close-24px.svg"></button>

        <h4 class="modal-title theme-name">#</h4>

      </div>

      <div class="modal-body">

        <div class="col-sm-6 col-xs-12">

          <img class="img-theme" src="#" alt="" class="img-responsive">

        </div>

        <div class="col-sm-6 col-xs-12 theme-detail">

          <p class="name"><span class="theme-name" style="font-size: 33px;color: #000;">#</span> @__('Version'): <span class="version">1.0.2</span></p>

          <p class="author">@__('By') <a class="theme-author" href="#">#</a></p>

          <p class="theme-description" style="color:#797979;">#</p>

          <hr>

          <p class="tags"><strong style="color: #444">@__('Tags'):</strong> <span class="theme-tags">#</span></p>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="modal-footer" style="text-align: center;">





        <button type="submit" name="general_client_theme" value="" class="vn4-active-theme vn4-btn vn4-btn-blue">

          <i class="fa fa-user"> </i> @__('Active') 

        </button> 
        <button type="button" class="vn4-btn vn4-btn-red delete-theme" value=""> <i class="fa fa-trash"> </i> @__('Delete')</button> 
        <button type="button" class="vn4-btn vn4-btn-blue data_sample" value=""> <i class="fa fa-history" aria-hidden="true"></i> @__('Import Data Sample')</button> 
        <button type="button" class="vn4-btn" data-dismiss="modal">@__('Close')</button>

      </div>

    </div>



  </div>

</div>

</form>



@stop





@section('js')

<script>

  jQuery(document).ready(function($) {

    function one_or_two(one, two){

      if( one ){

        return one;

      }



      return two;

    }



    $(document).on('click','#popup-info-theme .delete-theme',function(event) {



     var r = confirm("@__('Are you sure you want to delete this theme?\n\nClick \'Cancel\' to go back, \'OK\' to confirm the delete')");



     if (r == true) {

      var theme = $(this).val();



      vn4_ajax({'type':'POST','show_loading':true,'data':{'theme_delete':theme}});



    }



  });

    $('.data_sample').on('click',function(){
      var r = confirm("@__('Are you sure you want import data sample?\n\nClick \'Cancel\' to go back, \'OK\' to confirm the import')");
      if (r == true) {
        var theme = $(this).val();
        vn4_ajax({'type':'POST','show_loading':'Importing Data','data':{'data_sample':data_sample}});
      }
    });
    $(document).on('click','.load-info-theme',function(event) {



      var theme = $(this).attr('data-theme'),$this = $(this);



      vn4_ajax({

        type:'POST',

        show_loading:true,

        data:{

          get_info_theme:theme

        },

        callback:function(data){

          if(data.info){


            if( data.data_sample ){
              window.data_sample = theme;
              $('.data_sample').show();
            }else{
              window.data_sample = '';
              $('.data_sample').hide();
            }

            $('#popup-info-theme .theme-name').text(one_or_two(data.info.name,theme));

            $('#popup-info-theme .theme-description').text(one_or_two(data.info.description,'#'));

            $('#popup-info-theme .version').text(one_or_two(data.info.version,'#'));

            $('#popup-info-theme .theme-author').text(one_or_two(data.info.author,'#'));

            $('#popup-info-theme .theme-author').attr('href',one_or_two(data.info.author_url,'#'));

            $('#popup-info-theme .theme-tags').text(one_or_two(data.info.tags,'#'));

            $('#popup-info-theme .delete-theme').attr('value',theme);



            $('#popup-info-theme .vn4-active-theme').attr('value',theme);





            $('#popup-info-theme').modal('show');



          }



          if( theme === '{!!$themeActive!!}' ){

            $('#popup-info-theme .delete-theme').hide();

            $('#popup-info-theme .vn4-active-theme').hide();

          }else{

            $('#popup-info-theme .delete-theme').show();

            $('#popup-info-theme .vn4-active-theme').show();

          }



          if( data.img ){

            $('#popup-info-theme .img-theme').attr('src',data.img);

          }else{

            $('#popup-info-theme .img-theme').attr('src','');

          }

        }



      });



    });



  });

</script>

@stop