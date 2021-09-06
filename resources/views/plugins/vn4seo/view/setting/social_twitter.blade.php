<h4>Twitter setting</h4>
<p>Add Open Graph meta data <input type="checkbox"></p>
<p class="note">Add Open Graph meta data to your site's <code>head</code> section</p>
<p class="note"><strong>Default Setting</strong></p><br>

<div class="form-group">
	<div class="row">
		<label class="col-md-3 col-xs-12" >The default card type to use:</label>
		<div class="col-md-8 col-sm-8 col-xs-12 vn4-pd0">
			<select class="form-control" name="wpseo_social[twitter_card_type]" id="twitter_card_type" tabindex="-1" aria-hidden="true">
				<option value="summary" selected="selected">Summary</option>
				<option value="summary_large_image">Summary with large image</option>
			</select>
		</div>
	</div>
</div>


<div class="form-group">
	<div class="row">
		<label class="col-md-3 col-xs-12" > Title</label>
		<div class="col-md-8 col-sm-8 col-xs-12 vn4-pd0">
			<input name="title" required="" value="" type="text" id="title" class="form-control col-md-7 col-xs-12">
			<p class="note"></p>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<label class="col-md-3 col-xs-12" > Description</label>
		<div class="col-md-8 col-sm-8 col-xs-12 vn4-pd0">
			<textarea class="form-control col-md-7 col-xs-12" name="seo_vn4_twitter_description" rows="3"></textarea>
			<p class="note"></p>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<label class="col-md-3 col-xs-12" > Twitter image:</label>
		<div class="col-md-8 col-sm-8 col-xs-12 vn4-pd0">
			{!!get_field('image', ['key'=>'seo_vn4_twitter_image','value'=>''])!!}
		</div>
	</div>
</div>


