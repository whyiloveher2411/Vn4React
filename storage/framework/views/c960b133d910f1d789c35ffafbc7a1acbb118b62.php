<title><?php echo $title; ?></title>
<script type="text/javascript">

	<?php if( setting('security_disable_iframe') ): ?>
	(window.location != window.parent.location) ? window.location.href = 'https://www.google.com/?q=vn4cms' : false;
	<?php endif; ?>
	
</script>
<link rel="icon" href="<?php echo $favicon; ?>">
<?php echo join('',$meta); ?>

