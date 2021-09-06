<?php 
	$widgets = json_decode($sidebar->content,true);
 ?>

@foreach($widgets as $w)
 	@switch($w['type'])
 	@case('search')
 	<aside class="single_sidebar_widget search_widget">
        <form action="{!!route('page','search')!!}">
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" name="q" class="form-control" placeholder='@__t('Search Keyword')'
                        onfocus="this.placeholder = ''"
                        onblur="this.placeholder = '@__t('Search Keyword')'">
                    <div class="input-group-append">
                        <button class="btns" type="submit"><i class="ti-search"></i></button>
                    </div>
                </div>
            </div>
            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                type="submit">@__t('Search')</button>
        </form>
    </aside>
 	@break
 	@case('category')
 	<aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title">{!!$w['data']['title']!!}</h4>
        <ul class="list cat-list">

            <?php 
                $category = get_posts('blog_category',$w['data']['number_display']);
             ?>

             @foreach($category as $c)
            <li>
                <a href="{!!get_permalinks($c)!!}" class="d-flex">
                    <p>{!!$c->title!!}</p>
                </a>
            </li>
            @endforeach

        </ul>
    </aside>
 	@break
 	@case('recent-post')
 	<aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title">{!!$w['data']['title']!!}</h3>

        <?php 
	        $posts = get_posts('blog_post',$w['data']['number_display']);
	     ?>


     	@foreach($posts as $p)
        <div class="media post_item">
            <img style="max-width: 80px;" src="{!!get_media($p->image,null,'widget')!!}" alt="post">
            <div class="media-body">
                <a href="{!!get_permalinks($p)!!}">
                    <h3>{!!$p->title!!}</h3>
                </a>
                <p>{!!get_date($p->created_at)!!}</p>
            </div>
        </div>
        @endforeach

    </aside>
 	@break
 	@case('tag-clouds')
 	<aside class="single_sidebar_widget tag_cloud_widget">
        <h4 class="widget_title">{!!$w['data']['title']!!}</h4>
        <ul class="list">
        	<?php 
		        $posts = get_posts('blog_tag',$w['data']['number_display']);
		     ?>
     		@foreach($posts as $p)
            <li>
                <a href="{!!get_permalinks($p)!!}">{!!$p->title!!}</a>
            </li>
        	@endforeach
        </ul>
    </aside>
 	@break
 	@case('image-list')
 	<aside class="single_sidebar_widget instagram_feeds">
        <h4 class="widget_title">{!!$w['data']['title']!!}</h4>
        <ul class="instagram_row flex-wrap">

        	@forif($w['data']['images'] as $i)
            <li>
                <a href="{!!get_link($i['link'])!!}">
                    <img class="img-fluid" src="{!!get_media($i['image'],null,'listing')!!}" alt="">
                </a>
            </li>
            @endforif

        </ul>
    </aside>
 	@break
 	@case('newsletter')
 	<aside class="single_sidebar_widget newsletter_widget">
        <h4 class="widget_title">{!!$w['data']['title']!!}</h4>
        <form action="{!!route('post',['controller'=>'newsletter','method'=>'post'])!!}" class="f-ajax" method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-control input-title" onfocus="this.placeholder = ''"
                    onblur="this.placeholder = '@__t('Enter email')'" placeholder='@__t('Enter email')' required>
            </div>
            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                type="submit">@__t('Subscribe')</button>
        </form>
    </aside>
 	@break
	@endswitch
@endforeach