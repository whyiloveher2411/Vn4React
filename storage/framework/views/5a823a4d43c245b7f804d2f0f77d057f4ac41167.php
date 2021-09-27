<?php $__env->startSection('content'); ?>

<?php echo get_content($post, 'content' ); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(theme_extends(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>