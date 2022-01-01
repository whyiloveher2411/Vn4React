<?php

include __DIR__.'/__helper.php';

$id = $r->get('postID');

$postType = $r->get('postType');

$admin_object = get_admin_object();

$post = get_post( $postType, $id );

if( $post ){

    $result = [
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

    $result['success'] = true;
    
    return $result;

}

return [
    'message'=>apiMessage('Did not find the post','error')
];
