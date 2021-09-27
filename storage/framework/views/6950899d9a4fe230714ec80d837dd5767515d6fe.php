<?php $__env->startSection('content'); ?>
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <section class="uk-text-center"><a class="uk-link-muted uk-text-small" href="cart.html"><span
                            class="uk-margin-xsmall-right" uk-icon="icon: arrow-left; ratio: .75;"></span>Return
                        to cart</a>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Checkout</h1>
                </section>
                <section>
                    <div class="uk-grid-medium" uk-grid>
                        <form class="uk-form-stacked uk-width-1-1 tm-checkout uk-width-expand@m">
                            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                                <section>
                                    <h2 class="tm-checkout-title">Contact Information</h2>
                                    <div
                                        class="uk-card uk-card-default uk-card-small uk-card-body tm-ignore-container">
                                        <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s"
                                            uk-grid>
                                            <div><label>
                                                    <div class="uk-form-label uk-form-label-required">First Name
                                                    </div><input class="uk-input" type="text" required>
                                                </label></div>
                                            <div><label>
                                                    <div class="uk-form-label uk-form-label-required">Last Name
                                                    </div><input class="uk-input" type="text" required>
                                                </label></div>
                                            <div><label>
                                                    <div class="uk-form-label uk-form-label-required">Phone
                                                        Number</div><input class="uk-input" type="tel" required>
                                                </label></div>
                                            <div><label>
                                                    <div class="uk-form-label uk-form-label-required">Email
                                                    </div><input class="uk-input" type="email" required>
                                                </label></div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="tm-checkout-title">Shipping</h2>
                                    <div
                                        class="uk-card uk-card-default uk-card-small uk-card-body tm-ignore-container">
                                        <div class="uk-grid-small uk-grid-match uk-child-width-1-1 uk-child-width-1-3@s uk-flex-center"
                                            uk-switcher="toggle: &gt; * &gt; .tm-choose" uk-grid>
                                            <div><a class="tm-choose" href="#">
                                                    <div class="tm-choose-title">pick up from store</div>
                                                    <div class="tm-choose-description">Free, tomorrow</div>
                                                </a></div>
                                            <div><a class="tm-choose" href="#">
                                                    <div class="tm-choose-title">delivery in city</div>
                                                    <div class="tm-choose-description">Free, tomorrow</div>
                                                </a></div>
                                            <div><a class="tm-choose" href="#">
                                                    <div class="tm-choose-title">regional delivery</div>
                                                    <div class="tm-choose-description">Via Russian Post or
                                                        postal courier services. Sending to any country</div>
                                                </a></div>
                                        </div>
                                        <div class="uk-switcher uk-margin">
                                            <section>
                                                <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s"
                                                    uk-grid>
                                                    <div>
                                                        <figure
                                                            class="uk-card-media-top tm-ratio tm-ratio-16-9 js-map"
                                                            data-latitude="59.9356728"
                                                            data-longitude="30.3258604" data-zoom="14"></figure>
                                                    </div>
                                                    <div class="uk-text-small">
                                                        <div class="uk-text-bolder">Store Name</div>
                                                        <div>St.&nbsp;Petersburg, Nevsky&nbsp;Prospect&nbsp;28
                                                        </div>
                                                        <div>Daily 10:00–22:00</div>
                                                    </div>
                                                </div>
                                            </section>
                                            <section>
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-expand"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                Street</div><input class="uk-input" type="text">
                                                        </label></div>
                                                    <div class="uk-width-1-3 uk-width-1-6@s"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                House</div><input class="uk-input" type="text">
                                                        </label></div>
                                                </div>
                                                <div class="uk-grid-small uk-child-width-1-3 uk-child-width-1-4@s"
                                                    uk-grid>
                                                    <div><label>
                                                            <div class="uk-form-label">Building</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Entrance</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Floor</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Apartment</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div class="uk-width-1-1"><label>
                                                            <div class="uk-form-label">Comment</div><textarea
                                                                class="uk-textarea" rows="5"
                                                                placeholder="Additional information: phone numbers or doorphone code"></textarea>
                                                        </label></div>
                                                </div>
                                                <div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-4@s"
                                                    uk-grid>
                                                    <div class="uk-width-1-1 uk-text-meta">Choose a convenient
                                                        date and delivery interval</div>
                                                    <div><select class="uk-select">
                                                            <option>Tomorrow</option>
                                                            <option>25 May</option>
                                                            <option>26 May</option>
                                                            <option>27 May</option>
                                                            <option>28 May</option>
                                                            <option>29 May</option>
                                                            <option>30 May</option>
                                                            <option>1 June</option>
                                                        </select></div>
                                                    <div><select class="uk-select">
                                                            <option>09:00 – 12:00</option>
                                                            <option>12:00 – 15:00</option>
                                                            <option>15:00 – 18:00</option>
                                                            <option>18:00 – 21:00</option>
                                                            <option>21:00 – 23:00</option>
                                                        </select></div>
                                                </div>
                                            </section>
                                            <div>
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-1-1"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                Country</div><select class="uk-select">
                                                                <option>Choose the country</option>
                                                                <option value="RU">Russia</option>
                                                            </select>
                                                        </label></div>
                                                </div>
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-expand"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                City</div><input class="uk-input" type="text">
                                                        </label></div>
                                                    <div class="uk-width-1-3 uk-width-1-6@s"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                Post Code</div><input class="uk-input"
                                                                type="text">
                                                        </label></div>
                                                </div>
                                                <div class="uk-grid-small" uk-grid>
                                                    <div class="uk-width-expand"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                Street</div><input class="uk-input" type="text">
                                                        </label></div>
                                                    <div class="uk-width-1-3 uk-width-1-6@s"><label>
                                                            <div class="uk-form-label uk-form-label-required">
                                                                House</div><input class="uk-input" type="text">
                                                        </label></div>
                                                </div>
                                                <div class="uk-grid-small uk-child-width-1-3 uk-child-width-1-4@s"
                                                    uk-grid>
                                                    <div><label>
                                                            <div class="uk-form-label">Building</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Entrance</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Floor</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div><label>
                                                            <div class="uk-form-label">Apartment</div><input
                                                                class="uk-input" type="text">
                                                        </label></div>
                                                    <div class="uk-width-1-1"><label>
                                                            <div class="uk-form-label">Comment</div><textarea
                                                                class="uk-textarea" rows="5"
                                                                placeholder="Additional information: phone numbers or doorphone code"></textarea>
                                                        </label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="tm-checkout-title">Payment</h2>
                                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                        <div class="uk-card-body">
                                            <div class="uk-grid-small uk-grid-match uk-child-width-1-1 uk-child-width-1-3@s uk-flex-center"
                                                uk-switcher="toggle: &gt; * &gt; .tm-choose" uk-grid>
                                                <div><a class="tm-choose" href="#">
                                                        <div class="tm-choose-title">payment upon receipt</div>
                                                        <div class="tm-choose-description">Cash, credit card
                                                        </div>
                                                    </a></div>
                                                <div><a class="tm-choose" href="#">
                                                        <div class="tm-choose-title">online by card</div>
                                                        <div class="tm-choose-description">Visa, MasterCard
                                                        </div>
                                                    </a></div>
                                                <div><a class="tm-choose" href="#">
                                                        <div class="tm-choose-title">electronic payment</div>
                                                        <div class="tm-choose-description">PayPal, Yandex.Money,
                                                            QIWI</div>
                                                    </a></div>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <div class="uk-grid-small uk-flex-middle uk-flex-center uk-text-center"
                                                uk-grid>
                                                <div class="uk-text-meta"><span class="uk-margin-xsmall-right"
                                                        uk-icon="icon: lock; ratio: .75;"></span>Security of
                                                    payments is is provided by secure protocols</div>
                                                <div><img src="/themes/vn4cms-ecommerce/images/verified-by-visa.svg"
                                                        title="Verified by Visa" style="height: 25px;"></div>
                                                <div><img src="/themes/vn4cms-ecommerce/images/mastercard-securecode.svg"
                                                        title="MasterCard SecureCode" style="height: 25px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                        <div class="uk-width-1-1 uk-width-1-4@m tm-aside-column">
                            <div class="uk-card uk-card-default uk-card-small tm-ignore-container"
                                uk-sticky="offset: 30; bottom: true; media: @m;">
                                <section class="uk-card-body">
                                    <h4>Items in order</h4>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-small">Apple MacBook Pro 15&quot; Touch Bar
                                                MPTU2LL/A 256GB (Silver)</div>
                                            <div class="uk-text-meta">1 × $1599.00</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div>$1599.00</div>
                                        </div>
                                    </div>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-small">Apple MacBook 12&quot; MNYN2LL/A 512GB
                                                (Rose Gold)</div>
                                            <div class="uk-text-meta">1 × $1549.00</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div>$1549.00</div>
                                        </div>
                                    </div>
                                </section>
                                <section class="uk-card-body">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-muted">Shipping</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div>Pick up from store</div>
                                            <div class="uk-text-meta">Free, tomorrow</div>
                                        </div>
                                    </div>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-muted">Payment</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div>Online by card</div>
                                        </div>
                                    </div>
                                </section>
                                <section class="uk-card-body">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-muted">Subtotal</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div>$3148</div>
                                        </div>
                                    </div>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-muted">Discount</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div class="uk-text-danger">−$29</div>
                                        </div>
                                    </div>
                                </section>
                                <section class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-expand">
                                            <div class="uk-text-muted">Total</div>
                                        </div>
                                        <div class="uk-text-right">
                                            <div class="uk-text-lead uk-text-bolder">$3119</div>
                                        </div>
                                    </div><button
                                        class="uk-button uk-button-primary uk-margin-small uk-width-1-1">checkout</button>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(theme_extends(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>