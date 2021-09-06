<section class="ftco-section">
    <div class="container">
      <div class="row">

          <?php
              $projects = get_posts('eroo_project',['count'=> $data['posts_per_page'] ?? 9, 'paginate'=>'page']);
          ?>

          @foreach($projects as $project)
          <?php
              $cat = json_decode($project->category_detail,true);
          ?>
          <div class="col-md-4 ftco-animate">
            <div class="project-wrap img d-flex align-items-end" style="background-image: url({!!get_media( $project->thubnail )!!});">
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
      <div class="row mt-5">
        <div class="col text-center">
          <div class="block-27">

            {!!get_paginate($projects,'default')!!}
            
          </div>
        </div>
      </div>
    </div>
  </section>