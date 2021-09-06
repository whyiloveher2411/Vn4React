<?php
add_action('vn4_head',function() use ($plugin) {
	?>
      <meta class="load-more" data-type="css" content="<?php echo plugin_asset($plugin, 'vendor/bootstrap-tour.min.css'); ?>">
      <meta class="load-more" data-type="js" content="<?php echo plugin_asset($plugin, 'vendor/bootstrap-tour.min.js'); ?>">
      <meta class="load-more" data-type="js" content="<?php echo route('admin.plugin.controller',['plugin'=>$plugin->key_word,'controller'=>'js','method'=>'main.js','route'=>Route::currentRouteName(),'parameters'=>json_encode(Route::current()->parameters)]); ?>">
	<?php
});