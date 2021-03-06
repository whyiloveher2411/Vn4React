<?php

include __DIR__.'/__helper.php';
// sleep(10);
$type = $param1;

$r = request();
$input = $r->all();

if( !isset($input['title']) || !$input['title'] ){
    return [
        'message'=>apiMessage('Title field is required','error')
    ];
}

$post = newOrEdit($input, $type, $user);

do_action('api_save_post_type', $post);
do_action('api_save_post_type_'.$post->type, $post);

updatePostRelationship($post);

$post_type = get_admin_object();

$post_type[$type]['fields']['order'] = [
    'title'=>'Order',
    'name'=>'attributes_order',
    'view'=>'number',
    'advance'=>'right',
];

if( $post && isset($post_type[$type]['public_view']) && $post_type[$type]['public_view'] ){
    $post->_permalink = get_permalinks($post);
}

$result = [
    'config'=>$post_type[$type],
    'post'=>$post,
    'author'=>null, 'editor'=>[],
    'message'=>apiMessage( isset($input['_copy']) ? 'Copy post success.' : 'Edit post success.')
];


if( $post->author ){
    $author = getAuthorPostType($post->author);
    if( $author ){
        $result['author'] = $author;
    }
}

if( $post->editor ){
    $editorID = explode(',', $post->editor);
    $result['editor'] = getEditorPostType($editorID);
}

return $result;