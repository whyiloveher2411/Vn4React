<?php $__env->startSection('content'); ?>
<?php 
    // $meta = $post->getMeta('product-detail');

    $reviews = ecommerce_get_reviews($post, ['paginate'=>'page']);

    $productDetail = $post->relationship('ecom_prod_detail');

    $specifications = ecommerce_get_specifications($post);

    $catBreadcrumbs = ecommerce_categories_breadcrumbs($post);

    $price = ecommerce_the_price($post);

    $product_up_selling = ecommerce_get_product_up_selling($post);
    $product_cross_selling = ecommerce_get_product_cross_selling($post);

    $product_related = ecommerce_get_product_related($post);
    
 ?>
 <style type="text/css">
     .attribute-value{
        display: inline-block;
        border-radius: 2px;
        line-height: 22px;
        cursor: pointer;
        padding: 0;
        margin-left: 10px;
        overflow: hidden;
        position: relative;
        -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Old versions of Firefox */
                -ms-user-select: none; /* Internet Explorer/Edge */
                    user-select: none;
     }
    
     .product_attribute .list-attribute-value:not(:first-child){
        margin-top: 15px;
     }
    .product-variation--disabled{
        opacity: .4;
     }
    .product-variation--disabled a{
        cursor: not-allowed;
    }
     .attribute-template-color .product-variation--disabled{
        opacity: .2;
     }
     .tm-variations>*>:first-child, .tm-variations>.uk-active>a{
        color: black;
        border: 1px solid #b3b3b3;
     }
     .tm-variations>.uk-active>a{
        border-color: #b3b3b3;
     }
     .attribute-value .icon-tick-bold{
        display: none;
        position: absolute;
        right: 0;
        bottom: 0;
        color: #fff;
        width: 8px;
        z-index: 1;
        fill: #fff;
     }
     .attribute-value.product-attribute--selected .icon-tick-bold{
         display:block;
     }
     .attribute-value.product-attribute--selected:after{
        content: "";
        border: 15px solid transparent;
        border-bottom: 15px solid var(--brand-primary-color,#ee4d2d);
        position: absolute;
        right: 0;
        bottom: 0;
        transform: translateX(calc(100% - 15px));
     }
     .attribute-value.product-attribute--selected a{
        position: relative;
        color: #d0011b;
        border-color: #d0011b;
     }
     .attribute-value.active-variable{
        background: green;
     }
    
     .vn4cms-svg-icon {
        height: 10px;
     }
 </style>
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">

                        <?php $__currentLoopData = $catBreadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo $link['link']; ?>"><?php echo $link['title']; ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- <li><a href="index-2">Home</a></li>
                        <li><a href="catalog">Catalog</a></li>
                        <li><a href="category">Laptops &amp; Tablets</a></li>
                        <li><a href="subcategory">Laptops</a></li> -->
                        <li><span><?php echo $post->title; ?></span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom"><?php echo $post->title; ?></h1>
                </div>
                <div>
                    <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                <div class="uk-grid-small uk-grid-collapse uk-grid-match" uk-grid>
                                    <div class="uk-width-1-1 uk-width-expand@m">
                                        <div class="uk-grid-collapse uk-child-width-1-1"
                                            uk-slideshow="finite: true; ratio: 4:3;" uk-grid>
                                            <div>
                                                <ul class="uk-slideshow-items" uk-lightbox>

                                                    <?php 
                                                        $thumbnail = get_media($post->thumbnail);
                                                        $gallery = get_media($post->gallery, []);
                                                     ?>
                                                    <li><a class="uk-card-body tm-media-box tm-media-box-zoom"
                                                            href="<?php echo $thumbnail; ?>">
                                                            <figure class="tm-media-box-wrap"><img
                                                                    src="<?php echo $thumbnail; ?>"
                                                                    alt="<?php echo $post->title; ?>">
                                                            </figure>
                                                        </a></li>

                                                    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a class="uk-card-body tm-media-box tm-media-box-zoom"
                                                            href="<?php echo $img; ?>">
                                                            <figure class="tm-media-box-wrap"><img src="<?php echo $img; ?>" alt="<?php echo $post->title; ?>" >
                                                            </figure>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                            </div>
                                            <div>
                                                <div class="uk-card-body uk-flex uk-flex-center">
                                                    <div class="uk-width-1-2 uk-visible@s">
                                                        <div uk-slider="finite: true">
                                                            <div class="uk-position-relative">
                                                                <div class="uk-slider-container">
                                                                    <ul class="tm-slider-items uk-slider-items uk-child-width-1-4 uk-grid uk-grid-small">

                                                                        <li uk-slideshow-item="0">
                                                                            <div class="tm-ratio tm-ratio-1-1">
                                                                                <a class="tm-media-box tm-media-box-frame">
                                                                                    <figure class="tm-media-box-wrap">
                                                                                        <img src="<?php echo $thumbnail; ?>" alt="<?php echo $post->title; ?>">
                                                                                    </figure>
                                                                                </a>
                                                                            </div>
                                                                        </li>

                                                                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li uk-slideshow-item="<?php echo $index + 1; ?>">
                                                                            <div class="tm-ratio tm-ratio-1-1">
                                                                                <a class="tm-media-box tm-media-box-frame" href="#">
                                                                                    <figure class="tm-media-box-wrap">
                                                                                        <img src="<?php echo $img; ?>" alt="<?php echo $post->title; ?>">
                                                                                    </figure>
                                                                                </a>
                                                                            </div>
                                                                        </li>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                    </ul>
                                                                    <div>
                                                                        <a class="uk-position-center-left-out uk-position-small" href="#" uk-slider-item="previous" uk-slidenav-previous></a>
                                                                        <a class="uk-position-center-right-out uk-position-small" href="#" uk-slider-item="next" uk-slidenav-next></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="uk-slideshow-nav uk-dotnav uk-hidden@s"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-1 uk-width-1-3@m tm-product-info">
                                        <div class="uk-card-body">
                                            <div><a href="#" title="Apple"><img src="/themes/vn4cms-ecommerce/images/brands/apple.svg"
                                                        alt="Apple" style="height: 40px;"></a></div>
                                            <div class="uk-margin">
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-flex uk-flex-middle">
                                                        <ul
                                                            class="uk-iconnav uk-margin-xsmall-bottom tm-rating">
                                                            <li><span class="uk-text-warning"
                                                                    uk-icon="star"></span></li>
                                                            <li><span class="uk-text-warning"
                                                                    uk-icon="star"></span></li>
                                                            <li><span class="uk-text-warning"
                                                                    uk-icon="star"></span></li>
                                                            <li><span class="uk-text-warning"
                                                                    uk-icon="star"></span></li>
                                                            <li><span class="uk-text-warning"
                                                                    uk-icon="star"></span></li>
                                                        </ul>
                                                        <div class="uk-margin-xsmall-left"><a
                                                                class="uk-text-meta js-scroll-to-description"
                                                                href="#description"
                                                                onclick="UIkit.switcher('.js-product-switcher').show(3);">(<?php echo $reviews->total(); ?>)</a>
                                                        </div>
                                                    </div>
                                                    <div><span
                                                            class="uk-label uk-label-warning uk-margin-xsmall-right">top
                                                            selling</span><span
                                                            class="uk-label uk-label-danger uk-margin-xsmall-right">trade-in</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-margin">
                                                <?php ecommerce_show_specifications($post); ?>
                                            </div>

                                            <p class="product-attribute__stock"></p>
                                            <div class="uk-margin">
                                                <div
                                                    class="uk-padding-small uk-background-primary-lighten uk-border-rounded">
                                                    <div class="uk-grid-small uk-child-width-1-1" uk-grid>

                                                        <div>
                                                            <?php if( $price && isset($price['price']) && isset($price['compare_price']) && $price['price'] !== $price['compare_price'] ): ?>
                                                                <del class="uk-text-meta product-attribute__price--compare"><?php echo $price['compare_price']; ?></del>
                                                            <?php endif; ?>
                                                            <?php if( isset($price['compare_price']) ): ?>
                                                            <div class="tm-product-price product-attribute__price"><?php echo $price['price']; ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <div class="uk-grid-small" uk-grid>

                                                                <div class="vn4cms-input-quantity">
                                                                    <a uk-icon="icon: minus; ratio: .75" class="btn-down"></a>
                                                                    <input class="uk-input tm-quantity-input input-quantity" id="product-1" type="text" maxlength="3" value="1" />
                                                                    <a uk-icon="icon: plus; ratio: .75" class="btn-up"></a>
                                                                </div>

                                                                <div><button
                                                                        class="uk-button uk-button-primary tm-product-add-button tm-shine js-add-to-cart">add
                                                                        to cart</button></div>
                                                                <div
                                                                    class="uk-width-auto uk-width-expand@s uk-flex uk-flex-middle uk-text-meta">
                                                                    <a class="uk-margin-small-right js-add-to js-add-to-favorites tm-action-button-active js-added-to"
                                                                        uk-tooltip="Add to favorites"><span
                                                                            uk-icon="heart"></span></a><a
                                                                        class="js-add-to js-add-to-compare tm-action-button-active js-added-to"
                                                                        uk-tooltip="Add to compare"><span
                                                                            uk-icon="copy"></span></a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-margin">
                                                <div
                                                    class="uk-padding-small uk-background-muted uk-border-rounded">
                                                    <div class="uk-grid-small uk-child-width-1-1 uk-text-small"
                                                        uk-grid>
                                                        <div>
                                                            <div class="uk-grid-collapse" uk-grid><span
                                                                    class="uk-margin-xsmall-right"
                                                                    uk-icon="cart"></span>
                                                                <div>
                                                                    <div class="uk-text-bolder">Delivery</div>
                                                                    <div class="uk-text-xsmall uk-text-muted">In
                                                                        stock, free, tomorrow</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-grid-collapse" uk-grid><span
                                                                    class="uk-margin-xsmall-right"
                                                                    uk-icon="location"></span>
                                                                <div>
                                                                    <div class="uk-text-bolder">Pick up from
                                                                        store</div>
                                                                    <div class="uk-text-xsmall uk-text-muted">In
                                                                        stock, free, tomorrow</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-margin">
                                                <?php echo $post->description; ?>

                                                <div class="uk-margin-small-top"><a
                                                        class="uk-link-heading js-scroll-to-description"
                                                        href="#description"
                                                        onclick="UIkit.switcher('.js-product-switcher').show(1);"><span
                                                            class="tm-pseudo">Detailed
                                                            specifications</span><span
                                                            class="uk-margin-xsmall-left"
                                                            uk-icon="icon: chevron-down; ratio: .75;"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-1 tm-product-description" id="description">
                                        <header>
                                            <nav class="tm-product-nav"
                                                uk-sticky="offset: 60; bottom: #description; cls-active: tm-product-nav-fixed;">
                                                <ul class="uk-subnav uk-subnav-pill js-product-switcher"
                                                    uk-switcher="connect: .js-tabs">
                                                    <li><a class="js-scroll-to-description"
                                                            href="#description">Overview</a></li>
                                                    <li><a class="js-scroll-to-description"
                                                            href="#description">Specifications</a></li>
                                                    <li>
                                                        <a class="js-scroll-to-description" href="#description">
                                                            Accessories <span>(<?php echo count($product_up_selling) + count($product_cross_selling); ?>)</span>
                                                        </a>
                                                    </li>
                                                    <li><a class="js-scroll-to-description"
                                                            href="#description">Reviews
                                                            <span>(<?php echo $reviews->total(); ?>)</span></a></li>
                                                    <li><a class="js-scroll-to-description"
                                                            href="#description">Q&A</a></li>
                                                </ul>
                                            </nav>
                                        </header>
                                        <div class="uk-card-body">
                                            <div class="uk-switcher js-product-switcher js-tabs">
                                                <section>
                                                    <article class="uk-article">
                                                        <div class="uk-article-body">
                                                            <?php echo get_content($productDetail, 'detailed_overview' ); ?>

                                                        </div>
                                                    </article>
                                                </section>
                                                <section>

                                                <?php if( is_array($specifications) ): ?>
                                                     <?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <h2><?php echo $group['title']; ?></h2>

                                                    <table
                                                        class="uk-table uk-table-divider uk-table-justify uk-table-responsive">
                                                        <?php $__currentLoopData = $group['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <th class="uk-width-medium"><?php echo $value['title']; ?></th>
                                                            <td class="uk-table-expand"><?php echo $value['value']; ?></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </table>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </section>
                                                <section>
                                                    <div class="tm-wrapper">
                                                        <div class="uk-grid-collapse uk-child-width-1-3@s uk-child-width-1-4@m tm-products-grid"
                                                            uk-grid>
                                                            <?php $__currentLoopData = $product_up_selling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo get_particle('product-single',['product'=>$product]); ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $__currentLoopData = $product_cross_selling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo get_particle('product-single',['product'=>$product]); ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section>
                                                    <div class="uk-grid-small uk-grid-divider" uk-grid>
                                                        <div
                                                            class="uk-width-1-1 uk-width-1-5@s uk-text-center tm-reviews-column">
                                                            <div class="uk-text-meta uk-text-uppercase">average
                                                                rating</div>
                                                            <div class="uk-heading-primary">5.0</div>
                                                            <div class="uk-flex uk-flex-center">
                                                                <ul class="uk-iconnav tm-rating">
                                                                    <li><span class="uk-text-warning"
                                                                            uk-icon="star"></span></li>
                                                                    <li><span class="uk-text-warning"
                                                                            uk-icon="star"></span></li>
                                                                    <li><span class="uk-text-warning"
                                                                            uk-icon="star"></span></li>
                                                                    <li><span class="uk-text-warning"
                                                                            uk-icon="star"></span></li>
                                                                    <li><span class="uk-text-warning"
                                                                            uk-icon="star"></span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="uk-margin-small-top uk-text-meta">based
                                                                on <?php echo $reviews->total(); ?> reviews</div><button
                                                                class="uk-button uk-button-primary uk-margin-top uk-width-1-1"
                                                                uk-toggle="target: #review">write a
                                                                review</button>
                                                        </div>
                                                        <div class="uk-width-1-1 uk-width-expand@s">
                                                            <div class="uk-grid-small uk-grid-divider uk-child-width-1-1"
                                                                uk-grid>


                                                                 <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <article>
                                                                    <section
                                                                        class="uk-grid-small uk-child-width-1-1"
                                                                        uk-grid>
                                                                        <header>
                                                                            <div class="uk-h4 uk-margin-remove"><?php echo $p->title; ?></div>
                                                                            <time class="uk-text-meta"><?php echo get_date($p->created_at); ?></time>
                                                                        </header>
                                                                        <div>
                                                                            <ul class="uk-iconnav uk-margin-bottom tm-rating">
                                                                                <?php for($i = 1 ; $i <= 5; $i ++ ): ?>
                                                                                    <li>
                                                                                        <span class=" <?php if( $i <= $p->rating ): ?> uk-text-warning <?php endif; ?>" uk-icon="star"></span>
                                                                                    </li>
                                                                                <?php endfor; ?>
                                                                            </ul>
                                                                            <div>
                                                                                <p><?php echo $p->detail; ?></p>
                                                                            </div>
                                                                            <div class="uk-grid-small uk-flex-middle uk-margin-top"
                                                                                uk-grid>
                                                                                <div class="uk-text-meta">Was
                                                                                    this review helpful to you?
                                                                                </div>
                                                                                <div><button
                                                                                        class="uk-button uk-button-default uk-button-small">Yes<span
                                                                                            class="uk-margin-xsmall-left uk-text-muted">14</span></button><button
                                                                                        class="uk-button uk-button-default uk-button-small uk-margin-small-left">No<span
                                                                                            class="uk-margin-xsmall-left uk-text-muted">2</span></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </section>
                                                                </article>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                                <?php echo get_paginate($reviews,'default'); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section>
                                                    <ul class="uk-list-divider uk-list-large"
                                                        uk-accordion="multiple: true">

                                                        <?php 
                                                            $faq = json_decode($productDetail->question_and_answer,true);
                                                         ?>

                                                         <?php if( isset($faq) && is_array($faq)) foreach($faq as $p): if(!$p['delete']): ?>
                                                        <li><a class="uk-accordion-title" href="#"><?php echo $p['question']; ?></a>
                                                            <div class="uk-accordion-content"><?php echo $p['answer']; ?></div>
                                                        </li>
                                                        <?php endif; endforeach; ?>

                                                    </ul>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Related items-->

                        <?php if( count($product_related) ): ?>
                        <section>
                            <div uk-slider="finite: true">
                                <div class="uk-grid-small uk-flex-middle uk-margin-bottom" uk-grid>
                                    <h2 class="uk-width-expand uk-text-center uk-text-left@s">Related Products
                                    </h2>
                                    <div class="uk-visible@s"><a class="tm-slidenav" href="#"
                                            uk-slider-item="previous" uk-slidenav-previous></a><a
                                            class="tm-slidenav" href="#" uk-slider-item="next"
                                            uk-slidenav-next></a></div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                        <div class="uk-position-relative">
                                            <div class="uk-slider-container">
                                                <div
                                                    class="uk-slider-items uk-grid-collapse uk-child-width-1-3 uk-child-width-1-4@m tm-products-grid">
                                                    <?php $__currentLoopData = $product_related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo get_particle('product-single',['product'=>$product]); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul
                                        class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-top uk-hidden@s">
                                    </ul>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>
                        
                    </div>
                    <div id="review" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body"><button class="uk-modal-close-outside"
                                type="button" uk-close></button>
                            <h2 class="uk-modal-title uk-text-center">Review</h2>
                            <form class="uk-form-stacked">
                                <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                                    <div><label>
                                            <div class="uk-form-label uk-form-label-required">Name</div><input
                                                class="uk-input" type="text" required>
                                        </label></div>
                                    <div><label>
                                            <div class="uk-form-label uk-form-label-required">Email</div><input
                                                class="uk-input" type="email" required>
                                        </label></div>
                                    <div>
                                        <div class="uk-form-label">Rating</div>
                                        <ul class="uk-iconnav tm-rating">
                                            <li><a uk-icon="star"></a></li>
                                            <li><a uk-icon="star"></a></li>
                                            <li><a uk-icon="star"></a></li>
                                            <li><a uk-icon="star"></a></li>
                                            <li><a uk-icon="star"></a></li>
                                        </ul>
                                    </div>
                                    <div><label>
                                            <div class="uk-form-label uk-form-label-required">Review</div>
                                            <textarea class="uk-textarea" rows="5" required></textarea>
                                        </label></div>
                                    <div class="uk-text-center"><button
                                            class="uk-button uk-button-primary">Send</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo get_particle('commitment'); ?>

</main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    
    window.addEventListener('load',function(){

        window.__ecommerce_post_detail = <?php echo $productDetail; ?>;

        window.__ecommerce_config = {
            class_attribute_selected: 'product-attribute--selected',
            class_attribute_disabled: 'product-variation--disabled',
            selector_message_stock: '.product-attribute__stock',
            message_in_stock: '<span style="color:green;"> {quantity} sản phẩm có sẵn</span>',
            message_out_stock: '<span style="color:red;">Đã hết hàng</span>',
            message_not_variation: '<span style="color:red;">Phiên bản này không tồn tại</span>',
            selector_input_quantity: '.input-quantity',
            selector_button_up_quantity: '.vn4cms-input-quantity .btn-up',
            selector_button_down_quantity: '.vn4cms-input-quantity .btn-down',
            elementHtml_price: document.body.querySelector('.product-attribute__price'),
            elementHtml_compare_price: document.body.querySelector('.product-attribute__price--compare'),
            currency_symbol:'$',
            position_of_currency_symbol: true, //true: before; false: after 
            message_not_update_price: '(not update)',
        };

        window.__ecommerce_post_detail.flag = {};
        window.__ecommerce_post_detail.flag = {
            count_attribute: 0,
        };

        __ecommerce_post_detail.variations = JSON.parse( __ecommerce_post_detail.variations );
        

        let KeyDelete = Object.keys( __ecommerce_post_detail.variations ).filter( key => __ecommerce_post_detail.variations[key].delete );

        __ecommerce_post_detail.variationsDevoid = KeyDelete.map( key => __ecommerce_post_detail.variations[key] );
        
        __ecommerce_post_detail.variations = Object.keys( __ecommerce_post_detail.variations )
                                            .filter( key => !__ecommerce_post_detail.variations[key].delete )
                                            .map( key => __ecommerce_post_detail.variations[key] );
        let variable_attribute = [];

        for (let i in __ecommerce_post_detail.variations) {

            for( let index in __ecommerce_post_detail.variations[i].attributes ){

                let name_attribute = __ecommerce_post_detail.variations[i].attributes[index].id;
                let idAttribute = __ecommerce_post_detail.variations[i].attributes[index].ecom_prod_attr;
                
                if( !variable_attribute[idAttribute] ) variable_attribute[idAttribute] = [];
                if( !variable_attribute[idAttribute][ name_attribute ] ) variable_attribute[idAttribute][ name_attribute ] = [];

                for( let index2 in __ecommerce_post_detail.variations[i].attributes ){

                    let idAttribute2 = __ecommerce_post_detail.variations[i].attributes[index2].ecom_prod_attr;
                    
                    if( idAttribute != idAttribute2 ){

                        let attribute_value_id = __ecommerce_post_detail.variations[i].attributes[index2].id;

                        if( !variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ] ) variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ] = [];

                        if(  variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ].indexOf( attribute_value_id ) == -1 ){
                             variable_attribute[ idAttribute ][ name_attribute ][ idAttribute2 ].push(attribute_value_id);
                        }
                    }
                }
            }
        }

        String.prototype.replaceArray = function(find, replace) {
          var replaceString = this;
          var regex; 
          for (var i = 0; i < find.length; i++) {
            regex = new RegExp(find[i], "g");
            replaceString = replaceString.replace(regex, replace[i]);
          }
          return replaceString;
        };

        window.__ecommerce_post_detail.flag.count_attribute = Object.keys(variable_attribute).length;

        function ecommerce_get_price(price){
            if( __ecommerce_config.position_of_currency_symbol ){
                return __ecommerce_config.currency_symbol+(new Intl.NumberFormat().format(price));
            }else{
                return (new Intl.NumberFormat().format(price)) +__ecommerce_config.currency_symbol;
            }
        } 

        function change_attribute(){

            if( this.classList.contains( __ecommerce_config.class_attribute_disabled ) ) return;
            
            this.classList.add('__clicked');

            let value = this.attributes.value.value*1,
                parent = this.closest('.list-attribute-value'),
                attibute_id = parent.dataset.id,
                attribute_chose = parent.attributes['data-id'].value*1,
                product_attribute = parent.closest('.product_attribute'),
                product_attribute_value = product_attribute.querySelectorAll('.list-attribute-value'),
                list_attribute_active = [],
                list_attribute_not_active = [],
                list_detail_after_choose = [],
                list_attribute_can_choose = [],
                list_attribute_not_disable = [];

            parent.querySelectorAll('.attribute-value.'+__ecommerce_config.class_attribute_selected+':not(.__clicked)').forEach( (el, index) => {
                el.classList.remove( __ecommerce_config.class_attribute_selected);
            });

            this.classList.toggle( __ecommerce_config.class_attribute_selected );
            this.classList.remove('__clicked'); 

            let active = this.classList.contains( __ecommerce_config.class_attribute_selected );

            product_attribute_value.forEach( (el, index) => {
                let product_attribute_value_active = el.querySelector('.attribute-value.'+__ecommerce_config.class_attribute_selected);
                
                if( product_attribute_value_active ){
                    list_attribute_active.push({'id': el.attributes['data-id'].value,
                        title:  product_attribute_value_active.attributes.title.value, 
                        value: product_attribute_value_active.attributes.value.value });
                }
            });
           
            for( let i in __ecommerce_post_detail.variations ){

                let variable = __ecommerce_post_detail.variations[i];

                let dk = true;

                for ( let attribute of list_attribute_active ){

                    if(  variable.attributes.filter( item => item.ecom_prod_attr*1 === attribute.id*1 && item.id*1 === attribute.value*1).length < 1 ){
                        dk = false;
                        break;
                    }
                }

                if( dk ){
                    list_detail_after_choose.push(variable);
                }
            }

            product_attribute.querySelectorAll('.attribute-value').forEach( (el, index)=>{
                el.classList.remove(__ecommerce_config.class_attribute_disabled);
            });

            product_attribute_value.forEach( attribute => {

                attribute.querySelectorAll( '.attribute-value ').forEach( valueElement => {

                    let searchRegex = [];

                    product_attribute_value.forEach( attribute2 => {

                        if( attribute.dataset.id !== attribute2.dataset.id ){
                            let actived = attribute2.querySelector('.attribute-value.'+__ecommerce_config.class_attribute_selected);
                            
                            if( actived ){
                                searchRegex.push( actived.attributes.value.value );
                            }else{
                                searchRegex.push( '((\\d)*)' );
                            }
                        }else{
                            searchRegex.push(  valueElement.attributes.value.value );
                        }

                    });

                    
                    let regex = new RegExp ( searchRegex.join('_'), 'i');

                    let variations = __ecommerce_post_detail.variations.filter( item =>   item.key.match( regex ) );

                    if( variations.length < 1 ){
                        valueElement.classList.add(__ecommerce_config.class_attribute_disabled);
                    }
                    
                });
            });

            document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = '';

            if( list_attribute_active.length == window.__ecommerce_post_detail.flag.count_attribute){
                
                if( list_detail_after_choose.length == 1){

                    window.__ecommerce_post_detail.variable_current = list_detail_after_choose[0];

                    if( list_detail_after_choose[0].quantity ){

                        document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_in_stock.replaceArray(['{quantity}'],[list_detail_after_choose[0].quantity]);

                        let input_quantity = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );

                        if( input_quantity.value > list_detail_after_choose[0].quantity*1 ){
                            input_quantity.value = list_detail_after_choose[0].quantity;
                        }


                    }else{
                        document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_out_stock;
                    }

                    if( __ecommerce_config.elementHtml_price && __ecommerce_config.elementHtml_compare_price ){

                        if( __ecommerce_post_detail.variable_current.compare_price ){
                            __ecommerce_config.elementHtml_price.innerText =  ecommerce_get_price(__ecommerce_post_detail.variable_current.price);
                            __ecommerce_config.elementHtml_compare_price.innerText = ecommerce_get_price(__ecommerce_post_detail.variable_current.compare_price);
                        }else{

                            if( __ecommerce_post_detail.variable_current.price ){
                                __ecommerce_config.elementHtml_price.innerText = ecommerce_get_price(__ecommerce_post_detail.variable_current.price);
                                __ecommerce_config.elementHtml_compare_price.innerText = '';
                            }else{
                                __ecommerce_config.elementHtml_price.innerText = __ecommerce_config.message_not_update_price;
                                __ecommerce_config.elementHtml_compare_price.innerText = '';
                            }
                        }
                    }
                }else{
                     window.__ecommerce_post_detail.variable_current = false;
                     document.body.querySelector( window.__ecommerce_config.selector_message_stock ).innerHTML = __ecommerce_config.message_not_variation;
                }
            }
        }

        document.querySelectorAll('.attribute-value').forEach( element => {
            element.addEventListener('click', change_attribute);
        });

        document.body.querySelector( __ecommerce_config.selector_button_down_quantity ).addEventListener('click',function(){
            let input = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );
            if( input.value < 2){
                input.value = 1;
            }else{
                input.value--;
            }
        });

        document.body.querySelector( __ecommerce_config.selector_button_up_quantity ).addEventListener('click',function(){
            let input = document.body.querySelector( window.__ecommerce_config.selector_input_quantity );

            if( window.__ecommerce_post_detail.variable_current && input.value >= window.__ecommerce_post_detail.variable_current.stock*1 ){
                input.value = window.__ecommerce_post_detail.variable_current.stock*1;
            }else{
                input.value++;
            }
        });
        
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(theme_extends(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>