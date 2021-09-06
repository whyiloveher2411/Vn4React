<?php
    $name = $name??$key;
    use_module('many_record');

    $type_post = $type_post??$object;
    
?>
<span class="relationship_mm_select show-many-record" required id="field_mm_{!!$key!!}" 
        data-post-detail-type="{!!$type_post!!}" 
        data-post-detail-field="{!!$key!!}" 
        data-post="{!!$postDetail->id??0!!}" 
        data-post-type="{!!$object!!}" 
        data-value="{!!$value!!}" 
        data-type="only" 
        data-input-change="field_mm_{!!$key!!}" 
        data-name="{{$name}}" 
        data-where="{{http_build_query($where??[])}}" 
        data-exclude-relationship-onetoone="{!!$excludeRelationshipOnetoone??true!!}" 
        @if(isset($data)) 
        @foreach($data as $key=>$value)
        data-{!!$key!!}="{{json_encode($value)??$value}}"
        @endforeach
        @endif 
        >

<?php
if( $object_value = Request::get('relationship_field_'.$key, $value) ){

    $action_post = Request::get('action_post');
    if( $action_post !== 'edit' && DB::table($type_post)->where($key,$object_value)->count() ){
        die( "<script>window.history.back();</script>" );
    }

    if( $post = get_post($object,$object_value) ){
        echo '<input type="hidden" name="'.(isset($name)?$name:$key).'" value="'.$post->id.'">'.$post->title;
    }else{
        echo 'Click to add';
    }
}else{
    echo 'Click to add';
}
?>

</span>
