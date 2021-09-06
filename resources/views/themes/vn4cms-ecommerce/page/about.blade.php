@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <section class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>About</span></li>
                    </ul>
                </section>
                <section>
                    <div>
                        <article class="uk-card uk-card-default uk-card-body uk-article tm-ignore-container">
                            <header class="uk-text-center">
                                <h1 class="uk-article-title">About</h1>
                            </header>
                            <div class="uk-article-body">
                                <p class="uk-text-lead uk-text-center">Urabitur justo diam, auctor vitae ornare
                                    sit amet, accumsan sed neque. Curabitur efficitur lacinia euismod. Nunc
                                    dictum sagittis lacus. Etiam ultrices nulla orci, in ultrices risus.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac tortor
                                    sit amet nisi malesuada commodo. Phasellus et tempus justo. Sed iaculis
                                    dignissim lacinia. Nulla id felis vel ligula tempus sodales vel a ante.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis neque
                                    ac elit lacinia laoreet. Sed dolor sem, rutrum ac egestas non, tempor nec
                                    eros. Etiam lobortis porta viverra. Etiam ut suscipit sem, a volutpat mi.
                                    Maecenas euismod a lectus ut dapibus. Nulla mattis diam et leo lacinia
                                    dignissim.</p>
                                <h2 class="uk-text-center">Our principles</h2>
                                <ul class="uk-list uk-list-bullet">
                                    <li>Vestibulum ut mollis est. Fusce iaculis mauris ut tortor convallis
                                        sollicitudin. Suspendisse porta nulla nibh, id lacinia lacus tempus ut.
                                        Morbi non arcu aliquam, placerat sapien a, luctus diam. Etiam mattis
                                        cursus sem, eu maximus nisi bibendum nec. Vivamus ut turpis augue.
                                        Phasellus vehicula risus sit amet mi luctus malesuada.</li>
                                    <li>Curabitur justo diam, auctor vitae ornare sit amet, accumsan sed neque.
                                        Curabitur efficitur lacinia euismod. Nunc dictum sagittis lacus. Etiam
                                        ultrices nulla orci, in ultrices risus tincidunt ac. Cras et maximus
                                        mauris. Morbi aliquam efficitur maximus. Aenean orci diam, auctor a
                                        mattis eu, consectetur id urna.</li>
                                    <li>Morbi faucibus mattis ante. Donec varius neque sem, nec convallis mi
                                        dictum ut. Duis sit amet massa ac eros luctus egestas. Proin hendrerit
                                        aliquam metus, ac tincidunt risus viverra at. In viverra, ligula in
                                        facilisis interdum, dui arcu varius purus, eu blandit mi mi ut diam.
                                        Phasellus finibus metus sit amet lobortis dapibus. Nunc fringilla ac
                                        erat vitae elementum. Donec sagittis odio non mi vestibulum accumsan.
                                    </li>
                                </ul>
                                <h2 class="uk-text-center">Our team</h2>
                                <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m"
                                    uk-grid>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/thomas.svg" alt="Thomas Bruns"
                                                    width="80" height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>Thomas Bruns</div>
                                                <div class="uk-text-meta">Co-founder & CEO</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/george.svg" alt="George Clanton"
                                                    width="80" height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>George Clanton</div>
                                                <div class="uk-text-meta">Co-founder & President</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/martin.svg" alt="Martin Cade" width="80"
                                                    height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>Martin Cade</div>
                                                <div class="uk-text-meta">Co-founder & CTO</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/carol.svg" alt="Carol Issa" width="80"
                                                    height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>Carol Issa</div>
                                                <div class="uk-text-meta">Former Commercial Director</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/patricia.svg" alt="Patricia Kirk"
                                                    width="80" height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>Patricia Kirk</div>
                                                <div class="uk-text-meta">Former Director of Strategy</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div><img /about/nicole.svg" alt="Nicole Yokoyama"
                                                    width="80" height="80"></div>
                                            <div class="uk-width-expand">
                                                <div>Nicole Yokoyama</div>
                                                <div class="uk-text-meta">Product Marketing Manager</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="uk-text-center">Some stats</h2>
                                <div class="uk-child-width-1-1 uk-child-width-1-3@s uk-text-center" uk-grid>
                                    <div>
                                        <div class="uk-heading-primary uk-text-warning">5+</div>
                                        <div class="uk-margin-small-top">years on the market</div>
                                    </div>
                                    <div>
                                        <div class="uk-heading-primary uk-text-warning">150+</div>
                                        <div class="uk-margin-small-top">orders per day</div>
                                    </div>
                                    <div>
                                        <div class="uk-heading-primary uk-text-warning">75000+</div>
                                        <div class="uk-margin-small-top">clients</div>
                                    </div>
                                </div>
                                <h2 class="uk-text-center">Store</h2>
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
                            </div>
                        </article>
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