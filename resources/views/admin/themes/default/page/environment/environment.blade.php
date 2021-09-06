@extends(backend_theme('master'))

@php
	title_head('Environment')


@endphp
	<?php 
	add_action('vn4_head',function(){
    ?>
      <style>
        .form-setting .control-label{
            text-align: left;
        }
        .default_input_img_result img{
          max-width: 200px;
        }
		.vn4_tabs_left{
            display: flex;
              -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
            -moz-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.125);
        }
        .vn4_tabs_left>.clearfix{
          width: 0;
        }
        .vn4_tabs_left .content-right{
            background: #fff;
            width: 100%;
            display: block;
            margin: 0;
        }
        .vn4_tabs_left .menu-left{
            flex: 1;
            min-width: 240px;
            display: contents;
        }
        .vn4_tabs_left .menu-left ul{
          margin: 0;

        }
        .vn4_tabs_left .menu-left li{
            text-align: left;
            margin: 0;
            background-color: #F2F0F0;
        }
        .vn4_tabs_left .menu-left a{

            white-space: nowrap;
            display: block;
            padding: 13px 19px;
                -webkit-box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
            box-shadow: 0 1px 3px -3px rgba(0, 0, 0, 0.15);
        }
        .vn4_tabs_left .tab{
          margin: 15px;
        }
        .vn4_tabs_left .menu-left li.active a{
          background: #fff;
        }
      </style>
	<?php
	  });
	 ?>
@section('content')
	<div class="" >
    <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">
	      <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
	  
	      <?php 
	        $list_setting = [
	        	'app'=>[
				    'title'=>__('App'),
				    'fields'=>[
				        'APP_NAME'=>[
				            'title'=>'APP_NAME',
				            'view'=>'text',
				        ],
				         'APP_ENV'=>[
				            'title'=>'APP_ENV',
				            'view'=>'text',
				        ],
				        'APP_KEY'=>[
				            'title'=>'APP_KEY',
				            'view'=>'text',
				        ],
				        'APP_DEBUG'=>[
				            'title'=>'APP_DEBUG',
				            'view'=>'checkbox',
				            'list_option'=>['active'=>''],
				            'value'=> [env('APP_DEBUG') === true?'active':'false'],
				        ],
				        'APP_URL'=>[
				        	'title'=>'APP_KEY',
				            'view'=>'text',
				        ],
				        'APP_URL'=>[
				        	'title'=>'APP_KEY',
				            'view'=>'text',
				        ],
				        'APP_LOG'=>[
				        	'title'=>'APP_LOG',
				            'view'=>'select',
				            'list_option'=>[
				            	'single'=>'Single','daily' => 'Daily', 'syslog'=>'Syslog','errorlog'=>'Errorlog'
				            ]
				        ],
				        'LOG_CHANNEL'=>[
				        	'title'=>'LOG_CHANNEL',
				            'view'=>'text',
				        ],
				        'BROADCAST_DRIVER'=>[
				        	'title'=>'BROADCAST_DRIVER',
				            'view'=>'text',
				        ],
				        'CACHE_DRIVER'=>[
				        	'title'=>'CACHE_DRIVER',
				        	'view'=>'select',
				            'list_option'=>[
				            	'apc'=>'APC','array' => 'Array', 'database'=>'Database','file'=>'File','memcached'=>'Memcached','redis'=>'Redis'
				            ]
				        ],
				        'SESSION_DRIVER'=>[
				        	'title'=>'SESSION_DRIVER',
				            'view'=>'select',
				            'list_option'=>[
				            	'file'=>'File',
				            	'cookie'=>'Cookie',
				            	'database'=>'Database',
				            	'apc'=>'APC',
				            	'memcached'=>'Memcached',
				            	'redis'=>'Redis',
				            	'array'=>'Array'
				            ]
				        ],
				        'SESSION_LIFETIME'=>[
				        	'title'=>'SESSION_LIFETIME',
				            'view'=>'number',
				        ],
				        'QUEUE_DRIVER'=>[
				        	'title'=>'QUEUE_DRIVER',
				            'view'=>'select',
				            'list_option'=>[
				            	'null'=>'NULL','sync' => 'Sync', 'database'=>'Database','beanstalkd'=>'Beanstalkd','sqs'=>'SQS','iron'=>'Iron','redis'=>'Redis'
				            ]
				        ],
				        'REDIS_HOST'=>[
				        	'title'=>'REDIS_HOST',
				            'view'=>'text',
				        ],
				        'REDIS_PASSWORD'=>[
				        	'title'=>'REDIS_PASSWORD',
				            'view'=>'text',
				        ],
				        'REDIS_PORT'=>[
				        	'title'=>'REDIS_PORT',
				            'view'=>'text',
				        ],
				    ],
				],
				'pusher'=>[
					'title'=>__('Pusher'),
					'fields'=>[
				        'PUSHER_APP_ID'=>[
				        	'title'=>'PUSHER_APP_ID',
				            'view'=>'text',
				        ],
				        'PUSHER_APP_KEY'=>[
				        	'title'=>'PUSHER_APP_KEY',
				            'view'=>'text',
				        ],
				        'PUSHER_APP_SECRET'=>[
				        	'title'=>'PUSHER_APP_SECRET',
				            'view'=>'text',
				        ],
				        'PUSHER_APP_CLUSTER'=>[
				        	'title'=>'PUSHER_APP_CLUSTER',
				            'view'=>'text',
				        ],
				        'MIX_PUSHER_APP_KEY'=>[
				        	'title'=>'MIX_PUSHER_APP_KEY',
				            'view'=>'text',
				        ],
				        'MIX_PUSHER_APP_CLUSTER'=>[
				        	'title'=>'MIX_PUSHER_APP_CLUSTER',
				            'view'=>'text',
				        ],
				    ]
	        	]
	        ];

	        $list_tab_setting = [];
	        $setting_db = setting();

	        foreach ($list_setting as $key => $setting) {

	             $list_tab_setting[$key] = [
	              'id'=>$key,
	              'title'=>$setting['title'],
	              'content'=>function() use ($setting,$setting_db,$key, $__env){
	                   ?>
	                     @foreach($setting['fields'] as $key2 => $field)
	    
	                      <?php 
	                        $field['key'] =  'env['.$key2.']';

	                        if( !isset($field['value']) ){
	                            $field['value'] = env($key2);
	                        }

	                       ?>
	                      
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domain">{!!$field['title']!!}
	                        </label>

	                        
	                        <div class="col-md-9 col-sm-9 col-xs-12">
	                          {!!get_field($field['view'],$field)!!}

	                           @if(isset($field['note']) && $field['view'] != 'image')
	                            <p class="note">{!!$field['note']!!}</p>
	                          @endif
	                          </div>
	                      </div>

	                    @endforeach
	                <?php
	              }
	            ];
	        }
	       ?>
	        
	      <div class="row">
	        <div class="col-sm-9">
	          <?php vn4_tabs_left($list_tab_setting,false,'env'); ?>
	        </div>
	      </div>
	    </form>

	</div>
@stop