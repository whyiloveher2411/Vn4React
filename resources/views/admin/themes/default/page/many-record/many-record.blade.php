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
.valueTemp{
	display: flex;
    flex-wrap: wrap;
}
.item{
	margin: 2.5px;
	display: flex;
	width: auto;
	white-space: nowrap;
}
.remove{
	font-style: unset;
	font-weight: bold;
	margin-left: 5px;
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

</style>
</head>
<body>

<?php 
	$search = Request::get('q');

	$value = Request::get('value',-1);
	$value = explode(',', $value);


	$post_type = Request::get('postType');

	$admin_object = get_admin_object($post_type);

	$type = Request::get('type','only');

	$columns = Request::get('columns',['title']);

	$columns[] = Vn4Model::$id;

	$inputChange  = Request::get('inputChange','idNone');

 ?>
<form id="formSearch">
	<div class="input-group mb-3" style="text-align: right;float: right;width: 100%;margin-bottom: 5px;">
	<?php 

		$param = http_build_query(Request::except('page','q'));

        if( $param ) $param = '&'.$param;

        $paramGetPost = do_action('many-record');

        if( !is_array($paramGetPost) ) $paramGetPost = [];

        $callbackDefault = function($q) use ($search, $columns){
			if( $search ){
		       	$q->where($columns[0],'LIKE','%'.$search.'%');
	        }

	        if( $whereUrl = Request::get('where') ){

	        	parse_str($whereUrl, $whers);

	        	foreach ($whers as $output) {
	        		
	        		if( isset($output[0]) && isset($output[1]) ){
			        	if( isset($output[2]) ){
		        			$q->where($output[0],$output[1],$output[2]);
			        	}else{
		        			$q->where($output[0],$output[1]);
			        	}
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

        $paramGetPost = array_merge(['count'=>10,'paginate'=>'page','select'=>$columns ],$paramGetPost);
    	$posts = get_posts($post_type,$paramGetPost);

	    $typeInput = [
	    	'only'=>'<input type="radio" value="##value##" ##checked## name="chose"><span class="checkmark"></span>',
	    	'multi'=>'<input type="checkbox" value="##value##" ##checked## name="chose[]"><span class="checkmark checkbox"></span>',
	    ];

	    $input = $typeInput[$type];
	    
	 ?>

		<input class="btn btn-default" type="submit" style="float: right;" value="Search">
		<input type="search" style="float: right;width: 250px;margin-right: 5px;" id="inputSearch" value="{!!$search!!}" class="form-control search" placeholder="Search" name="search"> <br>
	</div>

</form>

<form id="formSubmit">
<table class="table" style="margin: 0;border-bottom: 1px solid #ddd;">
	<?php 
		
		
		foreach ($posts as $p) {

			$id = $p->id;

			$attribute = $p->getAttributes();

			unset($attribute[Vn4Model::$id]);

			?>
			<tr>
				<td>
					<label class="container"><?php echo join(' - ',$attribute); ?> <a target="_blank" href="{!!route('admin.create_data',['type'=>$post_type, 'post'=>$p->id,'action_post'=>'edit'])!!}"><svg class="svg-icon icon-href" viewBox="0 0 20 20">
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

<button type="submit" class="submit btn btn-primary" style="float: right;margin: 20px 0;">Submit</button>
<div class="clearfix"></div>
</form>

<div class="valueTemp">
	
	<?php 
		if( isset($value[0]) && $value[0] ){
			$posts_valuetemp = get_posts($post_type,['select'=>$columns,'count'=>1000,'callback'=>function($q) use ($value){
				return $q->whereIn(Vn4Model::$id,$value)->orderByRaw('FIELD('.Vn4Model::$id.', '.join(',', $value).')');
			}]);
			
			foreach ($posts_valuetemp as $p) {
				?>
				<span class="item btn btn-default input{!!$p->id!!}" data-value="{!!$p->id!!}"><a href="{!!route('admin.create_data',['type'=>$post_type,'action_post'=>'edit','post'=>$p->id])!!}" target="_blank">{!!$p->title!!}</a> <i class="remove">x</i></span>
				<?php
			}	
		}
	 ?>


</div>

<div class="clearfix"></div>




<script src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>
    <script src="{!!asset('')!!}vendors/bootstrap/js/bootstrap.min.js?v=1"></script>

<script type="text/javascript">
	
	$(window).load(function(){


		
		$('#modal-many-record .modal-title', window.parent.document).text('{!!$admin_object['title']!!} [{!!$posts->total()!!}]');
		
		function get_valueTemp(){
			var value = $('.valueTemp .item').map(function(){
		      return $(this).data('value');
		    }).get();
		    return value;
		}


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
		};

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

		$('input[name="chose[]"]').change(function() {
	        if(this.checked) {
	            $(this).prop("checked", true);
	        	if( $('.valueTemp .item.input'+$(this).val()).length < 1 ){
	        		$('.valueTemp').append('<span data-value="'+$(this).val()+'" class="item btn btn-default input'+$(this).val()+'"><a href="{!!route('admin.create_data',['type'=>$post_type,'action_post'=>'edit'])!!}&post='+$(this).val()+'" target="_blank">'+$(this).closest('.container').text()+'</a> <i class="remove">x</i></span>');
	        	}
	        }else{
	        	$('.valueTemp .item.input'+$(this).val()).remove();
	        }

    		window.parent.resizeIframe($('#modal-many-record iframe',window.parent.document)[0]);
	        
			var value = get_valueTemp();
		 	window.history.pushState("object or string", "Page",  replaceUrlParam(window.location.href, 'value', value.join(',')));
	    });


		@if( $type === 'only' )

			$('#formSubmit').submit(function(event){
				event.preventDefault();

				value = $('input[name="chose"]:checked').val();

				if( !value ){
					$('.show-many-record.selected', window.parent.document).html('Click to add');
				}else{
					$('.show-many-record.selected', window.parent.document).html('<input type="hidden" name="'+$('.show-many-record.selected', window.parent.document).data('name')+'" value="'+value+'" >'+$('input[name="chose"]:checked').closest('.container').text());
				}
				@if( $onchange = Request::get('onchange') )
				window.parent.{!!$onchange!!}(value);
				@endif
				window.parent.$('#modal-many-record').modal('hide');

			});

		@elseif( $type === 'multi')

			$(document).on('click','.pagination a:not(.active)',function(event){

				event.preventDefault();

				var input = get_valueTemp(); // 

				window.location.href = replaceUrlParam($(this).attr('href'),'value',input.join(','));

			});

			$('#formSubmit').submit(function(event){

				event.preventDefault();


				var value = get_valueTemp();

				if( value.length < 1 ){
					$('.show-many-record.selected', window.parent.document).html('Click to add');
				}else{

					$.ajax({

						method: 'POST',
						dataType:'Json',
						data:{
							_token: '{!!csrf_token()!!}',
							posts: value,
							input_name: $('.show-many-record.selected', window.parent.document).data('name'),
							render_view: true,
							post_type: '{!!$post_type!!}',
							columns: {!!json_encode($columns)!!},
							@if( $temp = Request::get('template') )
							template: '{!!$temp!!}',
							@endif
						},
						success:function(data){
							window.parent.$('.show-many-record.selected').data('value',value.join(','));
							$('.show-many-record.selected', window.parent.document).removeClass('vn4-btn');
							$('.show-many-record.selected', window.parent.document).html(data.html);
						}

					});
					
				}

				@if( $onchange = Request::get('onchange') )
				window.parent.{!!$onchange!!}(value);
				@endif
				window.parent.$('#modal-many-record').modal('hide');

			});
		@endif
		
		var script = document.createElement('script');
        script.onload = function () {
           $( ".valueTemp" ).sortable({
           	scroll : false,
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
