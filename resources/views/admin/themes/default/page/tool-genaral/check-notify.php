<?php 
$notify = Cache::remember( 'notify', 1440, function(){

	$data = [];

	$website_cms = 'https://vn4cms.com';

	if( file_exists(cms_path('root','cms.json')) ){
		$info = json_decode(file_get_contents(cms_path('root','cms.json')),true);
		$product_code = ['Vn4CMS'=>$info['version']];
		$website_cms = $info['website'];
	}else{
		$product_code = ['Vn4CMS'=>'1.0.0'];
	}


	$plugins = plugins();

	foreach ($plugins as $plugin) {

		if( file_exists(cms_path('resource','views/plugins/'.$plugin->key_word)) ){
			$info = json_decode(file_get_contents(cms_path('resource','views/plugins/'.$plugin->key_word.'/info.json')),true);
			$product_code[$info['name']] = $info['version'];
		}else{
			break;
		}

	  	if( file_exists(cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/notify.php')) ){
		    include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/notify.php');
	  	}
	}

	$theme_name = theme_name();

	$info = json_decode(file_get_contents(cms_path('resource','views/themes/'.$theme_name.'/info.json')),true);
	$product_code[$info['name']] = $info['version'];


	if( file_exists(cms_path('resource','views/themes/'.$theme_name.'/inc/notify.php')) ){
	 	include cms_path('resource','views/themes/'.$theme_name.'/inc/notify.php');
	}

	$host = parse_url(env('APP_URL'));
	
	$host = $host['host']??'';

	$checkNotifySystem = json_decode(file_post_contents_curl($website_cms.'/api/notify',['access_token'=>setting('license_token'),'url'=>$host,'product'=>json_encode($product_code)]),true);
	
	if( !is_array($checkNotifySystem) ) $checkNotifySystem = [];

	$notify = array_merge($checkNotifySystem, $data);

	$notify = apply_filter('check-notify',$notify);

	$dirs = array_filter(glob(cms_path('public','../site/*')), 'is_dir');
	$site = [];
	foreach ($dirs as $w) {
		if( file_exists( $file = $w.'/info.json' ) ){
			$site[] = json_decode(file_get_contents( $file ),true);
		}
	}

	return ['notify'=>$notify,'websites'=>$site];
});
// dd($notify);
$data = $notify['notify'];

echo '<head></head><body style="height: 0;margin:0;display:inline-block;width:100%;" id="body"><script>var isInIframe = (window.location != window.parent.location) ? true : false;var notify = window.parent.document.getElementById(\'notify-menu\'), newfeed = window.parent.document.getElementById("newfeed")?window.parent.document.getElementById("newfeed"):{innerHTML:\'\'};if( isInIframe ){';

foreach ($notify['websites'] as $site) {
	echo 'window.parent.$(".multi-site").append(\'<a style="'.($_SERVER['HTTP_HOST'] === $site['domain']?'background:#ebedf0;':'').'" href="'.$site['admin'].'">'.$site['name'].' - '.$site['domain'].'</a>\');';
}


if( check_permission('websites_view') ){
	echo 'window.parent.$(".multi-site").append(\'<a style="border-top: 1px solid #D8D8D8;text-align:center;line-height: 26px;" data-popup="1" href="#" data-title="'.__('Domain Management').'" data-iframe="'.route('admin.page','websites').'">'.__('Domain Management').'</a>\');';
}


$not_show = true;

foreach ($data as $k => $v) {

	if( isset($v['message']) ){

		if( !isset($v['avatar']) ) $v['avatar'] = asset('admin/images/face_user_default.jpg');
		if( !isset($v['color']) ) $v['color'] = '#3b5999';
		if( !isset($v['name']) ) $v['name'] = '[Incognito]';

		if( isset($v['place']) ){

			$not_show = false;
			$message = $v['message'];
			$acction_script = $v['acction_script']??'';

			if( isset($v['route']) && is_array($v['route']) ){
				foreach ($v['route'] as $k2 => $v2) {
					$v2[1]['rel'] = 'notify';
					$message = str_replace('##'.$k2.'##', route($v2[0],$v2[1]), $message);
					$acction_script = str_replace('##'.$k2.'##', route($v2[0],$v2[1]), $acction_script);
				}
			}

			$data[$k]['message'] = $message;

			if( $acction_script ) echo $acction_script;

			if( array_search('notify', $v['place']) !== false ):

				echo 'if( notify ){notify.innerHTML+=\'<tr class="notify-item" style="border-left: 5px solid '.$v['color'].' !important;"><td class="lfloat"><img src="'.$v['avatar'].'"></td><td class="rfloat">'.$message.'<span class="name">Post By '.$v['name'].'</span></td></tr>\';}';

			endif;

			if( array_search('dashboard', $v['place']) !== false ):
				echo 'if( newfeed ){newfeed.innerHTML+= \'<div style="border-left: 5px solid '.$v['color'].' !important;">'.$message.'</div>\';}';
			endif;
		}
	}
}
if( $not_show ){
	echo 'window.parent.document.getElementById("notify").innerHTML="";';
}

echo ' if( window.parent.show_message_plugin ) window.parent.show_message_plugin('.json_encode($data).');';

echo '}else{window.location.href = \''.route('admin.index').'\';}</script><body>';
return '&nbsp;';
