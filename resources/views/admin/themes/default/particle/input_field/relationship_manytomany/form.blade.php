<?php 
    $name = $name??$key;

    $type = $type??'input_check';

    $type_post = $type_post??$object;
 ?>


@if( $type == 'input_check')


<div class="form-group relationship_nn form-warpper-{!!$key!!}"><div class="content_relationship_nn"></div></div>

<?php
    add_action('vn4_footer',function() use ($key,$name, $value, $object, $__env){
        ?>
            <script>
                    $(window).load(function() {

                        @php
                            $admin_object = get_admin_object($object);

                            $show_truct = false;

                            foreach ($admin_object['fields'] as $key99 => $value99) {
                                if( isset($value99['view']) && $value99['view'] === 'relationship_onetomany' && $value99['object'] === $object ){
                                    $show_truct = $key99;
                                }
                            }
                         @endphp

                         @if( $show_truct )

                            function add_children(options,key, children){
                                $dk = false;
                                let key2;
                                for (key2 in options) {


                                    if( !options[key2]['children'] ){
                                        options[key2]['children'] = [];
                                    }

                                    if( ( options[key2]['@id']['$oid'] && key == options[key2]['@id']['$oid'] ) || key == options[key2]['@id']  ){
                                        $dk = true;
                                        options[key2]['children'] = options[key2]['children'].concat(children);
                                        break;
                                    }


                                    if( Object.keys(options[key2]['children']).length > 0 ){

                                        $dk2 = add_children(options[key2]['children'],key, children);

                                        if( $dk2 ){
                                            options[key2]['children'] = $dk2;
                                            $dk = true;
                                            break;
                                        }
                                    }
                                }

                                if( $dk ){
                                    return options;
                                }
                                return false;
                            }

                            function covert_to_tree(options){

                                    let options1 = [];
                                    let options2 = [];

                                    for (var i = 0; i < options.length; i++) {
                                        if( !options[i]['{!!$show_truct!!}'] ){
                                            options1.push(options[i]);
                                        }else{

                                            if( !options2[options[i]['{!!$show_truct!!}']] ){
                                                options2[options[i]['{!!$show_truct!!}']] = [];
                                            }
                                            options2[options[i]['{!!$show_truct!!}']].push(options[i]);
                                        }
                                    }
                        
                                    let count = 1;
                                    i = 2;
                                    for (key in options2) {
                                        count = count * i;
                                        i++;
                                    }

                                    count = 1000;
                                    let index = 0;

                                    while( Object.keys(options2).length > 0 && index < count ){

                                        for (var k in options2){

                                            $dk = add_children(options1,k, options2[k]);
                                            if( $dk ){
                                                options1 = $dk;
                                                index = -1;
                                                delete options2[k];
                                            }  

                                        }

                                        index++;
                                    }
                                    return options1;

                            }

                            function show_option(options, prefix_str, values ){
                                    var str = '';
                                    let value;
                                    if( options.length > 0 ){
                                       for (var i = 0; i < options.length; i++) {

                                            checked = '';
                                            if( $.grep(values, function(e){ return e.@id == options[i].@id['$oid'] || ( e.@id && e.@id == options[i].@id ) ; }).length != 0 ){
                                                checked = 'checked="checked"';
                                            }

                                            value = options[i].@id;

                                            if( value['$oid'] ) value = value['$oid'];

                                            str += '<label >'+prefix_str+'<input '+checked+' type="checkbox" title="'+options[i].title+'" name="{{$name}}[]" value="'+value+'" id="'+value+'{{$key}}"> '+options[i].title+'</label>';

                                            if ( options[i].children ){
                                                str += show_option(options[i].children, prefix_str+'&nbsp;&nbsp;&nbsp;&nbsp;', values);
                                            }

                                        } 
                                    }else if(prefix_str==''){
                                        str = '<p class="note">@__('No data available, You can add ')<a href="{!!route('admin.create_and_show_data',['type'=>$key,'ref'=>'add-post'])!!}">@__('here')</a></p>';
                                    }
                                    

                                    return str;

                            }

                         @endif

                        setTimeout(function() {

                                
                            data = {
                                    @php 
                                        $input = Request::all();
                                        $route_param = $GLOBALS['route_current']->parameters();
                                    @endphp
                                    type: '{!!$object!!}',
                                     @foreach( $input as $k => $i)
                                        '{!!$k!!}':'{!!$i!!}',
                                     @endforeach
                                     route_name:'{!!$GLOBALS['route_name']!!}',
                                     @foreach( $route_param as $k => $i)
                                        'route_{!!$k!!}':'{!!$i!!}',
                                     @endforeach
                                     ajax_get_data_relationships_nn:true,
                                };

                            $.each($(".input_hidden_ajax"), function (index, el) {
                                data[$(el).attr('name')] = $(el).val();
                            });

                            vn4_ajax({'url':"{!!route('admin.controller',['controller'=>'post-type','method'=>'get-category'])!!}",
                                data:data,
                                'type':'GET','callback':function(data){
                                var warpper =  $('.form-group.form-warpper-{!!$key!!} .content_relationship_nn'),
                                posts = data.data,

                                values = {!! trim($value) != '' ?  $value : '{}' !!};

                                warpper.empty();

                                @if( $show_truct )

                                    posts.sort(function(a,b) {
                                        return a.{!!$show_truct!!} - b.{!!$show_truct!!}||a.@id - b.@id;
                                    });
                                    posts = covert_to_tree(posts);

                                    warpper.append(show_option(posts,'',values));

                                @else

                                    if( posts.length ){
                                         for (var item in posts){

                                            checked = '';

                                            if( $.grep(values, function(e){ return e.@id == posts[item].@id; }).length != 0 ){
                                                checked = 'checked="checked"';
                                            }

                                            warpper.append('<label ><input '+checked+' type="checkbox" title="'+posts[item].title+'" name="{{$name}}[]" value="'+posts[item].@id+'" id="'+posts[item].@id+'{{$key}}"> '+posts[item].title+'</label>');
                                        }
                                    }else{

                                        warpper.append('<p class="note">@__('No data available, You can add ')<a href="{!!route('admin.create_and_show_data',['type'=>$key,'ref'=>'add-post'])!!}">@__('here')</a></p>');
                                    }

                                   


                                @endif
                            }});
                           
                        }, 500);
                        
                    });
            </script>
        <?php
    });
 ?>

@elseif( $type === 'select2')

<div class="form-group relationship_nn form-warpper-{!!$key!!}">
<select class="form-control select2 content_relationship_nn" id="{!!$key!!}" name="{{$name}}[]" multiple >
</select>
</div>

<?php
    // dd($post);
    add_action('vn4_footer',function() use ($key,$value, $object, $__env, $name){
        ?>
            <script>
                    $(window).load(function() {

                        setTimeout(function() {

                                
                            data = {
                                    @php 
                                        $input = Request::all();
                                        $route_param = $GLOBALS['route_current']->parameters();
                                    @endphp
                                    type: '{!!$object!!}',
                                     @foreach( $input as $k => $i)
                                        '{!!$k!!}':'{!!$i!!}',
                                     @endforeach
                                     route_name:'{!!$GLOBALS['route_name']!!}',
                                     @foreach( $route_param as $k => $i)
                                        'route_{!!$k!!}':'{!!$i!!}',
                                     @endforeach
                                     ajax_get_data_relationships_nn:true,
                                };

                            $.each($(".input_hidden_ajax"), function (index, el) {
                                data[$(el).attr('name')] = $(el).val();
                            });

                            vn4_ajax({'url':"{!!route('admin.controller',['controller'=>'post-type','method'=>'get-category'])!!}",
                                data:data,
                                'type':'GET','callback':function(data){
                                var warpper =  $('.form-group.form-warpper-{!!$key!!} .content_relationship_nn'),
                                posts = data.data,

                                values = {!! trim($value) != '' ?  $value : '{}' !!};

                                warpper.empty();
                                if( posts.length ){
                                     for (var item in posts){

                                        checked = '';

                                        if( $.grep(values, function(e){ return e.@id == posts[item].@id; }).length != 0 ){
                                            checked = 'selected';
                                        }

                                        warpper.append('<option '+checked+' title="'+posts[item].title+'" value="'+posts[item].@id+'" id="'+posts[item].@id+'{{$key}}"> '+posts[item].title+'</option>');
                                    }
                                }else{

                                    $('.form-group.form-warpper-{!!$key!!}').html('<p class="note">@__('No data available, You can add ')<a href="{!!route('admin.create_and_show_data',['type'=>$key,'ref'=>'add-post'])!!}">@__('here')</a></p>');
                                }

                                $(".select2").select2({
                                  placeholder: "Nhấp để chọn",
                                  allowClear: true
                                });

                            }});
                           
                        }, 500);
                        
                    });
            </script>
        <?php
    });

    add_action('vn4_head',function(){
       ?>
          <link href="{!!asset('')!!}/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
       <?php
    },'select2 css', true);

    add_action('vn4_footer',function() use ($key){
      ?>
        <script src="{!!asset('')!!}/vendors/select2/dist/js/select2.full.min.js"></script>
        <script>
            $(".select2").select2({
              placeholder: "Nhấp để chọn",
              allowClear: true
            });
        </script>
      <?php
    },'select2', true);

 ?>

@elseif( $type === 'tags' )

<?php 
    $value = json_decode($value,true);

    $string_value = '';

    if( $value && isset($value[0])){
        foreach ($value as $tag) {
            if( get_post($object,$tag[Vn4Model::$id]) ){
                $string_value = $string_value.','.$tag['title'];
            }
        }
    }

    $string_value = substr($string_value, 1);
 ?>

<input id="{!!$key!!}" name="{!!$name!!}" type="text" class="tags view-tags form-control" value="{!!$string_value!!}" />
<p class="note">@__('press enter or "," to add') @__($title)</p>
<?php 

add_load_javascript_unique(asset('vendors/jquery.tagsinput/src/jquery.tagsinput.js'), 'vn4_footer');

add_action('vn4_footer',function() use ($value, $title) {
    ?>
     <script>

        
        $('.view-tags').mouseenter(function(event) {
            $(this).tagsInput({
              width: 'auto',
              defaultText: 'Thêm thẻ'
            });
        });

        @if( $value !== '' )
            setTimeout(function() {
                $('.view-tags').tagsInput({
                  width: 'auto',
                  defaultText: '@__('Add') @__($title)'
                });
            }, 1000);
        @endif

     </script>
    <?php
},'tags_javscript',true);

 ?>

@elseif( $type === 'many_record' )
    <?php 
        use_module('many_record');

        $data_value = [];

        if( is_array($value) ){

            $posts = [];
            if( !is_array($value[0]) ){
                $posts = get_posts( $object, ['callback'=>function($q) use ($value){ $q->whereIn(Vn4Model::$id, $value)->orderByRaw('FIELD('.Vn4Model::$id.', '.implode(',',$value).')'); }]);

                foreach ($posts as $p) {
                    $data_value[] = $p->{Vn4Model::$id};
                }
            }



        }else{

            if( $object_value = Request::get('relationship_field_'.$key) ){

                if( $post = get_post($object,$object_value) ){
                    $value = json_encode([$post->toArray()]);
                    $data_value = [$post->id];
                }

            }

            if( is_string($value) ){
                $posts = json_decode($value);
            }else{
                $posts = $value;
            }

            if( is_array($posts) ){
                foreach ($posts as $p) {
                    $data_value[] = @$p->{Vn4Model::$id};
                }
            }

        }


     ?>


 <div class="relationship_mm_select show-many-record" required id="fieldnn_{!!$key!!}" 
    data-post-detail-type="{!!$type_post!!}" 
    data-post-detail-field="{!!$key!!}" 
    data-post="{!!$postDetail->id??0!!}" 
    data-post-type="{!!$object!!}" 
    data-value="{!!implode(',',$data_value)!!}" 
    data-type="multi" 
    data-input-change="fieldnn_{!!$key!!}" 
    data-name="{{$name}}[]"
    data-where="{{http_build_query($where??[])}}"
    @if(isset($data)) 
    @foreach($data as $key=>$value)
    data-{!!$key!!}="{{json_encode($value)??$value}}"
    @endforeach
    @endif 
     >

 @if( isset($posts[0]) )

    <?php 
        $admin_object = get_admin_object($object);

        // if( isset($admin_object['show']) ){

        if( isset($data['template']) ){

            $callback = function($post) use ($admin_object, $name, $data) {
                return '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.e($name).'[]" value="'.$post->{Vn4Model::$id}.'" >'.view($data['template'],['post'=>$post]).'<i class="fa fa-times remove-item-relationship"></i></div>';
            };

        }else{
            if( isset($template) ){
                $callback = function($post) use ($admin_object, $name, $template) {
                    return '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.e($name).'[]" value="'.$post->{Vn4Model::$id}.'" >'.$template($post).'<i class="fa fa-times remove-item-relationship"></i></div>';
                };

            }else{


                $callback = function($post) use ($name) {
                    return '<div class="vn4-btn margin-2dot5"><input type="hidden" name="'.e($name).'[]" value="'.$post->{Vn4Model::$id}.'" >'.$post->title.'<i class="fa fa-times remove-item-relationship"></i></div>';
                };
                
            }
        }

     ?>
    @foreach($posts as $p)
        {!!$callback($p)!!}
    @endforeach
 @else
    Click to add
 @endif
    
</div>

@endif