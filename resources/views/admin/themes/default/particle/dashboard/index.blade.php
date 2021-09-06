<html>
<?php 
    title_head(__('Dashboard'));
	$templateWidget = get_data_dashboard();

	$user = Auth::user();
	$dashboard_view = $user->getMeta('dashboard-view');

	$dashboard_title = '[Click to Setup dashboards]';
	$dashboard_blade = false;


	if( isset($templateWidget[$dashboard_view]['title']) ){

		if( view()->exists($templateWidget[$dashboard_view]['view']) ){
			$dashboard_title = $templateWidget[$dashboard_view]['title'];
			$dashboard_blade =  $templateWidget[$dashboard_view]['view'];
		}
	}

    $user = Auth::user();
    $mode =  $user->getMeta('admin_mode',['light-mode','Light Mode']);

    $class_body = $user->getMeta('collapse',false)?'collapse-body':'nav-md';

    do_action('admin_after_open_head'); 

    $isFrame = Request::has('iframe');
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
     <link rel="stylesheet" type="text/css" href="{!!asset('admin/css/mode/'.$mode[0].'.css')!!}">
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style type="text/css">
      *{
        font-family: Roboto, sans-serif;
        margin: 0;
        padding: 0;
        color: #222;
        text-decoration: none;
      }
      .icon-refesh{
        position: absolute;
        right: 0;
        top: 0;
        z-index: 999;
        height: 20px;
      }
    </style>
    <script type="text/javascript">
		jQuery = window.parent.$;
    </script>
  </head>



<body>

<style type="text/css">
	.container.body .right_col{
		padding: 0;
	}
</style>
 <div style="min-height: 500px;">
 	@if( $dashboard_blade )
		@include( $dashboard_blade )
	@endif
</div>
<script src="@asset()vendors/jquery/jquery.min.js?v=1"></script>
<script src="@asset()vendors/bootstrap/js/bootstrap.min.js?v=1"></script>
 <script src="@asset()admin/js/main.js?v=1"></script>
<script type="text/javascript">


	$(window).load(function(){
		var isInIframe = (window.location != window.parent.location) ? true : false;
		if(!isInIframe){
			window.location.href = '{!!route('admin.index')!!}';
		}
		function update_height_iframe(){
			var body = document.body,
            html = document.documentElement;
            var height = $('.right_col').height();
            document.body.style.height = height + 'px';
			$('#iframe-dashboard',window.parent.document).css({'height': height+'px'});
		}

        let $html = $('<i style="font-size:11px;" class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;<div class="dropdown"><a href="?dashboard=google-realtime" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$dashboard_title}}</a><ul class="dropdown-menu dropdown-menu-right" role="menu">@foreach($templateWidget as $key => $page) <li><a href="javascript:void(0)" class="widget-item" data-type="{!!$key!!}"><label><i class="fa {{$page['icon']}}" aria-hidden="true"></i>&nbsp;&nbsp; {{$page['title']}}</label></a></li> @endforeach</ul></div>');

        $('li a',$html).on('click',function(){
        	window.parent.vn4_ajax({
        		url: '{!!route('admin.controller',['controller'=>'dashboard','method'=>'update-view-open'])!!}',
        		data:{
        			view: $(this).data('type')
        		},
        		callback:function(result){
        			console.log(result);
        		}
        	});
        });

        $('.title-master .pull-left',window.parent.document).append($html);
	});
</script>
<?php do_action('vn4_footer'); ?>
@yield('js')
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
