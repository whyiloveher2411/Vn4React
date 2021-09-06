@extends(theme_extends())

<?php
    $categories = ecommerce_categories();

    function showCategoryChildren($cats){
        foreach( $cats as $cat){
        ?>
            <li>
                <a href="<?php echo $cat['link'] ?>"><?php echo $cat['title'] ?></a>
                <?php if( isset($cat['children']) ) : ?>
                    <ul class="uk-list">
                        <?php showCategoryChildren($cat['children']) ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php
        }
    }
?>
@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>Catalog</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">Catalog</h1>
                    <div class="uk-text-meta uk-margin-xsmall-top">641 items</div>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <aside class="uk-width-1-4 uk-visible@m tm-aside-column">
                            <nav class="uk-card uk-card-default uk-card-body uk-card-small"
                                uk-sticky="bottom: true; offset: 90">
                                <ul class="uk-nav uk-nav-default" uk-scrollspy-nav="closest: li; scroll: true; offset: 90">
                                    @foreach( $categories as $catRoot )
                                    <li><a href="#cat-{!!$catRoot['id']!!}">{!!$catRoot['title']!!}</a></li>
                                    @endforeach
                                </ul>
                            </nav>
                        </aside>
                        <div class="uk-width-1-1 uk-width-expand@m">
                            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                                @foreach( $categories as $catRoot )
                                <section id="cat-{!!$catRoot['id']!!}">
                                    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                        <header class="uk-card-header">
                                            <div class="uk-grid-small uk-flex-middle" uk-grid><a
                                                    href="{!!$catRoot['link']!!}"><img src="@theme_asset()images/catalog/computers.svg"
                                                        alt="Laptops &amp; Tablets" width="50" height="50"></a>
                                                <div class="uk-width-expand">
                                                    <h2 class="uk-h4 uk-margin-remove"><a
                                                            class="uk-link-heading" href="{!!$catRoot['link']!!}">{!!$catRoot['title']!!}</a></h2>
                                                    <div class="uk-text-meta">367 items</div>
                                                </div>
                                            </div>
                                        </header>
                                        <div class="uk-card-body">
                                            <ul class="uk-list">
                                                @if( $catRoot['children'] )
                                                    @php
                                                        showCategoryChildren($catRoot['children'])
                                                    @endphp
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                                @endforeach
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