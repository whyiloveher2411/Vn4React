<article class="tm-product-card">
    <div class="tm-product-card-media">
        <div class="tm-ratio tm-ratio-4-3"><a
                class="tm-media-box" href="<?php echo get_permalinks($product); ?>">
                <div class="tm-product-card-labels"><span
                        class="uk-label uk-label-warning">top
                        selling</span><span
                        class="uk-label uk-label-danger">trade-in</span>
                </div>
                <figure class="tm-media-box-wrap"><img
                        src="<?php echo get_media($product->thumbnail); ?>"
                        alt="<?php echo e($product->title); ?>" />
                </figure>
            </a></div>
    </div>
    <div class="tm-product-card-body">
        <div class="tm-product-card-info">
            <div
                class="uk-text-meta uk-margin-xsmall-bottom">
                Laptop</div>
            <h3 class="tm-product-card-title">
                <a class="uk-link-heading" href="<?php echo get_permalinks($product); ?>"><?php echo $product->title; ?></a>
            </h3>
            <ul
                class="uk-list uk-text-small tm-product-card-properties">
                <li><span class="uk-text-muted">Diagonal
                        display: </span><span>15.4"</span>
                </li>
                <li><span class="uk-text-muted">CPU:
                    </span><span>Intel®&nbsp;Core™ i7</span>
                </li>
                <li><span class="uk-text-muted">RAM:
                    </span><span>16&nbsp;GB</span></li>
                <li><span class="uk-text-muted">Video Card:
                    </span><span>AMD Radeon Pro 555</span>
                </li>
            </ul>
        </div>
        <div class="tm-product-card-shop">
            <div class="tm-product-card-prices">
                <?php
                    $price = ecommerce_the_price($product);
                ?>
                <?php if( isset($price['compare_price']) && $price['compare_price'] ): ?>
                <del class="uk-text-meta"><?php echo $price['compare_price']; ?></del>
                <?php endif; ?>
                <?php if( isset($price['price']) && $price['price'] ): ?>
                <div class="tm-product-card-price"><?php echo $price['price']; ?></div>
                <?php endif; ?>
            </div>
            <div class="tm-product-card-add">
                <div
                    class="uk-text-meta tm-product-card-actions">
                    <a class="tm-product-card-action js-add-to js-add-to-favorites tm-action-button-active js-added-to"
                        title="Add to favorites"><span
                            uk-icon="icon: heart; ratio: .75;"></span><span
                            class="tm-product-card-action-text">Add
                            to favorites</span></a><a
                        class="tm-product-card-action js-add-to js-add-to-compare tm-action-button-active js-added-to"
                        title="Add to compare"><span
                            uk-icon="icon: copy; ratio: .75;"></span><span
                            class="tm-product-card-action-text">Add
                            to compare</span></a></div>
                <button
                    class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
                        class="tm-product-card-add-button-icon"
                        uk-icon="cart"></span><span
                        class="tm-product-card-add-button-text">add
                        to cart</span></button>
            </div>
        </div>
    </div>
</article>