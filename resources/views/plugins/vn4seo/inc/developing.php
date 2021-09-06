<?php

add_action('vn4_footer',function(){

	if( !is_admin() ) { ?>
	<style type="text/css"> .s-optimize-seo:after{ content: "SEO ERROR"; position: absolute; left: 0; top: 0; background: yellow; color: black; }</style><script type="text/javascript"> let imgs = document.getElementsByTagName('img'); for (var i = 0; i < imgs.length; i++) { if ( !imgs[i].getAttribute('title') || !imgs[i].getAttribute('alt') ){ imgs[i].classList.add("s-optimize-seo"); } } </script>
	<?php
	 }

});

