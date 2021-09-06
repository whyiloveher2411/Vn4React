<div class="post-password-protected">
	<form action="{!!route('password-protected-post')!!}" method="POST">

		<input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
		<input type="text" name="id" value="{!!$post->id!!}" hidden>
		<input type="text" name="post_type" value="{!!$post->type!!}" hidden>

		<h2>{!!$post->title!!}</h2>
		<p class="description">@__('This content is password protected. To view it please enter your password below:')</p>

		<div class="form-password">
			<label>@__('Password'): 
				<input name="post_password" class="form-control" type="password">
			</label> 
			<input type="submit" class="btn btn-primary input-submit" value="@__('Submit')">
		</div>
	</form>
</div>