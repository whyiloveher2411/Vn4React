@extends(theme_extends())

@section('content')
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div class="uk-text-center">
                    <ul class="uk-breadcrumb uk-flex-center uk-margin-remove">
                        <li><a href="index-2.html">Home</a></li>
                        <li><span>FAQ</span></li>
                    </ul>
                    <h1 class="uk-margin-small-top uk-margin-remove-bottom">FAQ</h1>
                </div>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <section class="uk-width-1-1 uk-width-expand@m">
                            <article
                                class="uk-card uk-card-default uk-card-small uk-card-body uk-article tm-ignore-container">
                                <ul class="uk-list-divider uk-list-large" uk-accordion="multiple: true">
                                    <li><a class="uk-accordion-title" href="#">Lorem ipsum dolor sit amet,
                                            consectetur adipiscing elit?</a>
                                        <div class="uk-accordion-content">
                                            <p>Vivamus imperdiet venenatis est. Phasellus vitae mauris
                                                imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas
                                                sed libero quis orci egestas vehicula fermentum id diam. In
                                                sodales quam quis mi mollis eleifend id sit amet velit. Sed
                                                ultricies condimentum magna, vel commodo dolor luctus in.
                                                Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis
                                                sit amet, porta non est. Proin vehicula nisi eu molestie varius.
                                                Pellentesque semper ex diam, at tristique ipsum varius sed.
                                                Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis
                                                lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis
                                                dui sed quam consectetur elementum.</p>
                                        </div>
                                    </li>
                                    <li><a class="uk-accordion-title" href="#">Nullam massa sem, mollis ut
                                            luctus at, tincidunt a lorem?</a>
                                        <div class="uk-accordion-content">
                                            <p>Aliquam sed dictum elit, quis consequat metus. Proin in mauris
                                                finibus urna lacinia laoreet sed id orci. Pellentesque volutpat
                                                tellus sit amet enim rutrum, vel eleifend metus consectetur. Sed
                                                lacinia urna a neque maximus placerat. Praesent blandit
                                                hendrerit dui non placerat. Sed malesuada sem sit amet arcu
                                                faucibus, sit amet accumsan nisl laoreet. Quisque auctor sit
                                                amet nisl rhoncus interdum. Nullam euismod odio sem, quis
                                                pulvinar purus gravida eget. Nullam molestie, lacus vel vehicula
                                                elementum, massa arcu bibendum lacus, vitae tempus justo orci id
                                                lectus. Duis justo neque, elementum eget ante in, condimentum
                                                condimentum ante. Maecenas quis eleifend risus. In hac habitasse
                                                platea dictumst. Nunc posuere ultrices dolor, at auctor lacus
                                                dignissim ut. Donec viverra imperdiet nisi, sit amet mattis
                                                massa pellentesque ac.</p>
                                        </div>
                                    </li>
                                    <li><a class="uk-accordion-title" href="#">Aliquam pretium diam et
                                            ullamcorper malesuada?</a>
                                        <div class="uk-accordion-content">
                                            <p>Praesent feugiat lectus faucibus tellus congue pharetra. In
                                                viverra vehicula pellentesque. Etiam consectetur ultricies magna
                                                at bibendum. Sed posuere libero ut nulla ornare, faucibus
                                                pellentesque odio pulvinar. Vestibulum feugiat ex id ex
                                                elementum egestas. Integer laoreet mollis risus, id efficitur
                                                neque. Pellentesque quis dolor faucibus, ultrices tellus id,
                                                vestibulum neque. Sed eros purus, dignissim id fermentum ut,
                                                lacinia laoreet odio. Sed mi erat, aliquet at facilisis quis,
                                                laoreet in massa. Pellentesque eu massa accumsan, iaculis erat
                                                eu, tincidunt sem. Quisque id orci id dui congue pretium.
                                                Pellentesque iaculis, dolor aliquet tempor laoreet, enim metus
                                                tincidunt massa, ut porttitor sem dui sit amet arcu. Vestibulum
                                                sodales laoreet enim, sit amet vestibulum nisl porttitor a.</p>
                                        </div>
                                    </li>
                                    <li><a class="uk-accordion-title" href="#">Etiam suscipit at nisi eget
                                            auctor?</a>
                                        <div class="uk-accordion-content">
                                            <p>Mauris id pellentesque metus. In quis arcu sed enim maximus
                                                pellentesque et eget velit. Etiam euismod enim vitae condimentum
                                                tristique.</p>
                                        </div>
                                    </li>
                                    <li><a class="uk-accordion-title" href="#">Sed porta diam eget enim bibendum
                                            laoreet?</a>
                                        <div class="uk-accordion-content">
                                            <p>Donec molestie sem et tellus vestibulum venenatis. Quisque
                                                iaculis ornare luctus. Orci varius natoque penatibus et magnis
                                                dis parturient montes, nascetur ridiculus mus. Morbi velit nibh,
                                                ullamcorper eu imperdiet id, rutrum quis mi. Donec eu aliquet
                                                lorem. Nulla at lectus turpis. Sed et diam ac lorem iaculis
                                                lacinia.</p>
                                        </div>
                                    </li>
                                </ul>
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
                                        <li class="uk-active"><a href="faq.html">FAQ</a></li>
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