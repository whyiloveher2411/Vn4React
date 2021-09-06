@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>Contacts</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Contacts</h1>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <section class="uk-width-1-1 uk-width-expand@m">
                            <article
                                class="uk-card uk-card-default uk-card-small uk-card-body uk-article tm-ignore-container">
                                <div class="tm-wrapper">
                                    <figure class="tm-ratio tm-ratio-16-9 js-map" data-latitude="59.9356728"
                                        data-longitude="30.3258604" data-zoom="14"></figure>
                                </div>
                                <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-margin-top" uk-grid>
                                    <section>
                                        <h3>Store</h3>
                                        <ul class="uk-list">
                                            <li><a class="uk-link-heading" href="#"><span
                                                        class="uk-margin-small-right"
                                                        uk-icon="receiver"></span><span class="tm-pseudo">8 800
                                                        799 99 99</span></a></li>
                                            <li><a class="uk-link-heading" href="#"><span
                                                        class="uk-margin-small-right"
                                                        uk-icon="mail"></span><span
                                                        class="tm-pseudo">example@example.com</span></a></li>
                                            <li>
                                                <div><span class="uk-margin-small-right"
                                                        uk-icon="location"></span><span>St.&nbsp;Petersburg,
                                                        Nevsky&nbsp;Prospect&nbsp;28</span></div>
                                            </li>
                                            <li>
                                                <div><span class="uk-margin-small-right"
                                                        uk-icon="clock"></span><span>Daily 10:00–22:00</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </section>
                                    <section>
                                        <h3>Feedback</h3>
                                        <dl class="uk-description-list">
                                            <dt>Cooperation</dt>
                                            <dd><a class="uk-link-muted" href="#">cooperation@example.com</a>
                                            </dd>
                                            <dt>Partners</dt>
                                            <dd><a class="uk-link-muted" href="#">partners@example.com</a></dd>
                                            <dt>Press</dt>
                                            <dd><a class="uk-link-muted" href="#">press@example.com</a></dd>
                                        </dl>
                                    </section>
                                    <section class="uk-width-1-1">
                                        <h2 class="uk-text-center">Contact Us</h2>
                                        <form>
                                            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                                                <div><label>
                                                        <div class="uk-form-label uk-form-label-required">Name
                                                        </div><input class="uk-input" type="text" required>
                                                    </label></div>
                                                <div><label>
                                                        <div class="uk-form-label uk-form-label-required">Email
                                                        </div><input class="uk-input" type="email" required>
                                                    </label></div>
                                                <div><label>
                                                        <div class="uk-form-label">Topic</div><select
                                                            class="uk-select">
                                                            <option>Customer service</option>
                                                            <option>Tech support</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </label></div>
                                                <div><label>
                                                        <div class="uk-form-label">Message</div><textarea
                                                            class="uk-textarea" rows="5"></textarea>
                                                    </label></div>
                                                <div class="uk-text-center"><button
                                                        class="uk-button uk-button-primary">Send</button></div>
                                            </div>
                                        </form>
                                    </section>
                                </div>
                            </article>
                        </section>
                        <aside class="uk-width-1-4 uk-visible@m tm-aside-column">
                            <section class="uk-card uk-card-default uk-card-small"
                                uk-sticky="offset: 90; bottom: true;">
                                <nav>
                                    <ul class="uk-nav uk-nav-default tm-nav">
                                        <li><a href="about.html">About</a></li>
                                        <li class="uk-active"><a href="contacts.html">Contacts</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="news.html">News</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li><a href="delivery.html">Delivery</a></li>
                                    </ul>
                                </nav>
                            </section>
                        </aside>
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