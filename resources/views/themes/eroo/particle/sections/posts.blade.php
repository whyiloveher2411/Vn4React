<section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">{!!$data['subheading']!!}</span>
                <h2 class="mb-4">{!!$data['heading']!!}</h2>
            </div>
        </div>
        <div class="row d-flex">
            <?php
                $blogs = get_posts('eroo_blog',['count'=> $data['posts_per_page'] ?? 3]);
            ?>

            @foreach($blogs as $blog)
            <div class="col-md-4 ftco-animate">
                <div class="blog-entry">
                    <a href="{!!$link = get_permalinks($blog)!!}" class="block-20"
                        style="background-image: url({!!get_media($blog->thubnail)!!});">
                    </a>
                    <div class="text d-block text-center">
                        <div class="meta">
                            <p>
                                <a href="{!!$link!!}"><span class="fa fa-calendar mr-2"></span>{!!get_date($blog->created_at)!!}</a>
                                <a href="{!!$link!!}"><span class="fa fa-user mr-2"></span>Admin</a>
                                <a href="{!!$link!!}" class="meta-chat"><span class="fa fa-comment mr-2"></span> 3</a>
                            </p>
                        </div>
                        <h3 class="heading"><a href="{!!$link!!}">{!!$blog->title!!}</a></h3>
                        <p>{!!$blog->description!!}</p>
                    </div>
                </div>
            </div>
            @endforeach
         
        </div>
    </div>
</section>