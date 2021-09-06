<?php
add_action('vn4_footer',function() use ($plugin) {
	?>
	<script type="text/javascript">
		$(window).on('load',function(){
			let script = document.createElement('script');
			script.src = '<?php echo  route('admin.plugin.controller',['plugin'=>'vn4-messenger','controller'=>'messenger','method'=>'index']); ?>';
			document.head.appendChild(script);
		});
	</script>
	<?php
});