<?php 
  $id = str_replace('-', '_', str_slug($key));
 ?>
<div id="input_slug__{!!$id!!}" style="@if( !isset($postDetail) || !$postDetail ) display: none; @endif">
<input type="hidden" id="input_slug__{!!$id!!}__value_real" name="{!!$name??$key!!}" value="{!!$value!!}" >
Permalink:

<div id="input_slug__{!!$id!!}_content" style="display: inline-block;">
@if( isset($postDetail) )
  
    <?php $permalink = get_permalinks($postDetail); ?>
    <span id="input_slug__{!!$id!!}__preview"><a target="_blank" href="{!!$permalink!!}">{!!$permalink!!}</a> <span class="vn4-btn" id="input_slug__{!!$id!!}__btn_edit">Edit</span></span>
    <span style="display:none;" id="input_slug__{!!$id!!}__edit"><a class="not-href" href="#">{!!str_replace($postDetail->{$key},'</a><input class="form-control" style="line-height: 28px;display:inline-block;height:28px;resize:none;padding: 0 12px;overflow:hidden;width:auto;margin-top: -1px;" id="input_slug__'.$id.'__textarea" value="'.$postDetail->{$key}.'" /><a href="#" class="not-href">',$permalink)!!}</a> / <span class="vn4-btn " style="" id="input_slug__{!!$id!!}__btn-ok">OK</span><span class="btn btn-link input_slug__{!!$id!!}__btn-cancel" style="padding: 0px 2px;text-decoration:underline;">Cancel</a></span>

@else
  
@endif
</div>
</div>

<?php

  add_action('vn4_footer',function() use ($id,$key_slug, $type_post, $key, $postDetail){
      ?>
       <script>
          $(window).load(function(){
              $(document).on('click','#input_slug__{!!$id!!}__btn_edit',function(){
                  $('#input_slug__{!!$id!!}__preview').hide();
                  $('#input_slug__{!!$id!!}__edit').show();
              });

              $(document).on('click','.input_slug__{!!$id!!}__btn-cancel',function(){
                  $('#input_slug__{!!$id!!}__edit').hide();
                  $('#input_slug__{!!$id!!}__preview').show();
              });

              $(document).on('click','#input_slug__{!!$id!!}__btn-ok',function(){
                  if( $('#input_slug__{!!$id!!}__textarea').val() ){
                    ajaxLoadSlug{!!$id!!}($('#input_slug__{!!$id!!}__textarea').val());
                  }else{
                    alert('Error input Empty!!');
                  }
              });

              function ajaxLoadSlug{!!$id!!}(slug){
                $.ajax({
                    url:'{!!route('admin.controller',['controller'=>'post-type','method'=>'register-slug'])!!}',
                    dataType:'Json',
                    type:'post',
                    data:{
                      _token:"{!!csrf_token()!!}",
                      'slug':slug,
                      'post_type':'{!!$type_post!!}',
                      @if( isset($postDetail) && $postDetail )
                        'me_id':'{!!$postDetail->id!!}',
                      @endif
                    },
                    success:function(data){

                      var preview = '<span id="input_slug__{!!$id!!}__preview"><a class="not-href" href="#">'+data.permalinks+'</a> <span class="vn4-btn" id="input_slug__{!!$id!!}__btn_edit">Edit</span></span>';

                      $('#input_slug__{!!$id!!}_content').html(preview);

                      var edit = '<span style="display:none;" id="input_slug__{!!$id!!}__edit"><a class="not-href" href="#">'+data.permalinks.replace(data.slug, '</a><input class="form-control" style="line-height: 28px;display:inline-block;height:28px;resize:none;padding: 0 12px;overflow:hidden;width:auto;margin-top: -1px;" id="input_slug__{!!$id!!}__textarea" value="'+data.slug+'" /><a href="#" class="not-href">')+'</a> / <span class="vn4-btn " style="" id="input_slug__{!!$id!!}__btn-ok">OK</span><span class="btn btn-link input_slug__{!!$id!!}__btn-cancel" style="padding: 0px 2px;text-decoration:underline;">Cancel</a></span>';

                      $('#input_slug__{!!$id!!}_content').append(edit);

                      $('#input_slug__{!!$id!!}__value_real').val(data.slug);

                      $('#input_slug__{!!$id!!}').show();

                      if( window.__after_register_slug ){
                        window.__after_register_slug(data);
                      }
                    }
                 });
              }

              $(document).on('change','#{!!$key_slug!!}',function(){

                 ajaxLoadSlug{!!$id!!}($(this).val());

              });
          });
        </script>
      <?php
  },'registerSlug_'.$id,true);
