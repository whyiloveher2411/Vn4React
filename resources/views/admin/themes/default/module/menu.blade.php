@extends(backend_theme('master'))

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
        .list_object .li_object.active h3, .list_object .li_object .button-controls{
       		 background: rgba(234, 234, 234, 0.64);
       		 position: relative;
       	}
        .list_object .li_object.active h3{
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

 <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Menu Setting</h3>
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

	               		$theme = setting('general_client_theme');

	               		$menu = $obj->whereType('menu')->where('theme',$theme)->get();

	               		$id = Request::get('id',count($menu)>0?$menu[0]->id:-1);

	               		if($id != -1){
	               			$menuThis = $obj->where(Vn4Model::$id,$id)->first();
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
					<span class="fl" style="line-height: 28px;display: inline-block;float: left;margin-right:5px;" >@if($id!=-1) hoặc @endif tạo menu mới: </span>
					
					
					<input type="text" class="fl form-control" id="input_name_menu_new" placeholder="Tên menu" style="display:inline;width:auto;height:100%;">				
					<input type="submit"  id="input_submit_menu_new" class="btn btn-primary fl button-secondary right" value="Tạo menu" style="height:100%;line-height:15px;" name="add-post-type-menu-item">
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

	                	
	                	
	                		<h3><i>Menu Structure</i></h3>

	                		<div class="drag-instructions post-body-plain">
								<p><i>Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</i></p>
							</div>

						    <div class="cf nestable-lists">

						        <div class="dd" id="nestable">
						        	@if(trim($menuThis->json) == '' || empty($menuThis->json))
										 <ol class="dd-list">
										 </ol>
									@else
										<?php   $json = json_decode($menuThis->json, true);?>
					            		{!! q_get_menu_structure($json) !!}
						        	@endif

					            	
						             
						        </div>
						    </div>
								
					    <textarea hidden id="nestable-output"></textarea>

			              <div class="row" style="margin: 0 -7px;height: auto;background: #efefef;height: 48px;padding: 10px;border-top: 1px solid #E6E9ED;">
			              	<a type="button" id="delete_menu" href="#" class="btn-control btn-remove" style=" margin-top: 4px;text-decoration: underline;">Delete Menu</a>
			              	<input type="submit" class="btn btn-primary fl button-secondary right pull-right btn-save" value="Save" style="height:100%;line-height:15px;" name="add-post-type-menu-item">
			              </div>
	                </div>
	              </form>
	              @else
	              	<h4><i>Vui lòng tạo mới menu ở phía trên</i></h4>
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

		$(document).on('click','.list_object .li_object',function(event) {

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

		$(document).on('click','.content-li-object',function(event) {
			event.stopPropagation();
		});

		@if($id != -1)
		var updateOutput = function(e) {
			var list = e.length ? e : $(e.target),
				output = list.data('output');

			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};


		$('#nestable').nestable({
				group: 1,
				maxDepth: 5,
				expandBtnHTML:'',
				collapseBtnHTML:'',
			});

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

		
		
		$(document).on('click','.submit-add-to-menu',function(event) {
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
		$(document).on('click','#delete_menu',function(event) {
			event.preventDefault();

			<?php 
				q_include_particle('ajax',
						['data'=>['id'=>$id,'type'=>'"delete menu"']]
					);
			 ?>
		});

		@endif

		$(document).on('click','.submit-add-custom-links',function(event) {

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
		$(document).on('click','.select-all',function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).closest('.content-li-object').find('input[type="checkbox"]').prop({checked:true});
		});

		$(document).on('click','.btn-save',function(event) {
			event.preventDefault();
			event.stopPropagation();
			updateOutput($('#nestable').data('output', $('#nestable-output')));


			<?php 
				q_include_particle('ajax',
					['data'=>['html_menu_admin'=>'$("#nestable .dd-list:first").html()','id'=>$id,'menu_item'=>'$("#nestable-output").val()','type'=>'"Edit menu"']]
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

		$(document).on('click','#input_submit_menu_new',function(event) {
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

		$(document).on('click','#submit_selected_menu_edit',function(event) {
			if($('#selected_menu_edit').val()){
				window.location.href = replaceUrlParam(window.location.href,'id',$('#selected_menu_edit').val());
			}
		});

	});
	</script>

@stop