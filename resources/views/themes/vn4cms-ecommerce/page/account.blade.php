@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium" uk-grid>
                <div class="uk-width-1-1 uk-width-1-4@m tm-aside-column">
                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container"
                        uk-sticky="offset: 90; bottom: true; media: @m;">
                        <div class="uk-card-header">
                            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                                <section>
                                    <div
                                        class="uk-width-1-3 uk-width-1-4@s uk-width-1-2@m uk-margin-auto uk-visible-toggle uk-position-relative uk-border-circle uk-overflow-hidden uk-light">
                                        <img class="uk-width-1-1" src="@theme_asset()images/avatar.jpg"><a
                                            class="uk-link-reset uk-overlay-primary uk-position-cover uk-hidden-hover"
                                            href="#">
                                            <div class="uk-position-center"><span
                                                    uk-icon="icon: camera; ratio: 1.25;"></span></div>
                                        </a></div>
                                </section>
                                <div class="uk-text-center">
                                    <div class="uk-h4 uk-margin-remove">Thomas Bruns</div>
                                    <div class="uk-text-meta">Joined June 6, 2018</div>
                                </div>
                                <div>
                                    <div class="uk-grid-small uk-flex-center" uk-grid>
                                        <div><a class="uk-button uk-button-default uk-button-small"
                                                href="settings.html"><span class="uk-margin-xsmall-right"
                                                    uk-icon="icon: cog; ratio: .75;"></span><span>Settings</span></a>
                                        </div>
                                        <div><button class="uk-button uk-button-default uk-button-small"
                                                href="#" title="Log out"><span
                                                    uk-icon="icon: sign-out; ratio: .75;"></span></button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <nav>
                                <ul class="uk-nav uk-nav-default tm-nav">
                                    <li class="uk-active"><a href="account.html">Orders
                                            <span>(2)</span></a></li>
                                    <li><a href="favorites.html">Favorites
                                            <span>(3)</span></a></li>
                                    <li><a href="personal.html">Personal Info</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-1 uk-width-expand@m">
                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                        <header class="uk-card-header">
                            <h1 class="uk-h2">Orders</h1>
                        </header>
                        <section class="uk-card-body">
                            <h3><a class="uk-link-heading" href="#">#36637649
                                    <span class="uk-text-muted uk-text-small">from June 17, 2018</span></a></h3>
                            <table
                                class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
                                <tbody>
                                    <tr>
                                        <th class="uk-width-medium">Items</th>
                                        <td>7</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Shipping</th>
                                        <td>Pick up from store</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Payment</th>
                                        <td>Online by card</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Total</th>
                                        <td>$4896.00</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Status</th>
                                        <td><span class="uk-label">Processing</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                        <section class="uk-card-body">
                            <h3><a class="uk-link-heading" href="#">#36637648
                                    <span class="uk-text-muted uk-text-small">from June 16, 2018</span></a></h3>
                            <table
                                class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
                                <tbody>
                                    <tr>
                                        <th class="uk-width-medium">Items</th>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Shipping</th>
                                        <td>Pick up from store</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Payment</th>
                                        <td>Online by card</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Total</th>
                                        <td>$599.00</td>
                                    </tr>
                                    <tr>
                                        <th class="uk-width-medium">Status</th>
                                        <td><span class="uk-label uk-label-danger">Canceled</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
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