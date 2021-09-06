<header>
    <div class="uk-navbar-container uk-light uk-visible@m tm-toolbar-container">
        <div class="uk-container" uk-navbar>
            <div class="uk-navbar-left">
                <nav>
                    <ul class="uk-navbar-nav">
                        <li><a href="#"><span class="uk-margin-xsmall-right"
                                    uk-icon="icon: receiver; ratio: .75;"></span><span class="tm-pseudo">8 800
                                    799 99 99</span></a></li>
                        <li><a href="contacts" onclick="return false"><span class="uk-margin-xsmall-right"
                                    uk-icon="icon: location; ratio: .75;"></span><span class="tm-pseudo">Store
                                    in St. Petersburg</span><span
                                    uk-icon="icon: triangle-down; ratio: .75;"></span></a>
                            <div class="uk-margin-remove" uk-drop="mode: click; pos: bottom-center;">
                                <div
                                    class="uk-card uk-card-default uk-card-small uk-box-shadow-xlarge uk-overflow-hidden uk-padding-small uk-padding-remove-horizontal uk-padding-remove-bottom">
                                    <figure class="uk-card-media-top uk-height-small js-map"
                                        data-latitude="59.9356728" data-longitude="30.3258604" data-zoom="14">
                                    </figure>
                                    <div class="uk-card-body">
                                        <div class="uk-text-small">
                                            <div class="uk-text-bolder">Store Name</div>
                                            <div>St.&nbsp;Petersburg, Nevsky&nbsp;Prospect&nbsp;28</div>
                                            <div>Daily 10:00–22:00</div>
                                        </div>
                                        <div class="uk-margin-small"><a
                                                class="uk-link-muted uk-text-uppercase tm-link-to-all uk-link-reset"
                                                href="contacts"><span>contacts</span><span
                                                    uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="uk-navbar-item"><span class="uk-margin-xsmall-right"
                                    uk-icon="icon: clock; ratio: .75;"></span>Daily 10:00–22:00</div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="uk-navbar-right">
                <nav>
                    <ul class="uk-navbar-nav">
                        <li><a href="news">News</a></li>
                        <li><a href="faq">FAQ</a></li>
                        <li><a href="#">Payment</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="uk-navbar-container tm-navbar-container" uk-sticky="cls-active: tm-navbar-container-fixed">
        <div class="uk-container" uk-navbar>
            <div class="uk-navbar-left">
                <button class="uk-navbar-toggle uk-hidden@m" uk-toggle="target: #nav-offcanvas" uk-navbar-toggle-icon></button>
                    <a class="uk-navbar-item uk-logo" href="{!!route('index')!!}">
                        <img src="@theme_asset()images/logo.svg" width="90" height="32" alt="Logo">
                    </a>
                    {!!vn4_nav_menu('nav-header','nav-header')!!}
            </div>
            <div class="uk-navbar-right"><a class="uk-navbar-toggle tm-navbar-button" href="#"
                    uk-search-icon></a>
                <div class="uk-navbar-dropdown uk-padding-small uk-margin-remove"
                    uk-drop="mode: click;cls-drop: uk-navbar-dropdown;boundary: .tm-navbar-container;boundary-align: true;pos: bottom-justify;flip: x">
                    <div class="uk-container">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                <form class="uk-search uk-search-navbar uk-width-1-1"><input
                                        class="uk-search-input" type="search" placeholder="Search…" autofocus>
                                </form>
                            </div>
                            <div class="uk-width-auto"><a class="uk-navbar-dropdown-close" href="#"
                                    uk-close></a></div>
                        </div>
                    </div>
                </div><a class="uk-navbar-item uk-link-muted uk-visible@m tm-navbar-button"
                    href="compare"><span uk-icon="copy"></span><span class="uk-badge">3</span></a><a
                    class="uk-navbar-item uk-link-muted tm-navbar-button" href="account"
                    uk-icon="user"></a>
                <div class="uk-padding-small uk-margin-remove"
                    uk-dropdown="pos: bottom-right; offset: -10; delay-hide: 200;" style="min-width: 150px;">
                    <ul class="uk-nav uk-dropdown-nav">
                        <li><a href="account">Orders
                                <span>(2)</span></a></li>
                        <li><a href="favorites">Favorites
                                <span>(3)</span></a></li>
                        <li><a href="personal">Personal</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#">Log out</a></li>
                    </ul>
                </div><a class="uk-navbar-item uk-link-muted tm-navbar-button" href="cart"
                    uk-toggle="target: #cart-offcanvas" onclick="return false"><span uk-icon="cart"></span><span
                        class="uk-badge">2</span></a>
            </div>
        </div>
    </div>
</header>