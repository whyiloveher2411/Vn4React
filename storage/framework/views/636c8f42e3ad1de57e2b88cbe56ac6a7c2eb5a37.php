<!DOCTYPE html>
<html <?php echo get_language_attributes(); ?> >
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php vn4_head(); ?>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,500">
		<link rel="stylesheet" href="/themes/vn4cms-ecommerce/styles/style.css">
		<script src="/themes/vn4cms-ecommerce/scripts/uikit.js"></script>
		<script src="/themes/vn4cms-ecommerce/scripts/uikit-icons.js"></script>
		<?php echo $__env->yieldContent('css'); ?>
	</head>
	<body <?php echo get_body_class(); ?>>
		<div class="uk-offcanvas-content">
			<?php the_header(); ?>
			<?php echo $__env->yieldContent('content'); ?>
			<?php the_footer(); ?>
		</div>
		
		<script src="/themes/vn4cms-ecommerce/scripts/script.js"></script>
		<?php echo $__env->yieldContent('js'); ?>
	</body>
</html>
