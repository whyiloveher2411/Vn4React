@extends(backend_theme('master'))
<?php 
	title_head('Search');

	
	$searchArray = include backend_resources('page/search/search.php');

	add_action('vn4_heading',function() use ($searchArray) {

		$changel = Request::get('vn4-tab-left-keyword');

		if( isset($searchArray[$changel]) && $changel !== 'default' ){
			echo '<div style="width: auto;" class="input-group"><div class="input-group-addon">'.Request::get('vn4-tab-left-keyword').'</div><input name="q" value="'.Request::get('q').'" placeholder="Search" type="text" id="inputSearchPage" style="max-width:100%;width:300px;" class="form-control"></div>';
		}else{
			echo '<input name="q" value="'.Request::get('q').'" placeholder="Search" type="text" id="inputSearchPage" style="max-width:100%;width:300px;" class="form-control">';
		}

	});
	


	$list_tab_search = [];

	$admin_object = get_admin_object();

   

	foreach ($searchArray as $key => $value) {

		$list_tab_search[$key] = [
			'title'=>$value['title'],
			'content'=>function() use ($admin_object , $searchArray,$key )   {
				$searchRequest = Request::get('q','')??'';

			 	$search = $key.':'.$searchRequest;

			    $stringSearchArray = [$key,$searchRequest];

			    $keySearch = $key;

				$channel = 'default';

		        if( isset($searchArray[$keySearch]) && isset($stringSearchArray[1]) ){
		            $channel = $keySearch;
		        }

		        if( $channel === 'default' ){
		        	$search = $searchRequest;
			    	$stringSearchArray = [$searchRequest];
			    	$keySearch = $searchRequest;
		        }


				$data = [];

		        if( is_array($searchArray[$channel]) && isset($searchArray[$channel]['callback']) ){

		            if( is_callable($searchArray[$channel]['callback']) ){
		                $data = $searchArray[$channel]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
		            }elseif( isset( $searchArray[$searchArray[$channel]['callback']] ) ){
		                $data = $searchArray[$searchArray[$channel]['callback']]['callback']( $stringSearchArray, $search, $keySearch, $admin_object );
		            }

		        }

		        if( $channel === 'default' ){
					echo '<h3>Keyword: "'.$searchRequest.'"</h3>';
		        }else{
					echo '<h3>Keyword: "'.$search.'"</h3>';
		        }


		        foreach ($data as $key => $value) {
		        	echo '<p><a href="'.$value['link'].'">['.$value['title_type'].'] '.$value['title'].'</a></p>';
		        }
			},
		];
	}
 ?>

@section('content')

<style>
.vn4_tabs_left{
    display: flex;
      -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
    -moz-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
}
.vn4_tabs_left>.clearfix{
  width: 0;
}
.vn4_tabs_left .content-right{
    background: #fff;
    width: 100%;
    display: block;
    margin: 0;
}
.vn4_tabs_left .menu-left{
    flex: 1;
    min-width: 240px;
    display: contents;
}
.vn4_tabs_left .menu-left ul{
  margin: 0;

}
.vn4_tabs_left .menu-left li{
    text-align: left;
    margin: 0;
    background-color: #F2F0F0;
}
.vn4_tabs_left .menu-left a{

    white-space: nowrap;
    display: block;
    padding: 13px 19px;
        -webkit-box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
    -moz-box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
    box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
}
.vn4_tabs_left .tab{
  margin: 15px;
}
.vn4_tabs_left .menu-left li.active a{
  background: #fff;
}
</style>
	<div class="" >
   		 <?php vn4_tabs_left($list_tab_search,true,'keyword'); ?>
	</div>
@stop

@section('js')
	<script type="text/javascript">
		$(window).load(function(){
			$(document).on('keydown','#inputSearchPage',function(event){
				
				if (event.keyCode == 13) {
					window.location.href = replaceUrlParam(window.location.href, 'q',$(this).val());
				}
			});
		});
	</script>
@stop