
@if( !isset( $type ) || $type == 'input_check')


<div class="form-group relationship_nn form-warpper-{!!$key!!}"><div class="content_relationship_nn"></div></div>

<?php

    add_action('vn4_footer',function() use ($key,$value, $object, $__env){
        ?>
            <script>
                    $(window).load(function() {

                        @php
                            $admin_object = get_admin_object($object);

                            $show_truct = false;

                            foreach ($admin_object['fields'] as $key99 => $value99) {
                                if( isset($value99['view']) && $value99['view'] === 'relationship_onetoone' && $value99['object'] === $object ){
                                    $show_truct = $key99;
                                }
                            }
                         @endphp

                         @if( $show_truct )

                         function add_children(options,key, children){

                            $dk = false;

                            for (var i = 0; i < options.length; i++) {

                                if( !options[i]['children'] ){
                                    options[i ]['children'] = [];
                                }

                                if( key == options[i]['@id'] ){
                                    $dk = true;
                                    options[i]['children'] = options[i]['children'].concat(children);
                                    break;
                                }


                                if( options[i]['children'].length > 0 ){
                                    $dk2 = add_children(options[i]['children'],key, children);

                                    if( $dk2 ){
                                        options[i]['children'] = $dk2;
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
                            
                            for (var i = 2; i <= options2.length; i++) {
                                count = count * i;
                            }

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

                            if( options.length > 0 ){
                               for (var i = 0; i < options.length; i++) {

                                    checked = '';

                                    if( $.grep(values, function(e){ return e.@id == options[i].@id; }).length != 0 ){
                                        checked = 'checked="checked"';
                                    }

                                    str += '<label >'+prefix_str+'<input '+checked+' type="checkbox" title="'+options[i].title+'" name="{{$key}}[]" value="'+options[i].@id+'" id="'+options[i].@id+'{{$key}}"> '+options[i].title+'</label><br>';

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
                                         for (var item in posts){

                                            checked = '';

                                            if( $.grep(values, function(e){ return e.@id == posts[item].@id; }).length != 0 ){
                                                checked = 'checked="checked"';
                                            }

                                            warpper.append('<label ><input '+checked+' type="checkbox" title="'+posts[item].title+'" name="{{$key}}[]" value="'+posts[item].@id+'" id="'+posts[item].@id+'{{$key}}"> '+posts[item].title+'</label><br>');
                                        }
                                    @endif
                                }});
                           
                        }, 500);
                        
                    });
            </script>
        <?php
    });
 ?>

@else

<?php 
    $value = json_decode($value,true);

    $string_value = '';

    if( $value && isset($value[0])){
        foreach ($value as $tag) {
            $string_value = $string_value.','.$tag['title'];
        }
    }

    $string_value = substr($string_value, 1);
 ?>

<input id="{!!$key!!}" name="{!!$key!!}" type="text" class="tags view-tags form-control" value="{!!$string_value!!}" />
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

@endif