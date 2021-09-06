<?php 
// Template Name: Feed
// Icon: fa-rss
 ?>

@if( isset($setting) && $setting )

	

	<?php 

		$title = isset($widget['data']['title']) && $widget['data']['title']? $widget['data']['title'] :false;

		$url = isset($widget['data']['url']) && $widget['data']['url']? $widget['data']['url'] :false;

		$limit = isset($widget['data']['limit']) && $widget['data']['limit']? $widget['data']['limit'] :10;

		

	 ?>



	<div class="form-group">

		<label>Title</label> <input class="form-control" value="{!!$title!!}" name="data[title]"> 

	</div>

	<div class="form-group">

		<label>URL</label> <input class="form-control" value="{!!$url!!}" name="data[url]"> 

	</div>

	<div class="form-group">

		<label>Limit</label> <input class="form-control" value="{!!$limit!!}" name="data[limit]" > 

	</div>

@else

<?php 

	$url = isset($widget['data']['url']) && $widget['data']['url']? $widget['data']['url'] :false;

	$limit = isset($widget['data']['limit']) && $widget['data']['limit']? $widget['data']['limit']*1 :10;



	if( !$url  ){

		echo 'Please install to use the widget';

		return;

	}



	





?>

<div class="content-warper">



	<div class="widget-heading">

	    <h2>

	    	{!!isset($widget['data']['title']) ? $widget['data']['title'] :'';!!}

	    </h2>

	</div>

	<div class="body">

    	<?php 

    		$rss_feed =  Cache::remember( 'dashboard-feed-'.$url, 1440, function() use ($url){



    			$rss_feed = simplexml_load_file($url);



    			$result = [];



    			if(!empty($rss_feed) && isset($rss_feed->channel->item[0])) {

					foreach ($rss_feed->channel->item as $feed_item) {

						$result[] = ['title'=>$feed_item->title.'','link'=>$feed_item->link.'', 'pubDate'=>$feed_item->pubDate.''];



					}

				}



    			return $result;

    		});



			$i=0;

			foreach ($rss_feed as $feed_item) {

				if( $i++ === $limit ) break;

				?>

				<p class="light"><a target="_blank" href="{!!$feed_item['link']!!}">{!!$feed_item['title']!!}</a> {!!get_date_time($feed_item['pubDate'])!!}</p>

				<?php



			}

    	 ?>

	</div>

</div>



@endif

