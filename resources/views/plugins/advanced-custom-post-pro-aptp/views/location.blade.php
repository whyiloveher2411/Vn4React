<tr>
    <td class="param">
        <select class="form-control select-param" name="location[{!!$index1!!}][{!!$index2!!}][param]">
            <optgroup label="Basic">
                <option @if( $g['param'] === 'post-type') selected="selected" @endif value="post-type" data-rule-type="post-type">Post Type</option>
            </optgroup>
            @foreach($get_admin_object as $k => $v)
            @if( !isset($v['is_post_system']) || !$v['is_post_system'])
            <optgroup label="{!!$v['title']!!}">
                <option @if( $g['param'] === $k.'_id' ) selected="selected" @endif value="{!!$k!!}_id" data-type-post="{!!$k!!}" data-rule-type="post">{!!$v['title']!!}</option>

                @if ($v['public_view'] )
                <option @if( $g['param'] === $k.'_template' ) selected="selected" @endif value="{!!$k!!}_template" data-type-post="{!!$k!!}" data-rule-type="template">{!!$v['title']!!} Template</option>
                @endif
            </optgroup>
            @endif
            @endforeach
        </select>
    </td>
    <td class="operator">
        <select class="form-control select-operator" name="location[{!!$index1!!}][{!!$index2!!}][operator]">
            <option @if( $g['operator'] === '==' ) selected="selected" @endif value="==">is equal to</option>
            <option @if( $g['operator'] === '!=' ) selected="selected" @endif value="!=">is not equal to</option>
        </select>
    </td>
    <td class="value">
        <select class="form-control select-value" name="location[{!!$index1!!}][{!!$index2!!}][value]">

            @if( $g['param'] === 'post-type' )
            @foreach($get_admin_object as $k => $v)
            @if( !isset($v['is_post_system']) || !$v['is_post_system'])
            <option @if( $g['value'] === $k ) selected="selected" @endif value="{!!$k!!}">{!!$v['title']!!}</option>
            @endif
            @endforeach
            @elseif( substr($g['param'],-3) === '_id' )
                <?php 
                    $admin_object = get_admin_object(substr($g['param'],0,-3));
                    $posts = Vn4Model::table($admin_object['table'])->limit(10000)->get([Vn4Model::$id,'title']);
                    // $posts = get_posts(substr($g['param'],0,-3),[])
                ?>
                @foreach($posts as $p)
                <option @if($p->id == $g['value']) selected="selected" @endif value="{!!$p->id!!}">{!!$p->title!!}</option>
                @endforeach
            @else
                <option value="">Default</option>
                <?php  
                    $postType = substr($g['param'],0,-9);

                    if( file_exists(cms_path('resource').'views/themes/'.theme_name().'/post-type/'.$postType.'/') ){

                        $file_page = File::allFiles(cms_path('resource').'views/themes/'.theme_name().'/post-type/'.$postType);

                        sort($file_page);
                        
                        foreach($file_page as $page){

                              $name = explode('/', $page->getFilename());

                              $name = substr(end($name), 0, -10);

                              $file_content = File::get($page->getRealPath());

                              $tokens = token_get_all($file_content);

                              $comment_first = ucwords(preg_replace('/-/', ' ', str_slug($name)));

                              foreach($tokens as $token) {
                                  if($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                                        $comment_first = $token[1];
                                        break;
                                  }
                              }

                          $v = basename($page,'.blade.php');
                          ?>
                            <option @if($g['value'] === $v) selected="selected" @endif value="{!!$v!!}">{!!__t(trim(preg_replace('/[\/\*\r\n]/', '', $comment_first)))!!}</option>
                          <?php
                        }
                    }
                ?>
            @endif
        </select>
    </td>
    <td class="add"><span class="vn4-btn btn-add-location">And</span></td>
    <td class="remove"><span class="circle"><i class="fa fa-minus"></i></span></td>
</tr>