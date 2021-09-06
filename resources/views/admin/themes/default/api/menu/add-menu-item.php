<?php


$r = request();

$input = json_decode($r->getContent(),true);

$key = $input['type'];

$html = '';

$menu_add_filter = apply_filter('appearance-menu');

if( isset($menu_add_filter[$key]) ){

    return $menu_add_filter[$key]['form_attr']();

}else{

    switch ($input['object_type']) {
        case '__customLink':

            $menus = [];
            $menus[] = [
                'label'=>$input['label'],
                'label_type'=>__('Custom Links'),
                'links'=>$input['links'],
                'strData'=>' data-label="'.$input['label'].'" data-links="'.$input['links'].'" data-posttype="'.$key.'" ',
                'menu_type'=>$key,
                'class' => 'custom-links'
            ];
            return ['menus'=>$menus];

        case '__page':
            
            $label_type = __('Page Theme');
            $menus = [];
            foreach ($input['data'] as  $value) {

                if( view()->exists( 'themes.'.theme_name().'.page.'.$value ) ) {

                    $label = ucwords( preg_replace('/-/', ' ', str_slug($value) )  );
                    $page = $value;

                    $menus[] = [
                        'posttype' => 'page-theme',
                        'page'=>$page,
                        'label'=>$label,
                        'label_type'=>$label_type,
                        'menu_type'=>$key,
                        'class' => 'page-theme'
                    ];
                }
            }
            return ['menus'=>$menus];

        default:
            $label_type = get_admin_object($input['object_type'])['title'];

            $menus = [];

            foreach ($input['data'] as  $value) {

                $post = get_post($input['object_type'],$value);

                if($post){

                    $menus[] = [
                        'slug'=>$post->slug,
                        'posttype'=>$post->type,
                        'id'=>$post->id,
                        'label'=>$post->title,
                        'label_type'=>$label_type,
                        'menu_type'=>$key,
                        'attrtitle'=>'',
                        'classes'=>'',
                        'description'=>'',
                        'expanded'=>true,
                        'target'=>'',
                        'xfn'=>'',
                    ];

                }

            }
            return ['menus'=>$menus];
    }
}