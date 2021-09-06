<!DOCTYPE html>
<html>
<head>
	<title>Many Record</title>


<meta name="domain" content="{!!url('/')!!}">
<link href="@asset(vendors/bootstrap/css/bootstrap.min.css)" rel="stylesheet">
<style type="text/css">
a:hover{
	text-decoration: none;
}
/* width */
body.is-iframe::-webkit-scrollbar, .custom_scroll::-webkit-scrollbar {
  width: 5px;
}

/* Track */
body.is-iframe::-webkit-scrollbar-track,.custom_scroll::-webkit-scrollbar-track {
  background: #f1f1f1; 
  border-radius: 15px;
}
 
/* Handle */
body.is-iframe::-webkit-scrollbar-thumb,.custom_scroll::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 15px;
}

/* Handle on hover */
body.is-iframe::-webkit-scrollbar-thumb:hover,.custom_scroll::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
.container {
  display: block;
  position: relative;
  padding-left: 43px;
  margin-bottom: 0;
  cursor: pointer;
  line-height: 19px;
  font-size: 13px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  padding-top: 8px;
  padding-bottom: 8px;
}

.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
.btn{
	white-space: initial;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
	padding: 0;
}
.checkmark {
  position: absolute;
  top: 8px;
  left: 10px;
  height: 20px;
  width: 20px;
  background-color: #eaeaea;
  border-radius: 50%;
}

.checkmark.checkbox{
	border-radius: 0;
    margin: 0;
}

.container:hover input ~ .checkmark {
  background-color: #ccc;
}

.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.container input:checked ~ .checkmark:after {
  display: block;
}

.container .checkmark:after {
 	top: 6px;
	left: 6px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
.container .checkmark.checkbox:after {
    top: 2px;
	left: 6px;
    width: 8px;
    height: 13px;
    border-radius: 0;
    background: none;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
.item{
	margin: 2.5px;
	float: left;
}
.remove{
	font-style: unset;
	font-weight: bold;
}
.icon-href{
	width: 19px;
	height: 19px;
	float: right;
}
td:hover{
	background:#efefef;
}

.ui-sortable-placeholder{
	border:2px dashed #dedede;
}
hr{
	margin: 10px 0;
}
</style>
</head>
<body class="is-iframe">

<?php 
	$search = Request::get('q');

	$value = Request::get('value',-1);
	$value = explode(',', $value);

	$param = http_build_query(Request::except('page','q'));

    if( $param ) $param = '&'.$param;

	$typeLink = Request::get('typeLink','postType');
	$postType = Request::get('postType','page');

	$admin_object = get_admin_object($postType);

	$type = Request::get('type','only');

	$typeInput = [
    	'only'=>'<input type="radio" value="##value##" ##checked## name="chose"><span class="checkmark"></span>',
    	'multi'=>'<input type="checkbox" value="##value##" ##checked## name="chose[]"><span class="checkmark checkbox"></span>',
    ];

    $input = $typeInput[$type];

	$inputChange  = Request::get('inputChange','idNone');

	$list_post_type = get_admin_object();

 ?>
<form id="formSearch">


	<select style="height: 34px;" onchange="window.location.href = replaceUrlParam(window.location.href,'typeLink',this.value)">
		<option @if( $typeLink === 'postType' ) selected="selected" @endif value="postType">Post Type</option>
		<option @if( $typeLink === 'customLink' ) selected="selected" @endif value="customLink">Custom Link</option>
		<option @if( $typeLink === 'page' ) selected="selected" @endif value="page">Page</option>
	</select>


	@if( $typeLink === 'postType' )
	<select style="height: 34px;" onchange="window.location.href = replaceUrlParam(window.location.href,'postType',this.value)">
		@foreach($list_post_type as $k => $p)
		@if( $p['public_view'] )
		<option @if( $postType === $k ) selected="selected" @endif value="{!!$k!!}">{!!$p['title']!!}</option>
		@endif
		@endforeach
	</select>

	<hr>

	<div class="input-group mb-3" style="text-align: right;float: right;width: 100%;margin-bottom: 5px;">
	<?php 
		

        $paramGetPost = do_action('many-record');

        if( !is_array($paramGetPost) ) $paramGetPost = [];

        $callbackDefault = function($q) use ($search){
			if( $search ){
		       	$q->where('title','LIKE','%'.$search.'%');
	        }

	        if( $where = Request::get('where') ){
	        	parse_str($where, $output);
	        	if( isset($output[0]) && isset($output[1]) ){
		        	if( isset($output[2]) ){
	        			$q->where($output[0],$output[1],$output[2]);
		        	}else{
	        			$q->where($output[0],$output[1]);
		        	}
	        	}
	        }

	        if( Request::get('excludeRelationshipOnetoone') ){
	        	$postDetailField = Request::get('postDetailField');
	        	$postDetailType =  Request::get('postDetailType');
	        	$ids = DB::table($postDetailType)->whereNotNull($postDetailField)->pluck($postDetailField)->all();
	        	$q->whereNotIn(Vn4Model::$id,$ids);
	        }

			// $q2 = do_action('many-record',$q);

			// if( $q2 ) $q = $q2;
	    };

        if( isset($paramGetPost['callback']) ){
        	$paramGetPost['callback'] = [
        		$callbackDefault,
        		$paramGetPost['callback']
        	];

        }else{
        	$paramGetPost['callback'] = $callbackDefault;
        }

        $paramGetPost = array_merge(['count'=>10,'paginate'=>'page','select'=>[Vn4Model::$id,'title']],$paramGetPost);
    	$posts = get_posts($postType,$paramGetPost);

	    
	    
	 ?>

		<input class="btn btn-default" type="submit" style="float: right;" value="Search">
		<input type="search" style="float: right;width: 250px;margin-right: 5px;" id="inputSearch" value="{!!$search!!}" class="form-control search" placeholder="Search" name="search"> <br>
	</div>

	@endif

</form>

<form id="formSubmit">
@if( $typeLink === 'postType' )
<table class="table" style="margin: 0;border-bottom: 1px solid #ddd;">

	<?php 
		
		
		foreach ($posts as $p) {

			$id = $p->id;

			$attribute = $p->getAttributes();

			unset($attribute[Vn4Model::$id]);

			?>
			<tr>
				<td>
					<label class="container"><span><?php echo implode('</span> - <span>',$attribute); ?></span> <a target="_blank" href="{!!route('admin.create_data',['type'=>$postType, 'post'=>$p->id,'action_post'=>'edit'])!!}"><svg class="svg-icon icon-href" viewBox="0 0 20 20">
						<path d="M4.317,16.411c-1.423-1.423-1.423-3.737,0-5.16l8.075-7.984c0.994-0.996,2.613-0.996,3.611,0.001C17,4.264,17,5.884,16.004,6.88l-8.075,7.984c-0.568,0.568-1.493,0.569-2.063-0.001c-0.569-0.569-0.569-1.495,0-2.064L9.93,8.828c0.145-0.141,0.376-0.139,0.517,0.005c0.141,0.144,0.139,0.375-0.006,0.516l-4.062,3.968c-0.282,0.282-0.282,0.745,0.003,1.03c0.285,0.284,0.747,0.284,1.032,0l8.074-7.985c0.711-0.71,0.711-1.868-0.002-2.579c-0.711-0.712-1.867-0.712-2.58,0l-8.074,7.984c-1.137,1.137-1.137,2.988,0.001,4.127c1.14,1.14,2.989,1.14,4.129,0l6.989-6.896c0.143-0.142,0.375-0.14,0.516,0.003c0.143,0.143,0.141,0.374-0.002,0.516l-6.988,6.895C8.054,17.836,5.743,17.836,4.317,16.411"></path>
					</svg></a>
						{!!strtr($input, ['##value##'=>$p->id,'##checked##'=>array_search($p->id,$value) !== false ? 'checked="checked"' : ''])!!}
					</label>
				</td>
			 </tr>
			<?php
		}
	 ?>
</table>
<?php echo vn4_view('default.paginate',['paginator'=>$posts]); ?>
	
@elseif( $typeLink === 'customLink' )
	<br>
	<input type="text" style="width: 100%;margin-right: 5px;" id="custom-input-link" value="" class="form-control search" placeholder="Link" name="custom-input-link">
@elseif( $typeLink === 'page' )
	<br>
	<table class="table" style="margin: 0;border-bottom: 1px solid #ddd;">
		<?php 
			
            if( file_exists(cms_path('resource','views/themes/'.theme_name().'/page')) ) {

                $files = File::allFiles(cms_path('resource','views/themes/'.theme_name().'/page'));

                foreach ($files as $page) {

                    if( strpos($page->getRelativePathname(), '.blade.php') ){

                        $v = basename($page,'.blade.php');
                      
                        $name = explode('/', $page->getFilename());

                        $name = substr(end($name), 0, -10);

                        $name = ucwords(preg_replace('/-/', ' ', str_slug($name)));

                        preg_match( '|Page Name:(.*)$|mi', file_get_contents( $page->getRealPath() ), $header );

                        if( isset($header[1]) ){
                          $name = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $header[1] ) );
                        }

                        ?>
                        <tr>
							<td>
								<label class="container"><span>{!!$name!!}</span>
									{!!strtr($input, ['##value##'=>substr($page->getRelativePathname(), 0, -10),'##checked##'=>array_search(substr($page->getRelativePathname(), 0, -10),$value) !== false ? 'checked="checked"' : ''])!!}
								</label>
							</td>
						 </tr>
                        <?php


                        $list_options[substr($page->getRelativePathname(), 0, -10)] = $name;
                    }
                }

            }
		 ?>
	</table>


@endif


<button type="submit" class="submit btn btn-primary" style="float: right;margin: 20px 0;">Submit</button>
<div class="clearfix"></div>
</form>


<div class="clearfix"></div>

<script src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>
    <script src="{!!asset('')!!}vendors/bootstrap/js/bootstrap.min.js?v=1"></script>

<script type="text/javascript">
	
	$(window).load(function(){


		
		$('#modal-many-record .modal-title', window.parent.document).text('');
		
		window.replaceUrlParam  = function(url, paramName, paramValue)
		{
		    if (paramValue == null) {
		        paramValue = '';
		    }
		    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
		    if (url.search(pattern)>=0) {
		        return url.replace(pattern,'$1' + paramValue + '$2');
		    }
		    url = url.replace(/[?#]$/,'');
		    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
		}

		$('body .valueTemp').on('click','.item .remove',function(event){
			event.stopPropagation();
			$( 'input[value="'+$(this).closest('.item').data('value')+'"]').prop("checked",false);
			$(this).closest('.item').remove();


			var value = get_valueTemp();
		 	window.history.pushState("object or string", "Page",  replaceUrlParam(window.location.href, 'value', value.join(',')));

		});

		$('#formSearch').submit(function(event){

			event.preventDefault();
			var value = get_valueTemp();
			window.location.href = replaceUrlParam('{!!route('admin.page','many-record')!!}?q='+$('#inputSearch').val()+'{!!$param!!}','value',value.join(','));

		});

		// window.parent.resizeIframe($('.popup-fixed iframe',window.parent.document)[0]);

		$('input[name="chose[]"]').change(function() {
	        if(this.checked) {
	            $(this).prop("checked", true);
	        	if( $('.valueTemp .item.input'+$(this).val()).length < 1 ){
	        		$('.valueTemp').append('<span data-value="'+$(this).val()+'" class="item btn btn-default input'+$(this).val()+'"><a href="{!!route('admin.create_data',['type'=>$postType,'action_post'=>'edit'])!!}&post='+$(this).val()+'" target="_blank">'+$(this).closest('.container').text()+'</a> <i class="remove">x</i></span>');
	        	}
	        }else{
	        	$('.valueTemp .item.input'+$(this).val()).remove();
	        }

    		// window.parent.resizeIframe($('.popup-fixed iframe',window.parent.document)[0]);

	        
			var value = get_valueTemp();
		 	window.history.pushState("object or string", "Page",  replaceUrlParam(window.location.href, 'value', value.join(',')));
	    });

		// window.parent.$('.popup-fixed .popup-content').css({height:'auto'});


		$('#formSubmit').submit(function(event){


			event.preventDefault();

			@if( $typeLink === 'postType' )

				value = $('input[name="chose"]:checked').val();

				$('.input-link-parent.active-moment', window.parent.document).find('.link-type').text('{!!$admin_object['title']!!}:');
				$('.input-link-parent.active-moment', window.parent.document).find('.value-input-link').html('<a target="_blank" href="{!!route('admin.controller',['controller'=>'post-type','method'=>'get-public-view-post'])!!}?id='+value+'&type={!!$postType!!}">'+$('input[name="chose"]:checked').closest('label').find('span:eq(0)').text()+'</a>');

				$('.input-link-parent.active-moment .form-control', window.parent.document).val(JSON.stringify({type:'post-detail','post_type':'{!!$postType!!}','id':value}));

				$('.input-link-parent.active-moment .input-title', window.parent.document).attr('value',$('input[name="chose"]:checked').closest('label').find('span:eq(0)').text()).trigger('change');

			

			@elseif( $typeLink === 'customLink' )

				$('.input-link-parent.active-moment', window.parent.document).find('.link-type').text('@__('Custom Link'):');
				$('.input-link-parent.active-moment', window.parent.document).find('.value-input-link').html('<a target="_blank" href="'+$('#custom-input-link').val()+'">'+$('#custom-input-link').val()+'</a>');
				$('.input-link-parent.active-moment .input-title', window.parent.document).attr('value',$('#custom-input-link').val()).trigger('change');;
				$('.input-link-parent.active-moment .form-control', window.parent.document).val(JSON.stringify({type:'custom-link','link':$('#custom-input-link').val()}));

			@elseif( $typeLink === 'page' )

				value = $('input[name="chose"]:checked').val();

				$('.input-link-parent.active-moment', window.parent.document).find('.link-type').text('@__('Page'):');
				$('.input-link-parent.active-moment', window.parent.document).find('.value-input-link').html('<a target="_blank" href="{!!url('/')!!}\/'+value+'">'+$('input[name="chose"]:checked').closest('label').find('span:eq(0)').text()+'</a>');

				$('.input-link-parent.active-moment .form-control', window.parent.document).val(JSON.stringify({type:'page','page':value}));

				$('.input-link-parent.active-moment .input-title', window.parent.document).attr('value',$('input[name="chose"]:checked').closest('label').find('span:eq(0)').text()).trigger('change');

			@endif

			$('.input-link-parent.active-moment', window.parent.document).removeClass('active-moment');

			$('html', window.parent.document).removeClass('show-popup-fixed');

		});

		
		var script = document.createElement('script');
        script.onload = function () {
           $( ".valueTemp" ).sortable({
            stop:function(event, ui){
                ui.item.attr('style','');
            },
            start:function(event,ui){
            	ui.placeholder.css("visibility", "visible");
                ui.placeholder.height(ui.item.height() - 4);
            },
            update: function(event, ui) {
            },
           });
        };
        script.src = $('meta[name="domain"]').attr('content')+'/admin/js/jquery-ui.min.js';
        document.head.appendChild(script);


	});
</script>

</body>
</html>
