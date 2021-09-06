<?php

vn4_tabs_top([
	[
		'id'=>'facebook',
		'title'=>'<i class="fa fa-facebook" aria-hidden="true"></i>',
		'content'=>function() use ($post, $plugin, $data) {
			?>
	        <div class="form-group">
            	<label class="control-label col-md-3 col-sm-3 col-xs-12" >{!!__p('Facebook title',$plugin->key_word)!!}</label>
            	<div class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
                	<input name="plugin_vn4seo[plugin_vn4seo_facebook_title]" value="{{$data['plugin_vn4seo_facebook_title']??''}}" type="text" class="form-control col-md-7 col-xs-12">
         	 		<p class="note">{!!__p('If you don\'t want to use the post title for sharing the post on Facebook but instead want another title there, write it here',$plugin->key_word)!!}</p>
          	</div>
          </div>
          <div class="form-group">
            	<label class="control-label col-md-3 col-sm-3 col-xs-12">{!!__p('Facebook Description',$plugin->key_word)!!}
            	</label>
            	<div class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
                	<textarea class="form-control col-md-7 col-xs-12" name="plugin_vn4seo[plugin_vn4seo_facebook_description]" rows="3">{!!$data['plugin_vn4seo_facebook_description']??''!!}</textarea>
                  <p class="note">{!!__p('If you don\'t want to use the meta description for sharing the post on Facebook but want another description there, write it here',$plugin->key_word)!!}</p>
              </div>
          </div>
          <div class="form-group">
            	<label class="control-label col-md-3 col-sm-3 col-xs-12">{!!__p('Facebook Image',$plugin->key_word)!!}
            	</label>
            	<div  class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
                {!!get_field('image', ['key'=>'plugin_vn4seo_facebook_image','name'=>'plugin_vn4seo[plugin_vn4seo_facebook_image]','value'=>$data['plugin_vn4seo_facebook_image']??''] )!!}
              
              @if( $post )
              <br>
              <a href="https://developers.facebook.com/tools/debug/sharing/?q={!!get_permalinks($post)!!}" target="_blank" class="vn4-btn vn4-btn-blue">Gỡ lỗi Facebook</a>
              @endif

          	 </div>
          </div>
			<?php
		}
	],
	[
		'id'=>'twitter',
		'title'=>'<i class="fa fa-twitter" aria-hidden="true"></i>',
		'content'=>function() use ($post, $plugin, $data) {
			?>
        <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12">{!!__p('Twitter title',$plugin->key_word)!!}</label>
          	<div class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
              	<input name="plugin_vn4seo[plugin_vn4seo_twitter_title]"  value="{{$data['plugin_vn4seo_twitter_title']??''}}" type="text" class="form-control col-md-7 col-xs-12">
       	 		<p class="note">{!!__p('If you don\'t want to use the post title for sharing the post on Twitter but instead want another title there, write it here',$plugin->key_word)!!}</p>
        	</div>
        </div>
        <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12">{!!__p('Twitter Description',$plugin->key_word)!!}
          	</label>
          	<div class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
              	<textarea class="form-control col-md-7 col-xs-12" name="plugin_vn4seo[plugin_vn4seo_twitter_description]" rows="3">{!!$data['plugin_vn4seo_twitter_description']??''!!}</textarea>
                <p class="note">{!!__p('If you don\'t want to use the meta description for sharing the post on Twitter but want another description there, write it here',$plugin->key_word)!!}</p>
            </div>
        </div>
        <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12">{!!__p('Twitter Image',$plugin->key_word)!!}
          	</label>
          	<div  class="col-md-9 col-sm-9 col-xs-12 vn4-pd0">
              {!!get_field('image', ['key'=>'plugin_vn4seo_twitter_image','name'=>'plugin_vn4seo[plugin_vn4seo_twitter_image]','value'=>$data['plugin_vn4seo_twitter_image']??''] )!!}
          	 </div>

        </div>
			<?php
		}
	]
]);