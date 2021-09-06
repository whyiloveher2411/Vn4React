<?php 
    $name = $name??$key;
    $type = $type??'null';
    $type_post = $type_post??$object;
 ?>
@if( $type === 'many_record' )
    
    <?php
        use_module('many_record');
    ?>

    <span class="relationship_mn_select show-many-record" required id="fieldonly_{!!$key!!}" 
        data-post-detail-type="{!!$type_post!!}" 
        data-post-detail-field="{!!$key!!}" 
        data-post="{!!$postDetail->id??0!!}" 
        data-post-type="{!!$object!!}" 
        data-value="{!!$value!!}" 
        data-type="only" 
        data-input-change="fieldonly_{!!$key!!}" 
        data-name="{{$name}}" 
        data-where="{{http_build_query($where??[])}}"
        @if(isset($data)) 
        @foreach($data as $key=>$value)
        data-{!!$key!!}="{{json_encode($value)??$value}}"
        @endforeach
        @endif 
        >
    <?php
        if( $object_value = Request::get('relationship_field_'.$key, $value) ){
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

@else

<?php

// $posts = Vn4Model::table(get_admin_object($object_relationship)['table'])->where('type',$object_relationship)->orderBy('created_at','asc');
$posts = do_action('get_post_controller',request(),$object, $postDetail??null );
// dd($posts);
if( !$posts ) $posts = get_posts($object,['count'=>10000,'order'=>['created_at','asc']]);

$data = $posts->groupBy('id');
// dd($data[1][0]);

$ids = $posts->pluck('parent','id')->toArray();
// dd($ids);
foreach ($ids as $k => $v) {
    if( !array_key_exists($v , $ids) ){
        $ids[$k] = null;
    }
}

// dd($ids);

if( !function_exists('parseTree') ){
    function parseTree($tree, $root = null, $data) {
        $return = array();
        # Traverse the tree and search for direct children of the root
        foreach($tree as $child => $parent) {
            # A direct child is found
            if($parent == $root) {
                # Remove item from tree (we don't need to traverse this again)
                unset($tree[$child]);
                # Append the child into result array and parse its children
                $return[] = array(
                    'detail' => $data[$child][0],
                    'children' => parseTree($tree, $child, $data)
                );
            }
        }
        return empty($return) ? null : $return;    
    }
}

$posts = parseTree($ids, null, $data );

if( !is_array($posts) ) $posts = [];

if( $value = Request::get('relationship_field_'.$key, $value) ){

}

if( !function_exists('show_option') ){


    function show_option($option, $me,  $value, $prefix = '' ){

        $str = '';

        foreach ($option as $p) {
            
            if( $me != $p['detail']->id ){
                $str .= '<option value="'.$p['detail']->id.'"'.($value == $p['detail']->id?' selected="selected"':'').'>'.$prefix.$p['detail']->title.'</option>';  

                if( isset($p['children'][0] ) ){
                    $str .= show_option($p['children'],$me, $value,$prefix.' ... ');
                }
            }

        }

        return $str;

    }
}

if( isset(Route::current()->parameters['type']) && Route::current()->parameters['type'] == $object && Request::get('action_post','none') === 'edit' ){
    $post_id = Request::get('post',0);
}else{
    $post_id = 0;
}

$required = ( !isset($required) || $required !== true ) ? false:true ;
    
 ?>

<select class="form-control relationship_mm_select select2" name="{{isset($name)?$name:$key}}" id="{!!$key!!}" data-object="{!!$object!!}" data-value="{!!$value!!}">
@if( !$required )
    <option value="">--Select--</option>
@endif
{!!show_option($posts, $post_id, $value)!!}
</select>

<?php
add_action('vn4_head',function(){
   ?>
      <link href="{{asset('')}}vendors/select2/dist/css/select2.min.css" rel="stylesheet">
   <?php
},'select2 css', true);

add_action('vn4_footer',function() use ($key){
  ?>
    <script src="{{asset('')}}vendors/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(window).load(function(){
            $(".select2").select2({
              placeholder: "Nhấp để chọn",
              allowClear: true,
            });
        });
    </script>
  <?php
},'select2', true);
?>

@endif