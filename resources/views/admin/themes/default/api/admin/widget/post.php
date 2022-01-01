<?php
$sidebars = $r->get('sidebars');

$list_sidebar = do_action('register_sidebar',[]);

$list_widgets = use_module('widget');

$theme_name = theme_name();

// foreach ($list_sidebar as $key => $value) {

// 	$sidebarDetail = Vn4Model::table(vn4_tbpf().'widget')->where('sidebar_id',$key)->where('theme',$theme_name)->first();
// 	if( $sidebarDetail ){

// 		$list_sidebar[$key]['post'] = json_decode($sidebarDetail->content);

// 	}
// }

foreach ($list_sidebar as $key => $value) {
	
	if( isset($sidebars[$key]) ){

		$sidebarDetail = Vn4Model::firstOrAddnew(vn4_tbpf().'widget', [
			'sidebar_id'=>$key,
			'theme'=>$theme_name,
		]);

		if( is_array($sidebars[$key]['post']) ){
			
			foreach( $sidebars[$key]['post'] as $k => $v){
				$sidebars[$key]['post'][$k]['open'] = false;
			}

			$sidebarDetail->content = json_encode($sidebars[$key]['post']);
		}else{
			$sidebarDetail->content = '[]';
		}
		$sidebarDetail->setTable(vn4_tbpf().'widget');
		$sidebarDetail->save();
	}

}

return [
	'code'=>200,
	'success'=>true,
	'message'=>apiMessage('Sidebar editing successful')
];
