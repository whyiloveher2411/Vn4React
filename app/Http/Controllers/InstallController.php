<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Vn4Model;
use Hash;

class InstallController extends Controller {

	public function install(Request $r, $any = null){
		if($any === 'standard'){

			if( $r->isMethod('GET') ){
				?>
					<!DOCTYPE html>
					<html lang="en">
					<head>
						<meta charset="UTF-8">
						<title>Vn4CMS Install</title>
						<style>
						.content{
							background: #fff;
							max-width: 620px;
							padding: 20px;
							margin: 0 auto;
							margin-top: 5px;
							border-radius: 3px;
							color: #4c4c4c;
							font-family: sans-serif;
							font-size: 13px;
						}
						.content tr{

						}


						.content td{
							vertical-align: top;
							padding-bottom: 7px;
						}
						.content tr td:first-child{
							vertical-align: middle;
						}
						.content input{
							padding: 0 5px;
							height: 24px;
							border-radius: 3px;
							outline: none;
							border: 1px solid #bababa;
							cursor: auto;
						}
						.content label{
							font-weight: bold;
							cursor: pointer;
						}
						.content p{
							margin: 0;
						}
						.loading{
							position: fixed;
							width: 100%;
							bottom: 0;
							top: 0;
							text-align: center;
							display: none;
						    background: rgba(255, 250, 205, 0.69);
						}
						</style>
					</head>
					<body style="background: #dcdcdc;">
						<header style="text-align: center;">
							<img src="<?php echo asset('public/admin/images/logo-full.png') ?>" class="logo" alt="">
						</header>
						<div class="content">
							<h1>Welcome</h1>
							<p>Just a few more steps you have a complete website based on Vn4CMS</p><br>
							<h1>Information needed</h1>
							<p>Please provide the following information. Don’t worry, you can always change these settings later.</p>
							<hr>
							<table>
								<tr>
									<td style="width: 140px;"><label for="site_title">Site Title</label></td>
									<td style="padding-right: 10px;"> <input type="text" id="site_title"></td>
								</tr>
								<tr>
									<td style="width: 140px;"><label for="first_name">First Name</label></td>
									<td style="padding-right: 10px;"> <input type="text" id="first_name"></td>
								</tr>
								<tr>
									<td style="width: 140px;"><label for="last_name">Last Name</label></td>
									<td style="padding-right: 10px;"> <input type="text" id="last_name"></td>
								</tr>
								<tr>
									<td><label for="email">Email</label></td>
									<td><input type="email" id="email"><br>
										<p>Double-check your email address before continuing.</p>
										<p>Email is used when you log into the webmaster site.</p>
									</td>
								</tr>
								<tr>
									<td><label for="password">Password</label></td>
									<td><input type="text" id="password"></td>
								</tr>
							</table>
							<hr>
							<input style="cursor:pointer;" type="submit" id="create_data">
						</div>
						<div class="loading">
							<img src="<?php echo asset('public/images/loading.gif') ?>" alt="">
						</div>
						<script src="<?php echo asset('public/vendors/jquery/jquery.min.js'); ?>"></script>
						<script>
						var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz!@#$%^&*()_+<>?~";
						var string_length = 16;
						var randomstring = '';
						for (var i=0; i<string_length; i++) {
							var rnum = Math.floor(Math.random() * chars.length);
							randomstring += chars.substring(rnum,rnum+1);
						}

						$('#password').val(randomstring);

						


							$('#create_data').click(function(event) {

								var site_title = $('#site_title').val(),password = $('#password').val(),first_name = $('#first_name').val(),last_name = $('#last_name').val();

								var email = document.getElementById('email').value;

								var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
								if(site_title.trim() === ''){
									alert('Please enter some information about site title');
									return;
								}
								if(first_name.trim() === '' ){
									alert('Please enter first name');
									return;
								}
								if(last_name.trim() === ''){
									alert('Please enter last name');
									return;
								}
								if(password.trim() === '' || password.length < 6){
									alert('Please enter the password format to the length of larger than 5 characters');
									return;
								}

								if( re.test(email) ){
									$('.loading').show();
									$.ajax({
										type: 'POST',
										dataType: 'Json',
										data: {
											email:email,
											password:password,
											first_name:$('#first_name').val(),
											last_name:$('#last_name').val(),
											site_title:site_title,
											_token:'<?php echo csrf_token(); ?>',
										},
										success:function(data){
											console.log(data);
										}
									});
								}else{
									alert('Please enter the correct email format.');
								}
							});

					</script>
				</body>
			</html>
			<?php
			}

			if( $r->isMethod('POST') ){
				$input = $r->only(['email','password','first_name','last_name','site_title']);

				$tbpf = env('TABLE_PREFIX');

				$user = new Vn4Model($tbpf.'user');
				$user->email = trim($input['email']);
				$user->password = Hash::make(trim($input['password']));
				$user->slug = str_slug($input['first_name'].'-'.$input['last_name']);
				$user->permission = 'appearance_menu_client_edit, appearance_menu_client_delete, view_plugin_debug_error, vn4fanpage-post_list, vn4fanpage-post_create, vn4fanpage-post_edit, vn4fanpage-post_trash, vn4fanpage-post_delete, vn4fanpage-post_restore, vn4fanpage-post_detail, vn4fanpage-video_list, vn4fanpage-video_create, vn4fanpage-video_edit, vn4fanpage-video_trash, vn4fanpage-video_delete, vn4fanpage-video_restore, vn4fanpage-video_detail, vn4fanpage-photo_list, vn4fanpage-photo_create, vn4fanpage-photo_edit, vn4fanpage-photo_trash, vn4fanpage-photo_delete, vn4fanpage-photo_restore, vn4fanpage-photo_detail, code_reference_function_list, code_reference_function_create, code_reference_function_edit, code_reference_function_trash, code_reference_function_delete, code_reference_function_restore, code_reference_function_detail, vn4fanpage-fanpage_list, vn4fanpage-fanpage_create, vn4fanpage-fanpage_edit, vn4fanpage-fanpage_trash, vn4fanpage-fanpage_delete, vn4fanpage-fanpage_restore, vn4fanpage-fanpage_detail, category_list, category_create, category_edit, category_trash, category_delete, category_restore, category_detail, post_list, post_create, post_edit, post_trash, post_delete, post_restore, post_detail, tag_list, tag_create, tag_edit, tag_trash, tag_delete, tag_restore, tag_detail, page_list, page_create, page_edit, page_trash, page_delete, page_restore, page_detail, user_list, user_create, user_edit, user_trash, user_delete, user_restore, user_detail, vn4plugin-subscribe_list, vn4plugin-subscribe_create, vn4plugin-subscribe_edit, vn4plugin-subscribe_trash, vn4plugin-subscribe_delete, vn4plugin-subscribe_restore, vn4plugin-subscribe_detail, appearance-menu_view, appearance-theme_view, appearance-widget_view, language_view, media_view, plugin_view, profile_view, tool-genaral_view, user-new_view, user-role-editor_view, view_setting, change_setting_general, change_setting_security, plugin_action';
				$user->type = 'user';
				$user->first_name = trim($input['first_name']);
				$user->last_name = trim($input['last_name']);
				$user->status = 'publish';
				$user->status_old = 'publish';
				$user->save();

				 DB::table($tbpf.'setting')->insert([
					 		['key_word'=>'general_client_theme',
					 		'content'=>'vn4cms-dot-com',
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'general_site_title',
					 		'content'=>trim($input['site_title']),
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'general_email_address',
					 		'content'=>trim($input['email']),
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'general_timezone',
					 		'content'=>'UTC+0',
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'general_date_format',
					 		'content'=>'d/m/Y',
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'general_time_format',
					 		'content'=>'H:i',
					 		'group'=>'general',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'security_prefix_link_admin',
					 		'content'=>'admin2',
					 		'group'=>'security',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'security_link_login',
					 		'content'=>'login2',
					 		'group'=>'security',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'lang_default',
					 		'content'=>'{"en":"English"}',
					 		'group'=>'language',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
					 		['key_word'=>'list_lang',
					 		'content'=>'{"en":"English"}',
					 		'group'=>'language',
					 		'status'=>'publish',
					 		'type'=>'setting',
					 		'author'=>0],
				 	]);


			}

		}else{

			if( $r->isMethod('GET') ){

				$step = intval($r->get('step',1));

				if( $step === 1 ){
					?>
						<!DOCTYPE html>
						<html lang="en">
						<head>
							<meta charset="UTF-8">
							<title>Vn4CMS Install</title>
							<style>
							.content{
								background: #fff;
								max-width: 620px;
								padding: 20px;
								margin: 0 auto;
								margin-top: 5px;
								border-radius: 3px;
								color: #4c4c4c;
								font-family: sans-serif;
								font-size: 13px;
							}
							.content tr{

							}


							.content td{
								vertical-align: top;
								padding-bottom: 7px;
							}
							.content tr td:first-child{
								vertical-align: middle;
							}
							.content input{
								padding: 0 5px;
								height: 24px;
								border-radius: 3px;
								outline: none;
								border: 1px solid #bababa;
								cursor: auto;
							}
							.content label{
								font-weight: bold;
								cursor: pointer;
							}
							.content p{
								margin: 0;
							}
							.loading{
								position: fixed;
								width: 100%;
								bottom: 0;
								top: 0;
								text-align: center;
								display: none;
							    background: rgba(255, 250, 205, 0.69);
							}
							</style>
						</head>
						<body style="background: #dcdcdc;">
							<header style="text-align: center;">
								<img src="<?php echo asset('public/admin/images/logo-full.png') ?>" class="logo" alt="">
							</header>
							<div class="content">
								<h1>Welcome Vn4CMS</h1>
								<p>First, please provide information about the database, the installation process may take some time.</p>
								<hr>
								<table>
									<tr>
										<td style="width: 140px;"><label for="db_name">Database Name</label></td>
										<td style="padding-right: 10px;"> <input type="text" id="db_name" value="vn4cms"></td>
										<td><p>The name of the database you want run Vn4CMS in.</p></td>
									</tr>
									<tr>
										<td><label for="username">User name</label></td>
										<td><input type="text" value="username" id="username"></td>
										<td><p>Your MySQL username</p></td>
									</tr>
									<tr>
										<td><label for="password">Password</label></td>
										<td><input type="text" value="password" id="password"></td>
										<td><p>your MySQL password</p></td>
									</tr>
									<tr>
										<td><label for="db_host">Database Host</label></td>
										<td><input type="text" value="localhost" id="db_host"></td>
										<td><p>You should be able to get this info form your web host. If localhost doesn't work.</p></td>
									</tr>
									<tr>
										<td><label for="tbpf">Table Prefix</label></td>
										<td><input type="text" value="vn4_" id="tbpf"></td>
										<td><p>If you want to run multiple Vn4CMS installations in a single database, change this.</p></td>
									</tr>
								</table>
								<hr>
								<input style="cursor:pointer;" type="submit" id="info-db">
							</div>
							<div class="loading">
								<img src="<?php echo asset('public/images/loading.gif') ?>" alt="">
							</div>
							<script src="<?php echo asset('public/vendors/jquery/jquery.min.js'); ?>"></script>
							<script>
							$('#info-db').click(function(event) {
								$('.loading').show();
								$.ajax({
									type: 'GET',
									dataType: 'Json',
									data: {
										db_name:$('#db_name').val(),
										username:$('#username').val(),
										password:$('#password').val(),
										db_host:$('#db_host').val(),
										tbpf:$('#tbpf').val(),
										step:2,
									},
									success:function(data){
										$.ajax({
											type: 'GET',
											dataType: 'Json',
											data: {
												db_name:$('#db_name').val(),
												username:$('#username').val(),
												password:$('#password').val(),
												db_host:$('#db_host').val(),
												tbpf:$('#tbpf').val(),
												step:3,
											},
											success:function(data){
												if( data.error ){
													alert(data.error.message);
													$('.loading').hide();
												}else{
													$.ajax({
														type: 'GET',
														dataType: 'Json',
														data: {
															create_table:true,
															step:4,
														},
														success:function(data){
															if( data.error ){
																alert(data.error.message);
																$('.loading').hide();
															}

															if( data.success ){
																window.location.href = '<?php echo route('install',['step'=>'standard']); ?>';
															}
														}
													});
												}
											}
										});
									}
								});

							});
						</script>
					</body>
				</html>
				<?php
				}

				if( $step === 2 || $step === 3 ){
					File::put('.env', "APP_ENV=local\n".
						"APP_DEBUG=true\n".
						"APP_KEY=".str_random(32)."\n\n".

						"DB_HOST=".$r->get("db_host")."\n".
						"DB_DATABASE=".$r->get("db_name")."\n".
						"DB_USERNAME=".$r->get("username")."\n".
						"DB_PASSWORD=".$r->get("password")."\n".
						"TABLE_PREFIX=".$r->get("tbpf")."\n\n".

						"CACHE_DRIVER=file\n".
						"SESSION_DRIVER=file\n".
						"QUEUE_DRIVER=sync\n\n".

						"MAIL_DRIVER=smtp\n".
						"MAIL_HOST=\n".
						"MAIL_PORT=2525\n".
						"MAIL_USERNAME=\n".
						"MAIL_PASSWORD=\n");

					try {
						DB::connection()->getPdo();
						return response()->json(['success'=>true]);
					} catch (\Exception $e) {
						return response()->json(['error'=>[
							'message'=>$e->getMessage(),
							]]);
					}
				}

				if( $step === 4 ){
					$tbpf = env('TABLE_PREFIX');

					try {
						
						//table setting
						\Illuminate\Support\Facades\Schema::create($tbpf.'setting', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->integer('author')->unsigned()->default(0);
							$table->text('meta');
							$table->string('type',100);
							$table->string('status',20)->default('publish');
							$table->string('group',100);
							$table->text('content');
							$table->string('key_word',255)->unique();
							$table->timestamps();
						});


						//table widget
						\Illuminate\Support\Facades\Schema::create($tbpf.'widget', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->string('sidebar_id',255);
							$table->text('content');
							$table->string('status',20)->default('publish');
							$table->text('meta');
							$table->string('theme',255);
							$table->unique(['sidebar_id','theme']);
							$table->timestamps();
						});


						//table menu
						\Illuminate\Support\Facades\Schema::create($tbpf.'menu', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->string('title',255);
							$table->integer('author')->unsigned()->default(0);
							$table->text('json');
							$table->string('type',100);
							$table->string('status',20)->default('publish');
							$table->text('content');
							$table->string('key_word',255);
							$table->string('theme',255);
						 	$table->unique(['key_word','theme']);
							$table->timestamps();
						});


						//table user
						\Illuminate\Support\Facades\Schema::create($tbpf.'user', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->text('description');
							$table->string('slug', 255);
							$table->string('email', 60);
							$table->string('password', 60);
							$table->string('first_name', 60);
							$table->string('last_name', 60);
							$table->longText('permission');
							$table->string('type',100);
							$table->text('meta');
							$table->string('status',20)->default('publish');
							$table->string('status_old',20)->default('publish');
							$table->string('post_date_gmt', 20);
							$table->string('visibility', 50);
							$table->unique(['slug','type']);
							$table->rememberToken();
							$table->timestamps();
						});


						//table post
						\Illuminate\Support\Facades\Schema::create($tbpf.'post', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->string('title', 255);
							$table->string('slug', 255);
							$table->string('description',500);
							$table->longText('content');
							$table->text('image');
							$table->integer('author')->unsigned()->default(0);
							$table->text('category');
							$table->text('tag');
							$table->string('type',100);
							$table->text('meta');
							$table->string('view',20);
							$table->string('status',20)->default('publish');
							$table->string('status_old',20)->default('publish');
							$table->string('password', 60);
							$table->string('post_date_gmt', 20);
							$table->string('visibility', 50);
							$table->unique(['slug','type']);
							$table->timestamps();
						});

						//table page
						\Illuminate\Support\Facades\Schema::create($tbpf.'page', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->string('title', 255);
							$table->string('slug', 255);
							$table->string('description',500);
							$table->longText('content');
							$table->text('image');
							$table->integer('author')->unsigned()->default(0);
							$table->string('type',100);
							$table->text('meta');
							$table->string('view',20);
							$table->string('status',20)->default('publish');
							$table->string('status_old',20)->default('publish');
							$table->string('password', 60);
							$table->string('post_date_gmt', 20);
							$table->string('visibility', 50);
							$table->unique(['slug','type']);
							$table->timestamps();
						});

						//table tag
						\Illuminate\Support\Facades\Schema::create($tbpf.'tag', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->string('title', 255);
							$table->string('slug', 255);
							$table->string('description',500);
							$table->longText('content');
							$table->text('image');
							$table->integer('author')->unsigned()->default(0);
							$table->integer('parent')->unsigned()->default(0);
							$table->string('type',100);
							$table->text('meta');
							$table->string('view',20);
							$table->string('status',20)->default('publish');
							$table->string('status_old',20)->default('publish');
							$table->string('password', 60);
							$table->string('post_date_gmt', 20);
							$table->string('visibility', 50);
							$table->unique(['slug','type']);
							$table->timestamps();
						});

						//table post - category
						\Illuminate\Support\Facades\Schema::create($tbpf.'post_category', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->integer('post_id')->unsigned();
							$table->integer('tag_id')->unsigned();
							$table->string('type',100);

							$table->unique(['post_id','tag_id']);
							$table->timestamps();
						});


						//table post - tag
						\Illuminate\Support\Facades\Schema::create($tbpf.'post_tag', function($table)
						{
							$table->increments(->_id)->unsignedInteger();
							$table->integer('post_id')->unsigned();
							$table->integer('tag_id')->unsigned();
							$table->string('type',100);
							
							$table->unique(['post_id','tag_id']);
							$table->timestamps();
						});
					} catch (\Exception $e) {
						return response()->json(['error'=>[
							'message'=>$e->getMessage(),
							]]);
					}


					// foreach ($object['fields'] as $column_name => $column_value) {
						
					// 	if( ! \Illuminate\Support\Facades\Schema::hasColumn( $object['table'], $column_name ) ) {
					// 		\Illuminate\Support\Facades\Schema::table($object['table'], function($table) use ($column_name)
					// 		{

					// 			$table->text($column_name);

					// 		});
					// 	}

					// }
					return response()->json(['success'=>true]);
				}
			}
		}
	}

}
