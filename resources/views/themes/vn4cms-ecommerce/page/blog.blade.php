@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>Blog</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Blog</h1>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <section class="uk-width-1-1 uk-width-expand@m">
                            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                                <div><a href="article.html">
                                        <article
                                            class="uk-card uk-card-default uk-card-small uk-article uk-overflow-hidden uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
                                            <div class="tm-ratio tm-ratio-16-9">
                                                <figure
                                                    class="tm-media-box uk-cover-container uk-margin-remove">
                                                    <img src="@theme_asset()images/articles/macbook-photo.jpg"
                                                        alt="Everything You Need to Know About the MacBook Pro"
                                                        uk-cover="uk-cover" /></figure>
                                            </div>
                                            <div class="uk-card-body">
                                                <div class="uk-article-body">
                                                    <div class="uk-article-meta uk-margin-xsmall-bottom">
                                                        <time>May 21, 2018</time></div>
                                                    <div>
                                                        <h3 class="uk-margin-remove">Everything You Need to Know
                                                            About the MacBook Pro</h3>
                                                    </div>
                                                    <div class="uk-margin-small-top">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                            elit. Proin sodales eget ipsum id aliquam. Nam
                                                            consectetur interdum nibh eget sodales. Cras
                                                            volutpat efficitur ornare.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </a></div>
                                <div><a href="article.html">
                                        <article
                                            class="uk-card uk-card-default uk-card-small uk-article uk-overflow-hidden uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
                                            <div class="tm-ratio tm-ratio-16-9">
                                                <figure
                                                    class="tm-media-box uk-cover-container uk-margin-remove">
                                                    <img src="@theme_asset()images/articles/macos.jpg"
                                                        alt="Apple introduces macOS Mojave"
                                                        uk-cover="uk-cover" /></figure>
                                            </div>
                                            <div class="uk-card-body">
                                                <div class="uk-article-body">
                                                    <div class="uk-article-meta uk-margin-xsmall-bottom">
                                                        <time>May 21, 2018</time></div>
                                                    <div>
                                                        <h3 class="uk-margin-remove">Apple introduces macOS
                                                            Mojave</h3>
                                                    </div>
                                                    <div class="uk-margin-small-top">
                                                        <p>Praesent consequat justo eu massa malesuada posuere.
                                                            Donec ultricies tincidunt nisl, sed euismod nulla
                                                            venenatis maximus. Maecenas sit amet semper tellus.
                                                            Pellentesque imperdiet finibus sapien, a consectetur
                                                            eros auctor a.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </a></div>
                            </div>
                        </section>
                        <aside class="uk-width-1-4 uk-visible@m tm-aside-column">
                            <section class="uk-card uk-card-default uk-card-small"
                                uk-sticky="offset: 90; bottom: true;">
                                <nav>
                                    <ul class="uk-nav uk-nav-default tm-nav">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="contacts.html">Contacts</a></li>
                                        <li class="uk-active"><a href="blog.html">Blog</a></li>
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