<?php

$path = cms_path('public',$r->get('path','uploads'));

$files = $r->file();

$result = [];

$chunk = $r->get('chunk');
$chunks = $r->get('chunks');

$fileNameChunk = $r->get('chunkName');

if( $chunk === '0' ){

    if( !file_exists( cms_path('storage','chunk' ) ) ){
        mkdir( cms_path('storage','chunk' ) , 0755, true);
    }

    $fileNameChunk = str_random().'_'.time();

    while ( file_exists( cms_path('storage', 'chunk/'.$fileNameChunk.'.part' ) ) ) {
        $fileNameChunk = str_random().'_'.time();
    }

    $result['chunkName'] = $fileNameChunk;
}

if( $chunk === $chunks ){
    $size = $r->get('size');

    $name = $r->get('name');

    $index = 2;

    $names = explode( '.', $name);

    $is_dir = isset($names[1])? false : true;
    
    $extension = $is_dir ? '' : array_pop( $names );

    $names = join('.', $names);

    while ( file_exists($path.'/'.$name) ) {
        
        if( $is_dir ){
            $name = $names.'-'.$index;
        }else{
            $name = $names.'-'.$index.'.'.$extension;
        }
        ++$index;
    }

    $chunkPath = cms_path('storage','chunk/'.$fileNameChunk);

    for ($i = 0; $i < $chunks; $i++)
    {   
        $fh = fopen( $chunkPath.$i.'.part', 'rb' );

        $buffer = fread( $fh, $size );
        fclose( $fh );

        $total = fopen( $path   .'/'.$name, 'ab' );
        $write = fwrite( $total, $buffer );
        fclose( $total );

        unlink($chunkPath.$i.'.part');
    }
    
    $result['success'] = true;

}else{

    foreach( $files as $key => $file ){

        $filenameWithOutextension = $fileNameChunk;
        $extension = $file->getClientOriginalExtension();
        $filename = $filenameWithOutextension . $r->get('chunk').'.part';

        $isMoved = $file->move( cms_path('storage', 'chunk' ), $filename); 

        if( $isMoved ){
            $result[$key] = true;
        }else{
            $result[$key] = false;
        }
    }
    $result['success'] = true;
}

return $result;
