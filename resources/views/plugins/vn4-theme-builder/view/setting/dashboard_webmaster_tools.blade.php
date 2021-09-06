<?php 
  title_head(__('Webmaster Tools'));
 ?>
 
<input type="hidden" name="form" value="webmaster_tools">

<h4>Webmaster Tools verification</h4>
<p>You can use the boxes below to verify with the different Webmaster Tools, if your site is already verified, you can just forget about these. Enter the verify meta values for:</p>

<?php 
	$webmaster_tools = $plugin->getMeta('webmaster-tools');
 ?>
<style type="text/css">
	.preview_file img{
		max-width: 45px;
	}
</style>
<div class="form-group">
	<div class="">
		<label>Google Search Console:</label>
		<p class="note">Please select an authentication method. <a href="https://search.google.com/u/0/search-console?resource_id={!!env('APP_URL')!!}" target="_blank">See details</a></p>
	</div>
	<div class="">

		<label>HTML file

		@if( isset($webmaster_tools['google']['file']) )
			<?php 

				$file = $webmaster_tools['google']['file'];

				if( !is_array($file) ) $file = json_decode($file,true);
				
				$file_info = pathinfo(cms_path('public',$file['link']));
			 ?>
			| <a href="{!!env('APP_URL').'/'.$file_info['basename']!!}" target="_blank">Kiểm tra</a>
		@endif

		</label>
		{!!get_field('asset-file',['value'=>isset($webmaster_tools['google']['file'])?$webmaster_tools['google']['file']:'','name'=>'webmaster-tools[google][file]','key'=>'webmaster_tools_google_file'])!!}
		<br>
		<label>Thẻ HTML</label>
		<input name="webmaster-tools[google][tag]" value="{!!isset($webmaster_tools['google']['tag'])?$webmaster_tools['google']['tag']:''!!}" type="text" id="title" class="form-control col-md-7 col-xs-12">
		<p class="note">Get your Google verification code in <a href="https://search.google.com/u/0/search-console?resource_id={!!env('APP_URL')!!}" target="_blank">Google Search Console</a>.</p>
	</div>
</div>
