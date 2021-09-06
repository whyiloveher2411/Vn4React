<?php
$input = $r->all();

$code = $input['code'];

if( !$code ) $code = '';

use_module('read_html');

$html = str_get_html($code);

$script = $html->find('script',0);

if( $script ){
    $parts = parse_url($script->src);
    parse_str($parts['query'], $query);
    if( isset($query['id']) ){
        $code = $query['id'];
    }
}

$plugin->updateMeta('code-analytics',$code);
// $plugin->updateMeta('country',$r->get('country'));


return [
    'code'=>200,
    'success'=>true,
    'plugin'=>$plugin,
    'message'=>apiMessage('Update Embed code Success.')
];