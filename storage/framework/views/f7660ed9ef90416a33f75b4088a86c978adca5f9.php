<?php $__env->startSection('content'); ?>
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><a href="catalog.html">Catalog</a></li>
                        <li><a href="category.html">Laptops &amp; Tablets</a></li>
                        <li><span>Laptops</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Laptops</h1>
                    <div class="uk-text-meta uk-margin-xsmall-top">289 items</div>
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
                                                <h3>Filters</h3>
                                            </div><button class="uk-offcanvas-close" type="button"
                                                uk-close></button>
                                        </div>
                                    </header>
                                    <div class="uk-margin-remove uk-flex-1 uk-overflow-auto"
                                        uk-accordion="multiple: true; targets: &gt; .js-accordion-section"
                                        style="flex-basis: auto">
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
                                        <section class="uk-card-body js-accordion-section uk-open">
                                            <h4 class="uk-accordion-title uk-margin-remove">Type<span
                                                    class="tm-help-icon" uk-icon="icon: question; ratio: .75;"
                                                    onclick="event.stopPropagation();"></span>
                                                <div class="uk-margin-remove"
                                                    uk-drop="mode: click;boundary-align: true; boundary: !.uk-accordion-title; pos: bottom-justify;">
                                                    <div
                                                        class="uk-card uk-card-body uk-card-default uk-card-small uk-box-shadow-xlarge uk-text-small">
                                                        A small description for this property</div>
                                                </div>
                                            </h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="type-1" name="type"
                                                            value="1" type="checkbox"><label
                                                            for="type-1"><span>Notebook
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">150</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="type-2" name="type"
                                                            value="2" type="checkbox"><label
                                                            for="type-2"><span>Ultrabook
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">18</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="type-3" name="type"
                                                            value="3" type="checkbox"><label
                                                            for="type-3"><span>Transformer
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">6</span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </section>
                                        <section class="uk-card-body js-accordion-section">
                                            <h4 class="uk-accordion-title uk-margin-remove">Screen Size<span
                                                    class="tm-help-icon" uk-icon="icon: question; ratio: .75;"
                                                    onclick="event.stopPropagation();"></span>
                                                <div class="uk-margin-remove"
                                                    uk-drop="mode: click;boundary-align: true; boundary: !.uk-accordion-title; pos: bottom-justify;">
                                                    <div
                                                        class="uk-card uk-card-body uk-card-default uk-card-small uk-box-shadow-xlarge uk-text-small">
                                                        A small description for this property</div>
                                                </div>
                                            </h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="screen-size-1"
                                                            name="screen-size" value="1" type="checkbox"><label
                                                            for="screen-size-1"><span>11.6&quot; and smaller
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">45</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-size-2"
                                                            name="screen-size" value="2" type="checkbox"><label
                                                            for="screen-size-2"><span>12&quot; - 13.5&quot;
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">178</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-size-3"
                                                            name="screen-size" value="3" type="checkbox"><label
                                                            for="screen-size-3"><span>14&quot; - 14.5&quot;
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">461</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-size-4"
                                                            name="screen-size" value="4" type="checkbox"><label
                                                            for="screen-size-4"><span>15&quot; - 15.6&quot;
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">148</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-size-5"
                                                            name="screen-size" value="5" type="checkbox"><label
                                                            for="screen-size-5"><span>17&quot; - 17.3&quot;
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">73</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-size-6"
                                                            name="screen-size" value="6" type="checkbox"><label
                                                            for="screen-size-6"><span>18.4&quot; and larger
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">54</span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </section>
                                        <section class="uk-card-body js-accordion-section">
                                            <h4 class="uk-accordion-title uk-margin-remove">Screen
                                                Resolution<span class="tm-help-icon"
                                                    uk-icon="icon: question; ratio: .75;"
                                                    onclick="event.stopPropagation();"></span>
                                                <div class="uk-margin-remove"
                                                    uk-drop="mode: click;boundary-align: true; boundary: !.uk-accordion-title; pos: bottom-justify;">
                                                    <div
                                                        class="uk-card uk-card-body uk-card-default uk-card-small uk-box-shadow-xlarge uk-text-small">
                                                        A small description for this property</div>
                                                </div>
                                            </h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="screen-resolution-1"
                                                            name="screen-resolution" value="1"
                                                            type="checkbox"><label
                                                            for="screen-resolution-1"><span>3840×2160
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">12</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-2"
                                                            name="screen-resolution" value="2"
                                                            type="checkbox"><label
                                                            for="screen-resolution-2"><span>3200×1800&quot;
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">12</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-3"
                                                            name="screen-resolution" value="3"
                                                            type="checkbox"><label
                                                            for="screen-resolution-3"><span>2880×1800
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">10</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-4"
                                                            name="screen-resolution" value="4"
                                                            type="checkbox"><label
                                                            for="screen-resolution-4"><span>2560×1600
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">7</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-5"
                                                            name="screen-resolution" value="5"
                                                            type="checkbox"><label
                                                            for="screen-resolution-5"><span>2560×1440
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">13</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-6"
                                                            name="screen-resolution" value="6"
                                                            type="checkbox"><label
                                                            for="screen-resolution-6"><span>1920×1080
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">341</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-7"
                                                            name="screen-resolution" value="7"
                                                            type="checkbox"><label
                                                            for="screen-resolution-7"><span>1600×900
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">11</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-8"
                                                            name="screen-resolution" value="8"
                                                            type="checkbox"><label
                                                            for="screen-resolution-8"><span>1440×900
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">13</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-9"
                                                            name="screen-resolution" value="9"
                                                            type="checkbox"><label
                                                            for="screen-resolution-9"><span>1366×768
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">237</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="screen-resolution-10"
                                                            name="screen-resolution" value="10"
                                                            type="checkbox"><label
                                                            for="screen-resolution-10"><span>1024×600
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">5</span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </section>
                                        <section class="uk-card-body js-accordion-section">
                                            <h4 class="uk-accordion-title uk-margin-remove">CPU<span
                                                    class="tm-help-icon" uk-icon="icon: question; ratio: .75;"
                                                    onclick="event.stopPropagation();"></span>
                                                <div class="uk-margin-remove"
                                                    uk-drop="mode: click;boundary-align: true; boundary: !.uk-accordion-title; pos: bottom-justify;">
                                                    <div
                                                        class="uk-card uk-card-body uk-card-default uk-card-small uk-box-shadow-xlarge uk-text-small">
                                                        A small description for this property</div>
                                                </div>
                                            </h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="cpu-1" name="cpu"
                                                            value="1" type="checkbox"><label
                                                            for="cpu-1"><span>AMD A-series
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">102</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-2" name="cpu"
                                                            value="2" type="checkbox"><label
                                                            for="cpu-2"><span>AMD E-series
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">21</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-3" name="cpu"
                                                            value="3" type="checkbox"><label
                                                            for="cpu-3"><span>AMD FX
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">1</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-4" name="cpu"
                                                            value="4" type="checkbox"><label
                                                            for="cpu-4"><span>AMD Ryzen
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">1</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-5" name="cpu"
                                                            value="5" type="checkbox"><label
                                                            for="cpu-5"><span>Intel Atom
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">8</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-6" name="cpu"
                                                            value="6" type="checkbox"><label
                                                            for="cpu-6"><span>Intel Celeron
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">38</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-7" name="cpu"
                                                            value="7" type="checkbox"><label
                                                            for="cpu-7"><span>Intel Core M
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">6</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-8" name="cpu"
                                                            value="8" type="checkbox"><label
                                                            for="cpu-8"><span>Intel Core i3
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">143</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-9" name="cpu"
                                                            value="9" type="checkbox"><label
                                                            for="cpu-9"><span>Intel Core i5
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">273</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-10" name="cpu"
                                                            value="10" type="checkbox"><label
                                                            for="cpu-10"><span>Intel Core i7
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">218</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-11" name="cpu"
                                                            value="11" type="checkbox"><label
                                                            for="cpu-11"><span>Intel Xeon
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">3</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="cpu-12" name="cpu"
                                                            value="12" type="checkbox"><label
                                                            for="cpu-12"><span>Intel Pentium
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">86</span></span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </section>
                                        <section class="uk-card-body js-accordion-section">
                                            <h4 class="uk-accordion-title uk-margin-remove">RAM<span
                                                    class="tm-help-icon" uk-icon="icon: question; ratio: .75;"
                                                    onclick="event.stopPropagation();"></span>
                                                <div class="uk-margin-remove"
                                                    uk-drop="mode: click;boundary-align: true; boundary: !.uk-accordion-title; pos: bottom-justify;">
                                                    <div
                                                        class="uk-card uk-card-body uk-card-default uk-card-small uk-box-shadow-xlarge uk-text-small">
                                                        A small description for this property</div>
                                                </div>
                                            </h4>
                                            <div class="uk-accordion-content">
                                                <ul class="uk-list tm-scrollbox">
                                                    <li><input class="tm-checkbox" id="ram-1" name="ram"
                                                            value="1" type="checkbox"><label for="ram-1"><span>2
                                                                GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">17</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-2" name="ram"
                                                            value="2" type="checkbox"><label for="ram-2"><span>4
                                                                GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">359</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-3" name="ram"
                                                            value="3" type="checkbox"><label for="ram-3"><span>6
                                                                GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">81</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-4" name="ram"
                                                            value="4" type="checkbox"><label for="ram-4"><span>8
                                                                GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">346</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-5" name="ram"
                                                            value="5" type="checkbox"><label
                                                            for="ram-5"><span>12 GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">13</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-6" name="ram"
                                                            value="6" type="checkbox"><label
                                                            for="ram-6"><span>16 GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">72</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-7" name="ram"
                                                            value="7" type="checkbox"><label
                                                            for="ram-7"><span>24 GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">1</span></span></label>
                                                    </li>
                                                    <li><input class="tm-checkbox" id="ram-8" name="ram"
                                                            value="8" type="checkbox"><label
                                                            for="ram-8"><span>32 GB
                                                                <span
                                                                    class="uk-text-meta uk-text-xsmall">11</span></span></label>
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/1/1-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/2/2-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/3/3-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/4/4-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/5/5-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/6/6-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/7/7-medium.jpg"
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
                                                                            src="/themes/vn4cms-ecommerce/images/products/8/8-medium.jpg"
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make(theme_extends(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>