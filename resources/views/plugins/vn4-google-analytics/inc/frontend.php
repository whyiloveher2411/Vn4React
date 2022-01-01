<?php

if( ($code = setting('google_analytics/embed_code',false) ) && !check_user_agent('bot') ){
	add_action('vn4_footer',function() use ($plugin, $code) {
		?><script type="text/javascript">window.addEventListener('load',()=>{var g = document.createElement('script');var s = document.getElementsByTagName('script')[0];g.src="https://www.googletagmanager.com/gtag/js?id=<?php echo $code; ?>";	s.parentNode.insertBefore(g, s);var g = document.createElement('script');var s = document.getElementsByTagName('script')[0];g.text=`window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo $code; ?>');`;s.parentNode.insertBefore(g, s);});</script><?php
	},'vn4-google-analytics',true);

}