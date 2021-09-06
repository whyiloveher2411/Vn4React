<?xml version="1.0" encoding="UTF-8"?>

@if( $type === 'sitemap' )
	<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		<?php

		$post_type_actived = $plugin->getMeta('post-type-sitemap');

		if( !is_array($post_type_actived) ) $post_type_actived = [];

		$domain = env('APP_URL');

		?>
		@foreach($post_type_actived as $p)
		<sitemap>
	      <loc>{!!route('sitemap_detail',$p)!!}</loc>
	   </sitemap>
		@endforeach

	</sitemapindex>
@else
	
	<?php 

		$numberPerPage = 500;

		if( strpos($type,'-page-') !== false ){

			$type2 = substr($type, 0, strpos($type,'-page-'));
			$page = substr($type, strpos($type,'-page-') + 6 )*1;

			Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
		        return $page;
		    });

			if( $post_type = get_admin_object($type2) ){

				$posts = DB::table($post_type['table'])->where('type',$type2)->where('status','publish')->paginate($numberPerPage);


				?>
					<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
					     @foreach($posts as $p)
						<url>
							<loc>{!!get_permalinks($p)!!}</loc>
							<priority>1.0</priority>
							<lastmod>{!!date(DATE_ATOM, strtotime($p->updated_at))!!}</lastmod>
							<changefreq>daily</changefreq>
						</url>
						 @endforeach

					</urlset>
				<?php

			}


		}elseif( $post_type = get_admin_object($type) ){


			$count = DB::table($post_type['table'])->where('type',$type)->where('status','publish')->count();


			if( $count > $numberPerPage ){

				$page =  ceil( $count / $numberPerPage );

				echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

				for ($i=1; $i <= $page ; $i++) { 
					?>
					<sitemap>
				      <loc>{!!route('sitemap_detail',$type.'-page-'.$i)!!}</loc>
				   </sitemap>
					<?php
				}
				echo '</sitemapindex>';

			}else{
				$posts = DB::table($post_type['table'])->where('type',$type)->where('status','publish')->get();
				?>
					<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
					     @foreach($posts as $p)
						<url>
							<loc>{!!get_permalinks($p)!!}</loc>
							<priority>1.0</priority>
							<lastmod>{!!date(DATE_ATOM, strtotime($p->updated_at))!!}</lastmod>
							<changefreq>daily</changefreq>
						</url>
						 @endforeach

					</urlset>
				<?php	
			}
		}
	 ?>
@endif
