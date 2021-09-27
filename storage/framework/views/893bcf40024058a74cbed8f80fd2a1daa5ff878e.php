<nav class="uk-visible@m">
    <ul class="uk-navbar-nav">
        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuLevel1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a href="<?php echo $menuLevel1['link']; ?>">
                <?php echo $menuLevel1['label']; ?>

                <?php if( isset($menuLevel1['children'][0]) ): ?>
                <span class="uk-margin-xsmall-left" uk-icon="icon: chevron-down; ratio: .75;"></span>
                <?php endif; ?>
            </a>
            <?php if( isset($menuLevel1['children'][0]) ): ?>
            <div class="uk-navbar-dropdown uk-margin-remove uk-padding-remove-vertical"
                uk-drop="pos: bottom-justify;delay-show: 125;delay-hide: 50;duration: 75;boundary: .tm-navbar-container;boundary-align: true;pos: bottom-justify;flip: x">
                <div class="uk-container">
                    <ul class="uk-navbar-dropdown-grid uk-child-width-1-5" uk-grid>
                        <?php $__currentLoopData = $menuLevel1['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuLevel2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="uk-margin-top uk-margin-bottom">
                                <a href="<?php echo $menuLevel2['link']; ?>" class="uk-link-reset" href="category">
                                    <?php if( isset($menuLevel2['more_information'][0]['type']) && $menuLevel2['more_information'][0]['type'] === 'image' ): ?>
                                    <img class="uk-display-block uk-margin-auto uk-margin-bottom" src="<?php echo get_media($menuLevel2['more_information'][0]['value']); ?>" alt="Laptops &amp; Tablets" width="80" height="80">
                                    <?php endif; ?>
                                    <div class="uk-text-bolder"><?php echo $menuLevel2['label']; ?></div>
                                </a>
                                <?php if( isset($menuLevel2['children'][0]) ): ?>
                                <ul class="uk-nav uk-nav-default">
                                    <?php $__currentLoopData = $menuLevel2['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuLevel3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo $menuLevel3['link']; ?>"><?php echo $menuLevel3['label']; ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</nav>