@extends(theme_extends())

<?php 
	title_head('Home');
	$posts = get_posts('blog_post',['count'=>10,'paginate'=>'page']);
 ?>

@section('content')
<main>
	<div class="container">
		<div class="width-full  display-center">
			<h1 class="title-1">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</h1>
		</div>
		<div class="display-top margin-top-45">

			<div class="lists-blog flex ">
				<?php 
					foreach( $posts as $p):
						echo get_single_post($p);
					endforeach;

				?>
			</div>
		</div>
		{!!get_paginate($posts)!!}
	</div>
</main>
@stop