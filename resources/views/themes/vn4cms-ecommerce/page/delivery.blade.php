@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>Delivery</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Delivery</h1>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <section class="uk-width-1-1 uk-width-expand@m">
                            <article
                                class="uk-card uk-card-default uk-card-small uk-card-body uk-article tm-ignore-container">
                                <h2>Pickup from store in St. Petersburg</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus imperdiet
                                    venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel,
                                    ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum
                                    id diam.</p>
                                <figure>
                                    <div class="uk-text-bolder">Store Name</div>
                                    <div>St.&nbsp;Petersburg, Nevsky&nbsp;Prospect&nbsp;28</div>
                                    <div>Daily 10:00–22:00</div>
                                </figure>
                                <div class="tm-wrapper">
                                    <figure class="tm-ratio tm-ratio-16-9 js-map" data-latitude="59.9356728"
                                        data-longitude="30.3258604" data-zoom="14"></figure>
                                </div>
                                <h2>Delivery in St. Petersburg</h2>
                                <p>Nullam massa sem, mollis ut luctus at, tincidunt a lorem. Aliquam sed dictum
                                    elit, quis consequat metus. Proin in mauris finibus urna lacinia laoreet sed
                                    id orci. Pellentesque volutpat tellus sit amet enim rutrum, vel eleifend
                                    metus consectetur. Sed lacinia urna a neque maximus placerat. Praesent
                                    blandit hendrerit dui non placerat.</p>
                                <ul>
                                    <li>Fusce eget lorem ex. Vivamus nisl eros, condimentum at mollis id, tempor
                                        a risus. Integer pellentesque bibendum est, dapibus lacinia lacus.</li>
                                    <li>Vivamus tellus nibh, mattis at aliquam et, vestibulum aliquet leo. Nunc
                                        cursus lectus ex, laoreet commodo ligula posuere nec.</li>
                                    <li>Suspendisse potenti. Vivamus fermentum vitae lacus ut vulputate. Mauris
                                        sed consectetur nibh.</li>
                                </ul>
                                <h2>Regional Delivery</h2>
                                <p>Aliquam erat volutpat. Pellentesque sit amet risus odio. Vestibulum id porta
                                    libero, non interdum libero. Integer pretium tempus viverra. Nulla iaculis
                                    sed tellus vel luctus. Curabitur maximus quis nibh mattis pulvinar. Mauris
                                    convallis dapibus justo, at fringilla erat porta at. Vivamus at ante nec
                                    augue convallis consectetur at vitae orci.</p>
                                <p>Sed a rhoncus felis, quis efficitur orci. Maecenas imperdiet non sapien a
                                    sagittis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                                    posuere cubilia Curae; Fusce pretium ipsum posuere, congue leo sit amet,
                                    finibus sem. Morbi aliquam pellentesque egestas. Curabitur sit amet commodo
                                    ipsum.</p>
                            </article>
                        </section>
                        <aside class="uk-width-1-4 uk-visible@m tm-aside-column">
                            <section class="uk-card uk-card-default uk-card-small"
                                uk-sticky="offset: 90; bottom: true;">
                                <nav>
                                    <ul class="uk-nav uk-nav-default tm-nav">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="contacts.html">Contacts</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="news.html">News</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li class="uk-active"><a href="delivery.html">Delivery</a></li>
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