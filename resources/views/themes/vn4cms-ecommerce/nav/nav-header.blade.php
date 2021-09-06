<nav class="uk-visible@m">
    <ul class="uk-navbar-nav">
        @foreach($menu as $menuLevel1)
        <li>
            <a href="{!!$menuLevel1['link']!!}">
                {!!$menuLevel1['label']!!}
                @if( isset($menuLevel1['children'][0]) )
                <span class="uk-margin-xsmall-left" uk-icon="icon: chevron-down; ratio: .75;"></span>
                @endif
            </a>
            @if( isset($menuLevel1['children'][0]) )
            <div class="uk-navbar-dropdown uk-margin-remove uk-padding-remove-vertical"
                uk-drop="pos: bottom-justify;delay-show: 125;delay-hide: 50;duration: 75;boundary: .tm-navbar-container;boundary-align: true;pos: bottom-justify;flip: x">
                <div class="uk-container">
                    <ul class="uk-navbar-dropdown-grid uk-child-width-1-5" uk-grid>
                        @foreach($menuLevel1['children'] as $menuLevel2)
                        <li>
                            <div class="uk-margin-top uk-margin-bottom">
                                <a href="{!!$menuLevel2['link']!!}" class="uk-link-reset" href="category">
                                    @if( isset($menuLevel2['more_information'][0]['type']) && $menuLevel2['more_information'][0]['type'] === 'image' )
                                    <img class="uk-display-block uk-margin-auto uk-margin-bottom" src="{!!get_media($menuLevel2['more_information'][0]['value'])!!}" alt="Laptops &amp; Tablets" width="80" height="80">
                                    @endif
                                    <div class="uk-text-bolder">{!!$menuLevel2['label']!!}</div>
                                </a>
                                @if( isset($menuLevel2['children'][0]) )
                                <ul class="uk-nav uk-nav-default">
                                    @foreach( $menuLevel2['children'] as $menuLevel3)
                                    <li><a href="{!!$menuLevel3['link']!!}">{!!$menuLevel3['label']!!}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </li>
        @endforeach
    </ul>
</nav>