<?php
$plugin_keyword = $plugin->key_word;
vn4_tabs_top([
	
	'key-word'=>[
		'title'=>__p('Keyword:'.get_post_meta($post,'plugin_vn4seo_focus_keyword'),$plugin_keyword),
		'content'=>function() use ($post,$plugin_keyword,$data) {
			?>

				        <div class="x_panel">
                  <div class="x_title">
                    <h2><label><i class="fa fa-eye" aria-hidden="true"></i> {!!__p('Snippet preview',$plugin_keyword)!!} <small>(Click element to edit)</small></label></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="google-title-style">{!!$data['plugin_vn4seo_google_title']??'[Please update the title]'!!}</div>

                      <div class="google-title-input" style="display: none;text-decoration: none;padding-left: 50px;max-width: 650px;"><input type="text" name="plugin_vn4seo[plugin_vn4seo_google_title]" style="height: 27px;" value="{{$data['plugin_vn4seo_google_title']??''}}" class="form-control" ></div>
                     <div class="google-url-style" style="word-break: break-all;">{!!$data['link']??'https://www.google.com.vn'!!}</div>
                     <div class="google-description-style">{!!$data['plugin_vn4seo_google_description']??'[Please update the description]'!!}</div>
                      <div class="google-description-input" style="display: none;text-decoration: none;padding-left: 50px;max-width: 650px;">
                        <textarea class="form-control" name="plugin_vn4seo[plugin_vn4seo_google_description]">{!!$data['plugin_vn4seo_google_description']??''!!}</textarea>
                     </div>

                  </div>
                </div>

                <label style="width: 100%;">
                    <i class="fa fa-key" aria-hidden="true"></i> {!!__p('Focus keyword',$plugin_keyword)!!}
                    <input name="plugin_vn4seo[plugin_vn4seo_focus_keyword]" value="{{$data['plugin_vn4seo_focus_keyword']??''}}" type="text"  class="form-control">
                </label>
                <br>
                <br>
                <label style="width: 100%;">
                    <i class="fa fa-key" aria-hidden="true"></i> {!!__p('Canonical URL',$plugin_keyword)!!}
                    <input name="plugin_vn4seo[plugin_vn4seo_canonical_url]" value="{{$data['plugin_vn4seo_canonical_url']??''}}" type="text"  class="form-control">
                </label>
                  <p class="note">the canonical URL that this page should point to. Leave empty to default to permalink.</p>
			<?php
		}
	],
  'check-list'=>[
    'title'=>__p('Check list',$plugin_keyword),
    'content'=>function(){
      echo '<span class="label label-success">'.__('Coming Soon').'</span>';
    }
  ],

]);