@extends(theme_extends())

@section('content')
<?php
    $section = $post->section;
?>

@forif( $section as $s)
    {!!get_particle('particle.sections.'.$s['type'], ['data'=>$s, 'post'=>$post])!!}
@endforif

@stop