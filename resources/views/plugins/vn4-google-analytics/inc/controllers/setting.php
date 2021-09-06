<?php

return [
	'index'=>function($r, $plugin){

		if( check_permission('plugin_google_analytics_setting') ){

			$file_congig = __DIR__ . '/../client_secret_app.json';
			
			require_once cms_path('public','../lib/google-client/vendor/autoload.php');

			// Create the client object and set the authorization configuration

			if( file_exists($file_congig) ){
				$client = new Google_Client(['access_type'=>'offline']);

				// from the client_secrets.json you downloaded from the Developers Console.

				$client->setAuthConfig($file_congig);
				// Handle authorization flow from the server.

				$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
			}
			if( $r->isMethod('GET') ){

				$access_code = $plugin->getMeta('access_token_first');

				$data = ['plugin'=>$plugin];

				if( isset($access_code['access_code']) ){

					$data['auth_url'] = '';

					$data['accounts'] = json_decode(file_get_contents(__DIR__.'/../accounts.json'),true);

				}else{

					if( isset($client) ){
						$auth_url = $client->createAuthUrl();

						$data['auth_url'] = filter_var($auth_url, FILTER_SANITIZE_URL);
					}else{
						$data['auth_url'] = '';
					}

				}

				return view_plugin($plugin, 'views.setting',$data);

			}

			if( $r->isMethod('POST') ){

				if( env('EXPERIENCE_MODE') ){
				    return experience_mode();
				}


				if( $r->has('code-analytics') ){

					$code = $r->get('code-analytics');

					if( !$code ) $code = '';

					use_module('read_html');

					$html = str_get_html($code);

					$script = $html->find('script',0);

					if( $script ){
						$parts = parse_url($script->src);
						parse_str($parts['query'], $query);
						if( isset($query['id']) ){
							$code = $query['id'];
						}
					}

					$plugin->updateMeta('code-analytics',$code);
					$plugin->updateMeta('country',$r->get('country'));

					vn4_create_session_message( __('Success'), __p('Update Embed code Success.',$plugin->key_word), 'success' , true);

					return redirect()->back();

				}


				if( $r->get('clear_authorization') ){


					$plugin->updateMeta('access_token_first','');

					vn4_create_session_message('Success',__p('Clear Authorization Success',$plugin->key_word),'success');


				}elseif( $r->get('access_code') ){



					$client->authenticate($r->get('access_code'));



					$access_token = $client->getAccessToken();



					if( isset($access_token['refresh_token']) ){



						$access_token['access_code'] = $r->get('access_code');



						$plugin->updateMeta('access_token_first',$access_token);



						$access_token = $access_token['access_token'];



			          	$accounts = json_decode(file_get_contents_curl('https://www.googleapis.com/analytics/v3/management/accounts?access_token='.$access_token),true);



						foreach($accounts['items'] as $key => $ac){



							$accounts['items'][$key]['webproperties'] = json_decode(file_get_contents_curl($ac['childLink']['href'].'?access_token='.$access_token),true);



						}



						file_put_contents(__DIR__.'/../accounts.json', json_encode($accounts));



						vn4_create_session_message('Success',__p('Get Access Token Success',$plugin->key_word),'success');



					}else{

						vn4_create_session_message('Success',__p('Get Access Token Error',$plugin->key_word),'error');

					}



				}elseif ( $r->get('webpropertie_id') ) {

					$access_code = $plugin->getMeta('access_token_first');

					$listAnalyticsWebsite = $r->get('webpropertie_id');

					$listResult = [];

					if( isset($listAnalyticsWebsite[0]) ){

						foreach ($listAnalyticsWebsite as $key => $value) {
							$website = json_decode($value,true);
							$listResult[$website[0]] = $website;
						}

						$webid = reset($listResult);
						$access_code['webpropertie_id'] = $webid[0];
						$dataMeta['website'] = $webid;
					}

					// if( $country = $r->get('country') ){
						$dataMeta['country'] = $r->get('country');
					// }

					$dataMeta['listAnalyticsWebsite'] = $listResult;

					$dataMeta['access_token_first'] = $access_code;

					$plugin->updateMeta($dataMeta);

					vn4_create_session_message('Success',__p('Update View Success',$plugin->key_word),'success');

				}elseif( $r->get('file_app_json') ){

					$file = json_decode($r->get('file_app_json'));

					if( isset($file->link) ){

						if( $file->type_link === 'local' ){
							$file = cms_path('public',urldecode($file->link));
						}else{
							$file = $file->link;
						}

					}
					if( $file ){
						copy($file,__DIR__.'/../client_secret_app.json');
					}

					
					$plugin->updateMeta('file_app_json',$r->get('file_app_json'));
					vn4_create_session_message('Success',__p('Update File Success',$plugin->key_word),'success');
				}

			}

			return redirect()->back();

		}

		vn4_create_session_message('Permission','You do not have permission to view and edit google analytics settings!','warning');

		return redirect()->back();

	}
];