<?php
$r = request();

if( $param1 === 'post' ){

    if( config('app.EXPERIENCE_MODE') ){
        return experience_mode();
    }

    $theme_option = $r->get('options');

    $result = [];

    if( $theme_option ){
        foreach ($theme_option as $key => $value) {
            foreach ($value as $key2 => $value2) {
                save_theme_options($key,$key2,$value2);
                Cache::forget('theme-options.'.theme_name().'.'.$key);
            }
        }

        $result['message'] = apiMessage('Update theme options success');
        
    }
    return $result;

}


$result = [];

if( file_exists($file = cms_path('resource','views/themes/'.theme_name().'/inc/theme-option.php')) ){
    include $file;
}
$fields = apply_filter('theme_options',[
    'definition'=> [
      'fields'=>[
        'title'=>'text',
        'favicon'=>'image'
      ]
    ],
]);

if( !is_array($fields) ) $fields = [];

foreach ($fields as $key => $value) {

    $title = $value['title']??capital_letters($key);
    $fields = $value['fields'];
    
    $result['rows'][$key] = [
        'title'=>$title,
        'fields'=>$fields,
        'value'=>theme_options($key)
    ];
}

return $result;