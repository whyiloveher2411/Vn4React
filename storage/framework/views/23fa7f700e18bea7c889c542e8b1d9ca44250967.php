<div class="list-attribute-value" data-id="<?php echo $data['id']; ?>">
    <div class="uk-text-small uk-margin-xsmall-bottom"><?php echo $data['title']; ?></div>
    <ul class="uk-subnav uk-subnav-pill tm-variations row"
        uk-switcher>
        <?php $__currentLoopData = $data['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li value="<?php echo $value['id']; ?>" title="<?php echo $value['title']; ?>" class="attribute-value">
            <a>
                <?php echo $value['title']; ?>

                <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="svg-icon icon-tick-bold"><g class=""><path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path></g></svg>
            </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>