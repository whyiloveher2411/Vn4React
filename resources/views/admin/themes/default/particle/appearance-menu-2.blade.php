<!-- 
	{
		"permission_row":true,
		"row":[
			{
				"title":"Client",
				"permission":{
					"appearance_menu_client_create":{
						"title":"Create"
					},
					"appearance_menu_client_edit":{
						"title":"Edit"
					},
					"appearance_menu_client_delete":{
						"title":"Delete"
					},
					"appearance_menu_client_view":{
						"title":"View"
					}
					
				}	
			},
			{
				"title":"Admin",
				"permission":{
					
					"appearance_menu_admin_create":{
						"title":"Create"
					},
					"appearance_menu_admin_edit":{
						"title":"Edit"
					},
					"appearance_menu_admin_delete":{
						"title":"Delete"
					},
					"appearance_menu_admin_view":{
						"title":"View"
					}
					
				}	
			}
		]
	}
 -->

 @if(!check_permission('appearance-menu_view'))
	{!!dd('Bạn không có quyền xem quản lý menu')!!}
 @endif

@extends('admin.master')

@section('css')
	<style type="text/css">
		ul li{
			list-style: none;
			padding: 0;
			margin: 0;
		}
		ul{
			padding: 0;
			margin: 0;
		}
        /**
         * Nestable
         */

        .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }

        .dd-item,
        .dd-empty,
        .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
		.dd-dragel .dd-handle {margin: -15px 0;}
		.dd-dragel{padding:10px 0 0px 10px;margin: -10px 0 0 -5px;}
		.dd-dragel .menu_item_info{margin-bottom: 5px}
        .dd-handle { display: block;  margin: 5px 0; padding: 5px 80px 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:         linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
                    border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }

        .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
        .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
        .dd-item > button[data-action="collapse"]:before { content: '-'; }

        .dd-placeholder,
        .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                 -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                      linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
                    box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        }

        /**
         * Nestable Extras
         */

        .nestable-lists { display: block; clear: both; padding: 10px 0; width: 100%; border: 0;  }

        #nestable-menu { padding: 0; margin: 20px 0; }

        #nestable-output,

        @media only screen and (min-width: 700px) {

            .dd { float: left; width: 48%; }
            .dd + .dd { margin-left: 2%; }

        }

        .dd-hover > .dd-handle { background: #2ea8e5 !important; }
		.list_object .li_object{
			list-style: none;
        	border-bottom: 1px solid #dfdfdf;
		}
		.list_object .li_object .fa,  #nestable .fa,.menu_type{
			position: absolute;
		    right: 14px;
		    top: 50%;
		    height: 42px;
		    -webkit-transform: translate(0,-50%);
		    -ms-transform: translate(0,-50%);
		    -o-transform: translate(0,-50%);
		    transform: translate(0,-50%);
		    line-height: 39px;
		}
		.menu_type{
			right: 35px;
    		top: 16px;
		}
		#nestable .fa{
		    top: 28px;
		}
		.list_object .li_object .fa:before,  #nestable .fa:before{
		    content: "\f0dd";
		}
		#nestable .fa:before{
		    top: -7px;
		    position: absolute;
		    right: 5px;
	        line-height: 27px;
    		height: 30px;
		}
        .list_object .li_object h3{
        	position: relative;
        	cursor: pointer;
        	line-height: 21px;
        	padding:10px 10px 11px 14px;
			margin: 0;
        	font-size: 13px;
        	font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        	font-weight: bold;
        }
        .list_object .li_object:not(.active-none).active h3, .list_object .li_object .button-controls{
       		 background: rgba(234, 234, 234, 0.64);
       		 position: relative;
       	}
        .list_object .li_object:not(.active-none).active h3{
    	    border-bottom: 1px solid #dfdfdf;
    	    background: rgba(234, 234, 234, 0.64);
        }
        .bd-n{
        	border: none;
        }
        .row_object .check_obj{
        	float: left;
        	margin-right: 5px;
        }
        .content-li-object{
        	width: 100%;
        	height: auto;
        	display:none;
        	-moz-transition: none;
		    -webkit-transition: none;
		    -o-transition: none;
		    transition: none;
		    margin: 0;
        }
        .button-controls{
    	    clear: both;
    		margin: 10px 0;
		    margin: 0 -17px -10px -17px;
    		padding: 10px;
        }
        .list-controls{
    		margin-top: 5px;
        }
        .add-to-menu {
		    position: absolute;
		    right: 10px;
		    top: 50%;
		     -webkit-transform: translate(0,-50%);
		    -ms-transform: translate(0,-50%);
		    -o-transform: translate(0,-50%);
		    transform: translate(0,-50%);
		}
        .button-white {
    	    color: #555;
		    border-color: #ccc;
		    background: #f7f7f7;
		    -webkit-box-shadow: inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);
		    box-shadow: inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);
		    vertical-align: top;
		    display: inline-block;
		    text-decoration: none;
		    font-size: 13px;
		    line-height: 26px;
		    height: 28px;
		    margin: 0;
		    padding: 0 10px 1px;
		    cursor: pointer;
		    border-width: 1px;
		    border-style: solid;
		    -webkit-appearance: none;
		    -webkit-border-radius: 3px;
		    border-radius: 3px;
		    white-space: nowrap;
		    -webkit-box-sizing: border-box;
		    -moz-box-sizing: border-box;
		    box-sizing: border-box;
		    float: right;
        }
		.button-white:hover{
		 	background: #fafafa;
		    border-color: #999;
		    color: #23282d;
		}

		 .button-white:focus{
		 	 -webkit-box-shadow: 0 0 0 1px #5b9dd9,0 0 2px 1px rgba(30,140,190,.8);
   			 box-shadow: 0 0 0 1px #5b9dd9,0 0 2px 1px rgba(30,140,190,.8);
		}
		.button-white:active{
		 	background: #eee;
		    border-color: #999;
		    color: #32373c;
		    -webkit-box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);
		    box-shadow: inset 0 2px 5px -3px rgba(0,0,0,.5);

		}
	    .fl{
	    	float: left;
	    	margin-right: 5px;
	    }
	  	.row_object{
		  	max-height: 160px;
		    overflow: auto;
		    margin: 10px -10px 10px 0;
	 	}
	 	.no_item p{
	 		margin: 0;
	 	}
	 	.dd-item .fa{
	 		cursor: pointer;
	 	}
	 	.menu_item_info{
 		    margin-top: -6px;
		    border: 1px solid #dfdfdf;
		    padding: 10px 0;
	    	display: none;
	 	}
	 	.btn-remove{
 		    color: #a00;
	 	}
	 	.btn-remove:hover{
	       	color: red;
		    text-decoration: none;
	 	}
	 	.btn-cancel{
	 		text-decoration: underline;
	 	}
	 	.btn-cancel:hover{
 		    background: #0073aa;
    		color: #fff;
	 	}
	 	.menu_item_controls{
	 		margin-top: 10px;
	 		padding: 0 10px;
	 	}
	 	.menu_item_controls .btn-control{
	 		padding: 3px 5px;
	 		cursor: pointer;
	 	}

          
           
    </style>
@stop

@section('content')
<?php 

	$isAdmin = Request::has('admin');

	$option = 'client';

	$createMenuClient = check_permission('appearance_menu_client_create');
	$editMenuClient   = check_permission('appearance_menu_client_edit');
	$deleteMenuClient = check_permission('appearance_menu_client_delete');
	$viewMenuClient = check_permission('appearance_menu_client_view');

	$createMenuAdmin = check_permission('appearance_menu_admin_create');
	$editMenuAdmin   = check_permission('appearance_menu_admin_edit');
	$deleteMenuAdmin = check_permission('appearance_menu_admin_delete');
	$viewMenuAdmin = check_permission('appearance_menu_admin_view');

	if($isAdmin){
		$option = 'admin';
	}

	if(($isAdmin && !$viewMenuAdmin) || (!$isAdmin && !$viewMenuClient)){
		dd('Bạn không có quyền xem trang này');
	}



	

 ?>
 <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Menu @if( $isAdmin && $viewMenuClient )<span class="btn btn-primary" onclick="window.location.href = removeParam('admin',window.location.href);">Client</span>@elseif( !$isAdmin &&  $viewMenuAdmin )<span class="btn btn-primary" onclick="window.location.href = replaceUrlParam(window.location.href,'admin',1);">Admin</span>@endif</h3> 
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>
	  <div class="row">
		<div class="col-md-12">
			<div class="x_panel" style=" border: 1px solid #e5e5e5; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04); box-shadow: 0 1px 1px rgba(0,0,0,.04);background:#fbfbfb;">
	            <div class="x_content" style="height: 29px;padding:0;margin:0;">
	            	<?php 
	               		$obj->setTable('menu');

	               		$theme = theme_name();

	               		$option = 'client';

	               		$id = Request::get('id',-1);

	               		$menuThis = $obj->where(Vn4Model::$id,$id)->first();

	               		if( $isAdmin ){
	               			$option = 'admin';

	               			$menu = $obj->whereType('menu_item')->whereTheme($theme)->where('option',$option)->get();

	               			if($menuThis != null && $menuThis->option == $option && $menuThis->theme == $theme){
	               				$menucurrent = $menuThis;
	               			}else{
	               				$menucurrent = null;
	               			}

	               		}else{
	               			$menu = $obj->whereType('menu_item')->whereTheme($theme)->where('option',$option)->get();

	               			if($menuThis != null && $menuThis->option == $option && $menuThis->theme == $theme){
	               				$menucurrent = $menuThis;
	               			}else{
	               				$menucurrent = null;
	               			}

	               		}

	               		$id = -1;

	               		if($menucurrent != null){
	               			$id = $menucurrent->id;
	               		}else{
	               			if(count($menu) > 0){
	               				$menucurrent = $menu[0];
	               				$id = $menucurrent->id;
	               			}
	               		}
	               	 ?>
	               	 @if($id != -1)
	            	<span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;">Chọn menu để sửa: </span>

	            	<select id="selected_menu_edit" class="fl form-control" required="" style="display: inline;width: auto;height:100%;">
		               	

		               	 @foreach($menu as $m)
							<option @if($id == $m->id) selected @endif value="{!!$m->id!!}">{!!$m->title!!}</option>
		               	 @endforeach
	              	</select>

	              	<input type="submit" class="fl button-secondary button-white right" id="submit_selected_menu_edit" value="Chọn" name="add-post-type-menu-item">
					@endif
					<span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;" >
						
						@if((!$isAdmin && $createMenuClient) || ($isAdmin && $createMenuAdmin))

							@if($id!=-1) hoặc @endif tạo menu mới: </span>
					
					
								<input type="text" class="fl form-control" id="input_name_menu_new" placeholder="Tên menu" style="display:inline;width:auto;height:100%;">				
								<input type="submit"  id="input_submit_menu_new" class="btn btn-primary fl button-secondary right" value="Tạo menu" style="height:100%;line-height:15px;" name="add-post-type-menu-item">
						@else
							@if($id==-1) 
								<h4 style="margin: 5px;"><i>Bạn không có quyền tạo menu</i></h4>
							@endif
						@endif
	            </div>
	        </div>

		</div>
	  </div>
      <div class="row">
		@if($id != -1)
      	<div class="col-md-4 col-xs-12">
            <div class="x_panel" style="padding: 0;margin:0;">
	            <div class="x_content" style="padding: 0;margin:0;">
	            	<ul class="list_object" style="padding: 0;margin:0;">
						

						@if( !$isAdmin )
							
							@foreach($admin_object as $key => $object)
								@if(!isset($object['show_on_client_menu']) || $object['show_on_client_menu'] == true)
								<li class="li_object" object-type="{!!$key!!}">
									<h3>{!!$object['title']!!}<i class="fa"></i></h3>
									<div class="x_panel bd-n content-li-object">
										<ul class="row_object">

											<?php 
												$list_object = get_post($key);
											 ?>
											 @if(count($list_object)>0)
												 @foreach($list_object as $value)
													<li class=""><label>
						                              <input type="checkbox" class="check_obj" name="{!!$key!!}[]" value="{!!$value->id!!}"> {!!$value->title!!}
							                            </label>
							                        </li>

												 @endforeach
											 @else
												<li class="no_item">
						                              <p><i>Không có dữ liệu.</i></p>
						                        </li>
											 @endif
										</ul>
										 @if(count($list_object)>0)
										<p class="button-controls">
											<span class="list-controls">
												<a href="#" class="select-all">Select All</a>
											</span>

											<span class="add-to-menu">
												<input type="submit" class="button-secondary button-white submit-add-to-menu right" object-type="{!!$key!!}" value="Add to Menu" name="add-post-type-menu-item">
												<span class="spinner"></span>
											</span>
										</p>
										@endif

									</div>
								</li>
								@endif
							@endforeach


							<li class="li_object custom_link" object-type="custom_link">
								<h3>Custom Links<i class="fa"></i></h3>
								<div class="x_panel bd-n content-li-object">
						 			<div class="form-group">
				                        <label class="control-label col-xs-12">URL</label>
				                        <div class="col-xs-12">
				                          <input type="text" id="url_custom_links" class="form-control" value="http://" placeholder="http://">
				                        </div>
				                        <div class="clearfix"></div>
				                      </div>
				                      <div class="form-group">
				                        <label class="control-label col-xs-12">Link Text</label>
				                        <div class="col-xs-12">
				                          <input type="text" id="link_text_custom_links" class="form-control" placeholder="Menu item">
				                        </div>
				                        <div class="clearfix"></div>
				                      </div>

									<p class="button-controls">
										<span class="list-controls">
											<span class="">&nbsp;</span>
										</span>
			
										<span class="add-to-menu">
											<input type="submit" class="button-secondary button-white submit-add-custom-links right" object-type="custom_link" value="Add to Menu" name="add-post-type-menu-item">
											<span class="spinner"></span>
										</span>
									</p>

								</div>
							</li>
						@else

		            		@foreach($admin_object as $key => $object)

									<li class="li_object" object-type="{!!$key!!}">
										<h3>{!!$object['title']!!}<i class="fa"></i></h3>
										<div class="x_panel bd-n content-li-object">
											<ul class="row_object">

												<li class=""><label>
					                              <input type="checkbox" class="check_obj" name="{!!$key!!}[]" value="create_data"> Create Data
						                            </label>
						                        </li>
						                        <li class=""><label>
					                              <input type="checkbox" class="check_obj" name="{!!$key!!}[]" value="create_and_show_data"> Create And Show Data
						                            </label>
						                        </li>
						                        <li class=""><label>
					                              <input type="checkbox" class="check_obj" name="{!!$key!!}[]" value="show_data"> Show Data
						                            </label>
						                        </li>

											</ul>
											<p class="button-controls">
												<span class="list-controls">
													<a href="#" class="select-all">Select All</a>
												</span>

												<span class="add-to-menu">
													<input type="submit" class="button-secondary button-white submit-add-to-menu right" object-type="{!!$key!!}" value="Add to Menu" name="add-post-type-menu-item">
													<span class="spinner"></span>
												</span>
											</p>
										</div>
									</li>

							@endforeach

							<?php 
								$obj_setting = include __DIR__.'/../../../cms/layout/setting.php';
							 ?>


							 <li class="li_object" object-type="admin.setting">
									<h3>Setting<i class="fa"></i></h3>
									<div class="x_panel bd-n content-li-object">
										<ul class="row_object">

												 @foreach($obj_setting as $key => $object)

												 	<li class=""><label>
						                              <input type="checkbox" class="check_obj" name="admin.setting[]" value="{!!$key!!}"> {!!ucwords(str_replace('-',' ',$key))!!}
							                            </label>
							                        </li>

												@endforeach

										</ul>
										<p class="button-controls">
											<span class="list-controls">
												<a href="#" class="select-all">Select All</a>
											</span>

											<span class="add-to-menu">
												<input type="submit" class="button-secondary button-white submit-add-to-menu right" object-type="admin.setting" value="Add to Menu" name="add-post-type-menu-item">
												<span class="spinner"></span>
											</span>
										</p>
									</div>
								</li>

							
								
							<?php 
								$filesInFolder = \File::files('resources/views/admin');

							    $listNoInclue = ['create_and_show_data','create_data','footer','master','show_data','sidebar','topnav','setting','login'];

							    foreach($filesInFolder as $path)
							    {
							        $fileName = explode('.',pathinfo($path)['filename'])[0];

							        if(!(array_search($fileName, $listNoInclue) !== false)){
							            $title = ucwords(str_replace('-',' ',$fileName));
							            $content[] = ['title'=>$title,'permissions'=>[$fileName.'_view'=>['title'=>'View '. $title,'colspan'=>100]]];
							        }
							       
							    }
							 ?>
							

							<li class="li_object" object-type="admin.page">
									<h3>Admin page<i class="fa"></i></h3>
									<div class="x_panel bd-n content-li-object">
										<ul class="row_object">

												 @foreach($filesInFolder as $path)
								
														<?php $fileName = explode('.',pathinfo($path)['filename'])[0]; ?>

														@if(!(array_search($fileName, $listNoInclue) !== false))

															<li class=""><label>
								                              <input type="checkbox" class="check_obj" name="admin.page[]" value="{!!$fileName!!}"> {!!ucwords(str_replace('-',' ',$fileName))!!}
									                            </label>
									                        </li>

												        @endif

												@endforeach

										</ul>
										<p class="button-controls">
											<span class="list-controls">
												<a href="#" class="select-all">Select All</a>
											</span>

											<span class="add-to-menu">
												<input type="submit" class="button-secondary button-white submit-add-to-menu right" object-type="admin.page" value="Add to Menu" name="add-post-type-menu-item">
												<span class="spinner"></span>
											</span>
										</p>
									</div>
								</li>


							



							<li class="li_object custom_link" object-type="custom_link">
								<h3 style="background: black;color: white;">Menu Parent (Not Link)<i class="fa"></i></h3>
								<div class="x_panel bd-n content-li-object">

				                      <div class="form-group">
				                        <label class="control-label col-xs-12">Link Text</label>
				                        <div class="col-xs-12">
				                          <input type="text" id="link_text_custom_links" class="form-control" placeholder="Menu item">
				                        </div>
				                        <div class="clearfix"></div>
				                      </div>

									<p class="button-controls">
										<span class="list-controls">
											<span class="">&nbsp;</span>
										</span>
			
										<span class="add-to-menu">
											<input type="submit" class="button-secondary button-white submit-add-custom-links right" object-type="custom_link" value="Add to Menu" name="add-post-type-menu-item">
											<span class="spinner"></span>
										</span>
									</p>

								</div>
							</li>
						@endif
	            	</ul>
	            </div>
            </div>		
    	</div>

    	@endif
    	<div class=" @if($id != -1) col-md-8 col-xs-12 @else col-xs-12 @endif ">
			<div class="x_panel" @if($id != - 1) style="padding-bottom: 0;" @endif>
	            <div class="x_content" @if($id != - 1) style=" padding: 0;" @endif>
	            	@if($id != -1)
	            	<form action="" method="POST">
	                <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
	                <div class="row">

	                	
	                	
	                		<h3><i>Cấu Trúc Menu</i></h3>

	                		<div class="drag-instructions post-body-plain">
								<p><i>Kéo mỗi mục vào thứ tự bạn muốn. Nhấp vào mũi tên bên phải của mục để hiển thị tùy chọn cấu hình thêm.</i></p>
							</div>
	                		<!-- START: MENU -->
						   <!--  <menu id="nestable-menu">
						        <button type="button" data-action="expand-all">Expand All</button>
						        <button type="button" data-action="collapse-all">Collapse All</button>
						    </menu> -->

						    <div class="cf nestable-lists">

						        <div class="dd" id="nestable">
						        	@if(!$isAdmin)
							        	@if(trim($menucurrent->json) == '' || empty($menucurrent->json))
											 <ol class="dd-list">
											 </ol>
										@else
											<?php   $json = json_decode($menucurrent->json, true);?>
						            		{!! q_get_menu_structure_client($json) !!}
							        	@endif
						        	@else
										@if(trim($menucurrent->json) == '' || empty($menucurrent->json))
											 <ol class="dd-list">
											 </ol>
										@else
											<?php   $json = json_decode($menucurrent->json, true);?>
						            		{!! q_get_menu_structure_admin( $json,$admin_object ) !!}

							        	@endif
						        	@endif

					            	
						             
						        </div>
						    </div>
						<hr>
						<div class="setting_menu">
							<h3><i>Cài đặt menu</i></h3>
								<div class="row">
									<div class="col-md-10 col-md-offset-2">
										<div class="checkbox">
						                    <label>
						                      <input type="checkbox" id="auto_add_to_menu" name="auto_add_to_menu"> Tự động thêm các trang cấp cao nhất mới vào menu này
						                    </label>
					                  	</div><p></p>
										
										<?php 
											$menu = [];

											$menu = apply_filter('add_menu_'.$option,$menu);
	 									?>

	 									@foreach($menu as $value)
											
											<?php 
												$group = -2;

												$menu = $obj->where('type','menu')->where('key_word',$value['key'])->where('theme',$theme)->where('option',$option)->first();

												if($menu != null){
													$group = $menu->group;
												}
											 ?>
											<div class="checkbox">
							                    <label>
							                      <input type="checkbox" name="add_to_menu[]" @if($group == $id) checked="checked" @endif value="{!!$value['key']!!}"> {!!$value['title']!!}
							                    </label>
						                  	</div>
										
	 									@endforeach

									</div>
								</div>
							</div>
					    <textarea hidden id="nestable-output"></textarea>

						    <!-- STOP: MENU -->
						@if( ($isAdmin && ($editMenuAdmin || $deleteMenuAdmin)) ||  (!$isAdmin && ($editMenuClient || $deleteMenuClient)) )
			              <div class="row" style="margin: 0 -7px;height: auto;background: #efefef;height: 48px;padding: 10px;border-top: 1px solid #E6E9ED;">
			              	@if( ($isAdmin && $deleteMenuAdmin) || (!$isAdmin && $deleteMenuClient) )
			              	<a type="button" id="delete_menu" href="#" class="btn-control btn-remove" style=" margin-top: 4px;text-decoration: underline;">Xóa Menu</a>
			              	@endif

			              	@if( ($isAdmin && $editMenuAdmin) || (!$isAdmin && $editMenuClient) )
			              	<input type="submit" class="btn btn-primary fl button-secondary right pull-right btn-save" value="Lưu" style="height:100%;line-height:15px;" name="add-post-type-menu-item">
			              	@endif
			              </div>
			            @endif
	                </div>
	              </form>
	              @else
	              	<h4><i>Hiện chưa có menu nào được tạo.</i></h4>
	              @endif
	            </div>
            </div>
    	</div>
      </div>
    </div>
  </div>

@stop


@section('js')
	<script>
		
	</script>
	<script src="{!!asset('public/admin/js/jquery.nestable.js')!!}"></script>
	<script>
	$(document).ready(function() {

		$('.list_object .li_object').click(function(event) {

			$this = $(this);

			$('.list_object .li_object.active .content-li-object').slideUp('fast',function(){
				$(this).closest('.li_object').removeClass('active');
			});

			if($(this).hasClass('active')){
				$(this).find('.content-li-object').slideUp('fast',function(){
					$this.removeClass('active');
				});
			}else{
				$this.addClass('active');
				$(this).find('.content-li-object').slideDown('fast');
			}

		});

		$('.content-li-object').click(function(event) {
			event.stopPropagation();
		});

		@if($id != -1)
		var updateOutput = function(e) {
			var list = e.length ? e : $(e.target),
				output = list.data('output');

			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};

		// activate Nestable for list 1

		$('#nestable').nestable({
				group: 1,
				maxDepth: 5,
				expandBtnHTML:'',
				collapseBtnHTML:'',
			});

		// output initial serialised data
		// updateOutput($('#nestable').data('output', $('#nestable-output')));

		$('#nestable-menu').on('click', function(e) {
			var target = $(e.target),
				action = target.data('action');
			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
		});
		@endif
		$('body').on('click', '.dd-item .fa', function(event) {
			
			event.preventDefault();
			event.stopPropagation();
			$(this).closest('.dd-item').find('.menu_item_info:first').slideToggle('fast');
		});
		
		$('body').on('change','.input-nav-label',function(event){
			$(this).closest('.dd-item').attr('data-label',$(this).val());
			$(this).closest('.dd-item').find('.dd-handle:first').text($(this).val());
			$(this).attr('value',$(this).val());
		});

		$('body').on('change','.input-links',function(event){
			$(this).closest('.dd-item').attr('data-links',$(this).val());
			$(this).attr('value',$(this).val());
		});

		
		
		$('.submit-add-to-menu').click(function(event) {
			var key = $(this).attr('object-type');

			var list_object = $(this).closest('.content-li-object').find( ".check_obj[name='"+key+"[]']:checked" ).map(function(index, el) {
				return $(el).val();
			}).get();

			var selector = '.dd-list:first';

			<?php 
				q_include_particle('ajax',
					['data'=>['list_object'=>'list_object','selector'=>'selector','key'=>'key','type'=>'"add menu item"']]
				); 
			?>
		});

		@if($id != -1)
		$('#delete_menu').click(function(event) {
			event.preventDefault();

			<?php 
				q_include_particle('ajax',
						['data'=>['id'=>$id,'type'=>'"delete menu"']]
					);
			 ?>
		});

		@endif

		

		@if($isAdmin)

			$('.submit-add-custom-links').click(function(event) {

				var linkText = $('#link_text_custom_links').val();
				var selector = '.dd-list:first';
				if(linkText){
					<?php 
						q_include_particle('ajax',
							['data'=>['linkText'=>'linkText','selector'=>'selector','type'=>'"add menu parent"']]
						); 
					?>
				}
				
			});

		@else
			$('.submit-add-custom-links').click(function(event) {

				var url = $('#url_custom_links').val();
				var linkText = $('#link_text_custom_links').val();
				var selector = '.dd-list:first';

				if(url && linkText){
					<?php 
						q_include_particle('ajax',
							['data'=>['url'=>'url','linkText'=>'linkText','selector'=>'selector','type'=>'"add custom link"']]
						); 
					?>
				}
				
			});
		@endif
		$('.select-all').click(function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).closest('.content-li-object').find('input[type="checkbox"]').prop({checked:true});
		});

		$('.btn-save').click(function(event) {
			event.preventDefault();
			event.stopPropagation();
			updateOutput($('#nestable').data('output', $('#nestable-output')));

			var auto_add_to_menu = $('#auto_add_to_menu').prop('checked');
			var add_to_menu = get_val_checkbox('.setting_menu input[name="add_to_menu[]"]');
			<?php 
				q_include_particle('ajax',
					['data'=>['auto_add_to_menu'=>'auto_add_to_menu','add_to_menu'=>'add_to_menu','html_menu_admin'=>'$("#nestable .dd-list:first").html()','id'=>$id,'menu_item'=>'$("#nestable-output").val()','type'=>'"Edit menu"']]
				); 
			?>

		});

		$('#nestable').on('click', '.btn-remove', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).closest('.dd-item').find('.dd-handle').css({background: '#de0000',color: 'white'});
			$(this).closest('.dd-item').find('i.fa').css({color: 'white'});
			$(this).closest('.dd-item').find('.menu_type').css({color: 'white'});

			$(this).closest('.menu_item_info').slideUp('fast',function(){
				$(this).closest('.dd-item').remove();
			});
		});

		$('#nestable').on('click', '.btn-cancel', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).closest('.menu_item_info').slideUp('fast');

		});

		$('#input_submit_menu_new').click(function(event) {
			if($('#input_name_menu_new').val() != ''){
				<?php 
					q_include_particle('ajax',
						['data'=>['name'=>'$("#input_name_menu_new").val()','type'=>'"create menu"']]
					); 
				?>
			}
		});

		$('#input_name_menu_new').keypress(function(e) {
		    if(e.which == 13) {
		        $('#input_submit_menu_new').trigger('click');
		    }
		});

		$('#submit_selected_menu_edit').click(function(event) {
			if($('#selected_menu_edit').val()){
				window.location.href = replaceUrlParam(window.location.href,'id',$('#selected_menu_edit').val());
			}
		});

	});
	</script>

@stop