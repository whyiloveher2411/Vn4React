<?php $__currentLoopData = $filter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if( !isset($value['items']) ): ?>
		<?php if( $value['count'] != 0 ): ?>
	        <button class="btn btn-sm post-status <?php echo $status_current[0] === $key?'btn-primary active':''; ?>" type="button" data="<?php echo $key; ?>"> <?php echo $value['title']; ?> (<?php echo number_format($value['count']); ?>)</button>
	    <?php endif; ?>
	<?php else: ?>
		<?php
			$status_current2 = isset($status_current[1])?$status_current[1]:'';
		?>

		<div class="dropdown " style="display:inline-block;margin: 0 5px 0 0;">
		  <button style="font-weight: bold;" class="dropdown-toggle btn btn-sm dropdown-table <?php echo $status_current[0] === $key?'btn-primary active':''; ?>" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $value['title']; ?> <i class="fa fa-sort-desc" style="vertical-align: top;"></i></button>
		  <ul class="dropdown-menu" role="menu" style="margin-top:8px;">
				<?php $__currentLoopData = $value['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if( $value2['count'] != 0 ): ?>
					<li class="post-status <?php echo $status_current2 === $key2?'active':''; ?>" type="button" data="<?php echo $key,'.',$key2; ?>"><a href="#" ><label><?php echo $value2['title']; ?> (<?php echo number_format($value2['count']); ?>)</label></a></li>
			    	<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>

	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
