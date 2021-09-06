
@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <section class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><span>Everything You Need to Know About the MacBook Pro</span></li>
                    </ul>
                </section>
                <section>
                    <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                        <section>
                            <article
                                class="uk-card uk-card-default uk-card-body uk-article tm-ignore-container">
                                <header class="uk-text-center">
                                    <h1 class="uk-article-title">Everything You Need to Know About the MacBook
                                        Pro</h1>
                                    <div class="uk-article-meta"><time>May 21, 2018</time></div>
                                </header>
                                <section class="uk-article-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                                        euismod nisl nunc, a dictum magna laoreet eget. Vestibulum ante ipsum
                                        primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
                                    <div class="tm-wrapper uk-text-center">
                                        <figure><a href="images/articles/macbook-photo.jpg"><img
                                                    src="@theme_asset()images/articles/macbook-photo.jpg"
                                                    alt="MacBook Pro"></a>
                                            <figcaption>MacBook Pro</figcaption>
                                        </figure>
                                    </div>
                                    <p>Sed sit amet ante eget nunc dictum auctor sagittis in libero. Aliquam
                                        ultricies tincidunt nisi, a vestibulum nisi tempor vitae. Praesent
                                        fermentum sem semper fermentum ultrices. Duis eleifend vel sapien
                                        dignissim auctor. Vestibulum at commodo leo. In vitae eros ut sapien
                                        egestas venenatis non sit amet elit. In gravida vitae ante a rutrum.</p>
                                    <h2>Touch Bar</h2>
                                    <p>Vivamus ornare tortor elit, sed rutrum felis iaculis in. Nunc ut molestie
                                        neque. Aenean vitae elementum arcu, at rutrum ligula. Pellentesque
                                        fringilla dictum viverra. Vestibulum eu ipsum nec risus pharetra
                                        iaculis. Donec quis nulla orci. Suspendisse eget dictum augue, et
                                        lobortis justo. Suspendisse velit dui, sollicitudin quis velit nec,
                                        tincidunt consequat arcu.</p>
                                    <h2>Retina Display</h2>
                                    <p>Pellentesque dictum imperdiet rutrum. Vestibulum egestas quam eget
                                        maximus rutrum. Etiam blandit a dolor laoreet vulputate. Nulla
                                        ullamcorper ipsum et libero finibus, vitae vestibulum odio feugiat.</p>
                                    <figure class="uk-text-center"><a
                                            href="images/articles/macbook-promo-4.jpg"><img
                                                src="@theme_asset()images/articles/macbook-promo-4.jpg" alt="MacBook Pro"></a>
                                    </figure>
                                    <h2>Force Touch Trackpad</h2>
                                    <p>Vivamus ornare tortor elit, sed rutrum felis iaculis in. Nunc ut molestie
                                        neque. Aenean vitae elementum arcu, at rutrum ligula. Pellentesque
                                        fringilla dictum viverra. Vestibulum eu ipsum nec risus pharetra
                                        iaculis. Donec quis nulla orci. Suspendisse eget dictum augue, et
                                        lobortis justo. Suspendisse velit dui, sollicitudin quis velit nec,
                                        tincidunt consequat arcu.</p>
                                  
                                    <p>Ut arcu lacus, tempus bibendum purus sed, iaculis sollicitudin sapien.
                                        Donec quis imperdiet arcu. Ut sagittis ipsum diam, nec tempor ex
                                        fermentum a. Nam ac vehicula erat. Curabitur id congue risus, vel
                                        iaculis enim. Donec tristique lacinia velit eu fringilla. Mauris lectus
                                        enim, aliquet eu dolor sed, porta vehicula lacus. Etiam luctus egestas
                                        scelerisque. Sed sit amet metus ante. Cras pulvinar sollicitudin nisl
                                        nec egestas. Maecenas vitae velit ut urna vestibulum venenatis ut vel
                                        ex. Quisque sit amet mattis ante. Duis blandit nisl non commodo rutrum.
                                        Nulla in velit ut arcu efficitur laoreet ut eu mauris. Duis condimentum
                                        vulputate consequat. Vestibulum aliquet suscipit purus.</p>
                                    <figure uk-slideshow>
                                        <div class="uk-position-relative uk-visible-toggle uk-light">
                                            <ul class="uk-slideshow-items">
                                                <li><img src="@theme_asset()images/articles/macbook-promo-1.jpg"
                                                        alt="MacBook Pro" uk-cover></li>
                                                <li><img src="@theme_asset()images/articles/macbook-promo-2.jpg"
                                                        alt="MacBook Pro" uk-cover></li>
                                            </ul><a
                                                class="uk-position-center-left uk-position-small uk-hidden-hover"
                                                href="#" uk-slidenav-previous
                                                uk-slideshow-item="previous"></a><a
                                                class="uk-position-center-right uk-position-small uk-hidden-hover"
                                                href="#" uk-slidenav-next uk-slideshow-item="next"></a>
                                        </div>
                                        <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>
                                    </figure>
                                    <p>Mauris dignissim non nulla quis sollicitudin. Maecenas quis orci dui.
                                        Suspendisse pharetra facilisis metus, at venenatis nisl convallis et.
                                        Curabitur vulputate eget nisl sed dignissim. Sed eget metus ut orci
                                        volutpat gravida.</p>
                                    <blockquote class="twitter-tweet" data-lang="en">
                                        <p lang="en" dir="ltr">Mophie&apos;s latest battery pack is powerful
                                            enough to charge your 15-inch MacBook Pro<a
                                                href="https://t.co/jN4RzcxOyG">https://t.co/jN4RzcxOyG</a><a
                                                href="https://t.co/5oJBKZRVBx">pic.twitter.com/5oJBKZRVBx</a>
                                        </p>&mdash; The Verge (@verge)<a
                                            href="https://twitter.com/verge/status/948539601265872896?ref_src=twsrc%5Etfw">January
                                            3, 2018</a>
                                    </blockquote>
                                    
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sem
                                        urna, accumsan nec velit et, convallis tincidunt enim. Proin
                                        sollicitudin, metus at interdum tempus, velit mi posuere nisl, nec
                                        viverra ligula lorem sit amet felis. Class aptent taciti sociosqu ad
                                        litora torquent per conubia nostra, per inceptos himenaeos.</p>
                                    <table
                                        class="uk-table uk-table-large uk-table-middle uk-table-divider uk-table-justify uk-table-responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="uk-width-1-4 uk-text-center">MacBook Pro 13"</th>
                                                <th class="uk-width-1-4 uk-text-center">MacBook Pro 13" with
                                                    Touch Bar</th>
                                                <th class="uk-width-1-4 uk-text-center">MacBook Pro 15" with
                                                    Touch Bar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Dimensions</th>
                                                <td>0.59 × 11.97 × 8.36&nbsp;inches</td>
                                                <td>0.59 × 11.97 × 8.36&nbsp;inches</td>
                                                <td>0.61 × 13.75 × 9.48&nbsp;inches</td>
                                            </tr>
                                            <tr>
                                                <th>Weight</th>
                                                <td>3.02&nbsp;pounds</td>
                                                <td>3.02&nbsp;pounds</td>
                                                <td>4.02&nbsp;pounds</td>
                                            </tr>
                                            <tr>
                                                <th>Display</th>
                                                <td>13.3" 2560×1600,<br>60Hz Retina Display</td>
                                                <td>13.3" 2560×1600,<br>60Hz Retina Display</td>
                                                <td>15.4" 2880×1800,<br>60Hz Retina Display</td>
                                            </tr>
                                            <tr>
                                                <th>Inputs</th>
                                                <td>2 × USB-C Ports,<br>1 × 3.5mm Headphone Jack</td>
                                                <td>4 × USB-C Ports,<br>1 × 3.5mm Headphone Jack</td>
                                                <td>4 × USB-C Ports,<br>1 × 3.5mm Headphone Jack</td>
                                            </tr>
                                            <tr>
                                                <th>Battery Life</th>
                                                <td>Approximately 10&nbsp;hours</td>
                                                <td>Approximately 10&nbsp;hours</td>
                                                <td>Approximately 10&nbsp;hours</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p>Sed at diam aliquet, fringilla turpis ac, consequat ante. Duis id maximus
                                        purus. Cras rutrum erat non nibh accumsan, vitae maximus sapien
                                        elementum. Maecenas tellus libero, vulputate vitae mi eu, volutpat
                                        ornare felis. Nulla malesuada nunc urna, quis rutrum massa consequat id.
                                        Pellentesque elit diam, dignissim a lorem eu, tincidunt mollis erat.</p>
                                    <div class="tm-wrapper">
                                        <figure class="uk-text-center"><a
                                                href="images/articles/macbook-promo-3.jpg"><img
                                                    src="@theme_asset()images/articles/macbook-promo-3.jpg"
                                                    alt="MacBook Pro"></a>
                                            <figcaption>13-inch and 15-inch</figcaption>
                                        </figure>
                                    </div>
                                    <p>Sed at diam aliquet, fringilla turpis ac, consequat ante. Duis id maximus
                                        purus. Cras rutrum erat non nibh accumsan, vitae maximus sapien
                                        elementum. Maecenas tellus libero, vulputate vitae mi eu, volutpat
                                        ornare felis. Nulla malesuada nunc urna, quis rutrum massa consequat id.
                                        Pellentesque elit diam, dignissim a lorem eu, tincidunt mollis erat.</p>
                                    <blockquote cite="#">
                                        <p class="uk-margin-small-bottom">You can converge a toaster and
                                            refrigerator, but these things are probably not going to be pleasing
                                            to the user.</p>
                                        <footer>Tim Cook</footer>
                                    </blockquote>
                                </section>
                            </article>
                        </section>
                        <section>
                            <h2 class="uk-text-center">Related Articles</h2>
                            <div class="uk-grid-medium uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-4@m"
                                uk-grid>
                                <div><a href="article.html">
                                        <article
                                            class="uk-card uk-card-default uk-card-small uk-overflow-hidden uk-link-heading uk-display-block uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
                                            <div class="uk-card-media-top">
                                                <figure class="uk-margin-remove tm-ratio tm-ratio-16-9">
                                                    <div class="uk-cover-container"><img
                                                            src="@theme_asset()images/articles/macbook-photo.jpg"
                                                            alt="Everything You Need to Know About the MacBook Pro"
                                                            uk-cover></div>
                                                </figure>
                                            </div>
                                            <div class="uk-card-body">
                                                <div class="uk-article-meta uk-margin-xsmall-bottom"><time>May
                                                        21, 2018</time></div>
                                                <h3 class="uk-h4 uk-margin-remove">Everything You Need to Know
                                                    About the MacBook Pro</h3>
                                            </div>
                                        </article>
                                    </a></div>
                                <div><a href="article.html">
                                        <article
                                            class="uk-card uk-card-default uk-card-small uk-overflow-hidden uk-link-heading uk-display-block uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
                                            <div class="uk-card-media-top">
                                                <figure class="uk-margin-remove tm-ratio tm-ratio-16-9">
                                                    <div class="uk-cover-container"><img
                                                            src="@theme_asset()images/articles/macos.jpg"
                                                            alt="Apple introduces macOS Mojave" uk-cover></div>
                                                </figure>
                                            </div>
                                            <div class="uk-card-body">
                                                <div class="uk-article-meta uk-margin-xsmall-bottom"><time>May
                                                        21, 2018</time></div>
                                                <h3 class="uk-h4 uk-margin-remove">Apple introduces macOS Mojave
                                                </h3>
                                            </div>
                                        </article>
                                    </a></div>
                            </div>
                        </section>
                    </div>
                </section>
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