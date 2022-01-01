<?php
$r = request();
include __DIR__.'/__helper.php';

$admin_object = get_admin_object();

if( !isset($admin_object[$param1]) ){
    return [
        'redirect'=>'/error404'
    ];
}

$config = getPostTypeConfig($param1);

$post = Vn4Model::table($config['table'])->where('type',$param1)->where('id',$param2)->first();

if( $post && isset($config['public_view']) && $config['public_view'] ){
    $post->_permalink = get_permalinks($post);
}

$result = [
	'config'=>$config,
	'post'=>$post,
	'author'=>null, 'editor'=>[]
];

if($post && $post->author ){
    $author = getAuthorPostType($post->author);
    if( $author ){
        $result['author'] = $author;
    }
}

if($post && $post->editor ){
    $editorID = explode(',', $post->editor);
    $result['editor'] = getEditorPostType($editorID);
}

return $result;