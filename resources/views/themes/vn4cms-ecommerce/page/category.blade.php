@extends(theme_extends())
@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><a href="catalog.html">Catalog</a></li>
                        <li><span>Laptops &amp; Tablets</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Laptops &amp; Tablets</h1>
                    <div class="uk-text-meta uk-margin-xsmall-top">367 items</div>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <aside class="uk-width-1-4 tm-aside-column tm-filters" id="filters"
                            uk-offcanvas="overlay: true; container: false;">
                            <div class="uk-offcanvas-bar uk-padding-remove">
                                <div
                                    class="uk-card uk-card-default uk-card-small uk-flex uk-flex-column uk-height-1-1">
                                    <header class="uk-card-header uk-flex uk-flex-middle">
                                        <div class="uk-grid-small uk-flex-1" uk-grid>
                                            <div class="uk-width-expand">
                                                <div class="uk-h3">Filters</div>
                                            </div><button class="uk-offcanvas-close" type="button"
                                                uk-close></button>
                                        </div>
                                    </header>
                                    <div class="uk-margin-remove uk-flex-1 uk-overflow-auto"
                                        uk-accordion="multiple: true; targets: &gt; .js-accordion-section"
                                        style="flex-basis: auto">
                                        <section class="uk-card-small uk-card-body">
                                            <h4 class="uk-margin-small-bottom">Categories</h4>
                                            <ul class="uk-nav uk-nav-default">
                                                <li><a href="subcategory.html">Laptops</a></li>
                                                <li><a href="subcategory.html">Tablets</a></li>
                                                <li><a href="subcategory.html">Peripherals</a></li>
                                                <li><a href="subcategory.html">Keyboards</a></li>
                                                <li><a href="subcategory.html">Accessories</a></li>
                                            </ul>
                                        </section>
                                        <section class="uk-card-body uk-open js-accordion-section">
                                            <h4 class="uk-accordion-title uk-margin-remove">Prices</h4>
                                            <div class="uk-accordion-content">
                                                <div class="uk-grid-small uk-child-width-1-2 uk-text-small"
                                                    uk-grid>
                                                    <div>
                                                        <div class="uk-inline"><span
                                                                class="uk-form-icon uk-text-xsmall">from</span><input
                                                                class="uk-input" type="text" placeholder="$59">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="uk-inline"><span
                                                                class="uk-form-icon uk-text-xsmall">to</span><input
                                                                class="uk-input" type="text"
                                                                placeholder="$6559"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="uk-card-body js-accordion-section uk-open">
                                            <h4 class="uk-accordion-title uk-margin-remove">Brands</h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="brand-1" name="brand"
                                                            value="1" type="checkbox"><label
                                                            for="brand-1"><span>Acer
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">177</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-2" name="brand"
                                                            value="2" type="checkbox"><label
                                                            for="brand-2"><span>Apple
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">18</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-3" name="brand"
                                                            value="3" type="checkbox"><label
                                                            for="brand-3"><span>ASUS
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">150</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-4" name="brand"
                                                            value="4" type="checkbox"><label
                                                            for="brand-4"><span>Dell
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">170</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-5" name="brand"
                                                            value="5" type="checkbox"><label
                                                            for="brand-5"><span>HP
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">498</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-6" name="brand"
                                                            value="6" type="checkbox"><label
                                                            for="brand-6"><span>MSI
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">54</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-7" name="brand"
                                                            value="7" type="checkbox"><label
                                                            for="brand-7"><span>Samsung
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">1</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="brand-8" name="brand"
                                                            value="8" type="checkbox"><label
                                                            for="brand-8"><span>Sony
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">1</span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </section>
                                        <div class="uk-card-body"><button
                                                class="uk-button uk-button-default uk-width-1-1"><span
                                                    class="uk-margin-xsmall-right"
                                                    uk-icon="icon: close; ratio: .75;"></span>Reset all
                                                filters</button></div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <div class="uk-width-expand">
                            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                        <div class="uk-grid-collapse uk-child-width-1-1" id="products" uk-grid>
                                            <div class="uk-card-header">
                                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                    <div
                                                        class="uk-width-1-1 uk-width-expand@s uk-flex uk-flex-center uk-flex-left@s uk-text-small">
                                                        <span class="uk-margin-small-right uk-text-muted">Sort
                                                            by:</span>
                                                        <ul class="uk-subnav uk-margin-remove">
                                                            <li class="uk-active uk-padding-remove"><a
                                                                    class="uk-text-lowercase"
                                                                    href="#">relevant<span
                                                                        class="uk-margin-xsmall-left"
                                                                        uk-icon="icon: chevron-down; ratio: .5;"></span></a>
                                                            </li>
                                                            <li><a class="uk-text-lowercase" href="#">price</a>
                                                            </li>
                                                            <li><a class="uk-text-lowercase" href="#">newest</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div
                                                        class="uk-width-1-1 uk-width-auto@s uk-flex uk-flex-center uk-flex-middle">
                                                        <button
                                                            class="uk-button uk-button-default uk-button-small uk-hidden@m"
                                                            uk-toggle="target: #filters"><span
                                                                class="uk-margin-xsmall-right"
                                                                uk-icon="icon: settings; ratio: .75;"></span>Filters</button>
                                                        <div class="tm-change-view uk-margin-small-left">
                                                            <ul class="uk-subnav uk-iconnav js-change-view"
                                                                uk-switcher>
                                                                <li><a class="uk-active" data-view="grid"
                                                                        uk-icon="grid" uk-tooltip="Grid"></a>
                                                                </li>
                                                                <li><a data-view="list" uk-icon="list"
                                                                        uk-tooltip="List"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-grid-collapse uk-child-width-1-3 tm-products-grid js-products-grid"
                                                    uk-grid>
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <div class="tm-product-card-labels"><span
                                                                            class="uk-label uk-label-warning">top
                                                                            selling</span><span
                                                                            class="uk-label uk-label-danger">trade-in</span>
                                                                    </div>
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/1/1-medium.jpg"
                                                                            alt="Apple MacBook Pro 15&quot; Touch Bar MPTU2LL/A 256GB (Silver)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Apple MacBook Pro
                                                                        15&quot; Touch Bar MPTU2LL/A 256GB
                                                                        (Silver)</a></h3>
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
                                                                <div class="tm-product-card-prices"><del
                                                                        class="uk-text-meta">$1899.00</del>
                                                                    <div class="tm-product-card-price">$1599.00
                                                                    </div>
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <div class="tm-product-card-labels"><span
                                                                            class="uk-label uk-label-success">new</span><span
                                                                            class="uk-label uk-label-danger">trade-in</span>
                                                                    </div>
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/2/2-medium.jpg"
                                                                            alt="Apple MacBook 12&quot; MNYN2LL/A 512GB (Rose Gold)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Apple MacBook
                                                                        12&quot; MNYN2LL/A 512GB (Rose Gold)</a>
                                                                </h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>12"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™ i5</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>8&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® HD Graphics
                                                                            615</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="tm-product-card-price">$1549.00
                                                                    </div>
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/3/3-medium.jpg"
                                                                            alt="Lenovo IdeaPad YOGA 920-13IKB 80Y7001RRK (Copper)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Lenovo IdeaPad YOGA
                                                                        920-13IKB 80Y7001RRK (Copper)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.9"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™ i7
                                                                            8550U</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>16&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® HD Graphics
                                                                            620</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="tm-product-card-price">$1199.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites tm-action-button-active js-added-to"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <div class="tm-product-card-labels"><span
                                                                            class="uk-label uk-label-warning">top
                                                                            selling</span></div>
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/4/4-medium.jpg"
                                                                            alt="ASUS Zenbook UX330UA-FC020T (Rose Gold)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">ASUS Zenbook
                                                                        UX330UA-FC020T (Rose Gold)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.3"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™
                                                                            i7-6500U</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>8&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® HD Graphics
                                                                            520</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="tm-product-card-price">$749.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/5/5-medium.jpg"
                                                                            alt="Dell XPS 15 9560-8968 (Silver)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Dell XPS 15
                                                                        9560-8968 (Silver)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>15.6"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™ i7
                                                                            7700HQ</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>16&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>NVIDIA GeForce GTX
                                                                            960M</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices"><del
                                                                        class="uk-text-meta">$999.00</del>
                                                                    <div class="tm-product-card-price">$949.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <div class="tm-product-card-labels"><span
                                                                            class="uk-label uk-label-danger">trade-in</span>
                                                                    </div>
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/6/6-medium.jpg"
                                                                            alt="Apple MacBook Air 13&quot; MQD32LL/A 128GB (Silver)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Apple MacBook Air
                                                                        13&quot; MQD32LL/A 128GB (Silver)</a>
                                                                </h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.3"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™ i5</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>8&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® HD Graphics
                                                                            6000</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="tm-product-card-price">$849.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/7/7-medium.jpg"
                                                                            alt="Dell Inspiron 5378-2063 (Gray)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Dell Inspiron
                                                                        5378-2063 (Gray)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.3"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™
                                                                            i3-7100U</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>4&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">HDD
                                                                            Capacity:
                                                                        </span><span>1&nbsp;TB</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices"><del
                                                                        class="uk-text-meta">$599.00</del>
                                                                    <div class="tm-product-card-price">$579.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <div class="tm-product-card-labels"><span
                                                                            class="uk-label uk-label-success">new</span>
                                                                    </div>
                                                                    <figure class="tm-media-box-wrap"><img
                                                                            src="@theme_asset()images/products/8/8-medium.jpg"
                                                                            alt="Lenovo Yoga 720-13IKB 80X60059RK (Silver)" />
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Lenovo Yoga
                                                                        720-13IKB 80X60059RK (Silver)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.3"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™
                                                                            i5-7200U</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>8&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® HD Graphics
                                                                            620</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="tm-product-card-price">$1099.00
                                                                    </div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
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
                                                    <article class="tm-product-card">
                                                        <div class="tm-product-card-media">
                                                            <div class="tm-ratio tm-ratio-4-3"><a
                                                                    class="tm-media-box" href="product.html">
                                                                    <figure class="tm-media-box-wrap"><span
                                                                            class="uk-text-muted"
                                                                            uk-icon="icon: image; ratio: 3;"></span>
                                                                    </figure>
                                                                </a></div>
                                                        </div>
                                                        <div class="tm-product-card-body">
                                                            <div class="tm-product-card-info">
                                                                <div
                                                                    class="uk-text-meta uk-margin-xsmall-bottom">
                                                                    Laptop</div>
                                                                <h3 class="tm-product-card-title"><a
                                                                        class="uk-link-heading"
                                                                        href="product.html">Lenovo ThinkPad X380
                                                                        Yoga 20LH000MUS (Black)</a></h3>
                                                                <ul
                                                                    class="uk-list uk-text-small tm-product-card-properties">
                                                                    <li><span class="uk-text-muted">Diagonal
                                                                            display: </span><span>13.3"</span>
                                                                    </li>
                                                                    <li><span class="uk-text-muted">CPU:
                                                                        </span><span>Intel®&nbsp;Core™ i7
                                                                            8550U</span></li>
                                                                    <li><span class="uk-text-muted">RAM:
                                                                        </span><span>4&nbsp;GB</span></li>
                                                                    <li><span class="uk-text-muted">Video Card:
                                                                        </span><span>Intel® UHD Graphics
                                                                            620</span></li>
                                                                </ul>
                                                            </div>
                                                            <div class="tm-product-card-shop">
                                                                <div class="tm-product-card-prices">
                                                                    <div class="uk-text-muted">Product not
                                                                        available</div>
                                                                </div>
                                                                <div class="tm-product-card-add">
                                                                    <div
                                                                        class="uk-text-meta tm-product-card-actions">
                                                                        <a class="tm-product-card-action js-add-to js-add-to-favorites"
                                                                            title="Add to favorites"><span
                                                                                uk-icon="icon: heart; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to favorites</span></a><a
                                                                            class="tm-product-card-action js-add-to js-add-to-compare"
                                                                            title="Add to compare"><span
                                                                                uk-icon="icon: copy; ratio: .75;"></span><span
                                                                                class="tm-product-card-action-text">Add
                                                                                to compare</span></a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                            <div><button
                                                    class="uk-button uk-button-default uk-button-large uk-width-1-1"
                                                    style="border-top-left-radius: 0; border-top-right-radius: 0;"><span
                                                        class="uk-margin-small-right"
                                                        uk-icon="icon: plus; ratio: .75;"></span><span>Load
                                                        more</span></button></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <ul class="uk-pagination uk-flex-center">
                                        <li class="uk-active"><span>1</span></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li class="uk-disabled"><span>…</span></li>
                                        <li><a href="#">20</a></li>
                                        <li><a href="#"><span uk-pagination-next></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="uk-section uk-section-default uk-section-small">
        <div class="uk-container">
            <div uk-slider>
                <ul
                    class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-5@m uk-grid">
                    <li>
                        <div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
                            <div><span uk-icon="icon: star; ratio: 2.5;"></span></div>
                            <div class="uk-text-center uk-text-left@s uk-width-expand@s">
                                <div>Mauris placerat</div>
                                <div class="uk-text-meta">Donec mollis nibh dolor, sit amet auctor</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
                            <div><span uk-icon="icon: receiver; ratio: 2.5;"></span></div>
                            <div class="uk-text-center uk-text-left@s uk-width-expand@s">
                                <div>Lorem ipsum</div>
                                <div class="uk-text-meta">Sit amet, consectetur adipiscing elit</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
                            <div><span uk-icon="icon: location; ratio: 2.5;"></span></div>
                            <div class="uk-text-center uk-text-left@s uk-width-expand@s">
                                <div>Proin pharetra</div>
                                <div class="uk-text-meta">Nec quam a fermentum ut viverra</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
                            <div><span uk-icon="icon: comments; ratio: 2.5;"></span></div>
                            <div class="uk-text-center uk-text-left@s uk-width-expand@s">
                                <div>Praesent ultrices</div>
                                <div class="uk-text-meta">Praesent ultrices, orci nec finibus</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
                            <div><span uk-icon="icon: happy; ratio: 2.5;"></span></div>
                            <div class="uk-text-center uk-text-left@s uk-width-expand@s">
                                <div>Duis condimentum</div>
                                <div class="uk-text-meta">Pellentesque eget varius arcu</div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
            </div>
        </div>
    </section>
</main>
@stop