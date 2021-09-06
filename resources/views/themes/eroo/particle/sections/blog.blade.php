<section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="row d-flex">
                    <?php
                        $blogs = get_posts('eroo_blog',['count'=> $data['posts_per_page'] ?? 6, 'paginate'=>'page' ]);
                    ?>
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 ftco-animate">
                            <div class="blog-entry">
                                <a href="blog-single.html" class="block-20"
                                    style="background-image: url('@theme_asset()images/image_1.jpg');">
                                </a>
                                <div class="text d-block text-center">
                                    <div class="meta">
                                        <p>
                                            <a href="#"><span class="fa fa-calendar mr-2"></span>Sept. 30, 2020</a>
                                            <a href="#"><span class="fa fa-user mr-2"></span>Admin</a>
                                            <a href="#" class="meta-chat"><span class="fa fa-comment mr-2"></span> 3</a>
                                        </p>
                                    </div>
                                    <h3 class="heading"><a href="#">Applying your design principles</a></h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia...</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col">
                        <div class="block-27">
                            {!!get_paginate($blogs,'default')!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 sidebar ftco-animate pl-md-5 mt-5 mt-md-0 pt-md-0 pt-5">
                <div class="sidebar-box bg-light rounded">
                    <form action="#" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                </div>
                <div class="sidebar-box ftco-animate">
                    <div class="categories">
                        <h3>Services</h3>
                        <li><a href="#">UX/UI Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Branding &amp; Quiz</a></li>
                        <li><a href="#">Search Optimization</a></li>
                        <li><a href="#">Graphic Design</a></li>
                        <li><a href="#">Advance Analytic</a></li>
                    </div>
                </div>
                <div class="sidebar-box ftco-animate">
                    <h3>Recent Blog</h3>
                    <div class="block-21 mb-4 d-flex justify-content-between">
                        <a class="blog-img" style="background-image: url(@theme_asset()images/image_1.jpg);"></a>
                        <div class="text pl-3">
                            <h3 class="heading"><a href="#">Marketing Strategies for Digital Ecosystem</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="fa fa-calendar"></span> Sept. 30, 2020</a></div>
                                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-21 mb-4 d-flex justify-content-between">
                        <a class="blog-img" style="background-image: url(@theme_asset()images/image_2.jpg);"></a>
                        <div class="text pl-3">
                            <h3 class="heading"><a href="#">Marketing Strategies for Digital Ecosystem</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="fa fa-calendar"></span> Sept. 30, 2020</a></div>
                                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-21 mb-4 d-flex justify-content-between">
                        <a class="blog-img" style="background-image: url(@theme_asset()images/image_3.jpg);"></a>
                        <div class="text pl-3">
                            <h3 class="heading"><a href="#">Marketing Strategies for Digital Ecosystem</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="fa fa-calendar"></span> Sept. 30, 2020</a></div>
                                <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-box ftco-animate">
                    <h3>Tag Cloud</h3>
                    <div class="tagcloud">
                        <a href="#" class="tag-cloud-link">design</a>
                        <a href="#" class="tag-cloud-link">learn</a>
                        <a href="#" class="tag-cloud-link">education</a>
                        <a href="#" class="tag-cloud-link">course</a>
                        <a href="#" class="tag-cloud-link">online</a>
                        <a href="#" class="tag-cloud-link">bag</a>
                        <a href="#" class="tag-cloud-link">pen</a>
                        <a href="#" class="tag-cloud-link">teacher</a>
                    </div>
                </div>
                <div class="sidebar-box ftco-animate">
                    <h3>Paragraph</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                        necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa sapiente
                        consectetur similique, inventore eos fugit cupiditate numquam!</p>
                </div>
            </div>
        </div>
    </div>
</section>