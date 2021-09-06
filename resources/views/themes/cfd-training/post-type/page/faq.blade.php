@extends(theme_extends())



<?php 

    title_head('Home');

    $GLOBALS['menu-main'] = 'hoi-dap';



    $banner = $post->banner;

    $video_id = $post->video_id;



    $faq = $post->faq;

 ?>



@section('content')
    <main class="faqpage" id="main">
        <div class="container">
            <section>
                <h2 class="main-title">Câu hỏi thường gặp</h2>
                <div class="row">
                    @forif( $faq as $f)
                    <div class="accordion_wrap col-md-8 offset-md-2 col-sm-12">
                        <h3 class="accordion__title-main">{!!$f['title']!!}</h3>

                        @forif($f['content'] as $f2)
                        <div class="accordion">
                            <div class="accordion__title">
                                <h2><strong>{!!$f2['question']!!}</strong></h2>
                            </div>
                            <div class="content">
                                {!!$f2['answer']!!}
                            </div>
                        </div>
                        @endforif
                    </div>
                    @endforif
                </div>
            </section>
        </div>
    </main>
@stop