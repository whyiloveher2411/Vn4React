<section class="ftco-section ftco-portfolio bg-light">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-between pb-5">
            <div class="col-md-6 col-lg-6 heading-section heading-section-white ftco-animate">
                <span class="subheading">{!!$data['subheading']!!}</span>
                <h2 class="mb-4">{!!$data['heading']!!}</h2>
            </div>
            <div class="col-md-4 col-lg-3 d-flex align-items-center justify-content-end">
                <a href="{!!$data['button_right']['link']!!}" class="btn-custom">{!!$data['button_right']['label']!!} <span class="fa fa-chevron-right"></span></a>
            </div>
        </div>
        <div class="row">

            <?php
                $projects = get_posts('eroo_project',['count'=> $data['posts_per_page'] ?? 6]);
            ?>

            @foreach($projects as $project)
            <?php
                $cat = json_decode($project->category_detail,true);
            ?>
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap img d-flex align-items-end"
                    style="background-image: url({!!get_media( $project->thubnail )!!});">
                    <div class="text">
                        <span>{!!@$cat['title']!!}</span>
                        <h3><a href="{!!$link = get_permalinks($project)!!}">{!!$project->title!!}</a></h3>
                        <a href="{!!$link!!}" class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>