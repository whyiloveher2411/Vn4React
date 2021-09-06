@extends(backend_theme('master'))

<?php 

title_head( 'Report' );

$access_code = $plugin->getMeta('access_token_first');

?>


@section('content')

<style>

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

  vn4_tabs_left([

    'realtime'=>[

      'title'=>'Realtime',

      'content'=>function(){



          vn4_tabs_top([

              'overview'=>[

                'title'=>'Overview',

                'content'=>function(){

                    echo '<div class="content-iframe" data-name="realtime-overview" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'overview']).'"></div>';

                }

              ],

              'Locations'=>[

                'title'=>'Locations',

                'content'=>function(){

                    echo '<div class="content-iframe" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'location']).'"></div>';

                }

              ],

              'traffic-sources'=>[

                'title'=>'Traffic Sources',

                'content'=>function(){

                    echo '<div class="content-iframe" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'traffic-sources']).'"></div>';


                }

              ],

              'content'=>[

                'title'=>'Content',

                'content'=>function(){

                    echo '<div class="content-iframe" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'content']).'"></div>';

                }

              ],

              'events'=>[

                'title'=>'Events',

                'content'=>function(){

                    echo '<div class="content-iframe" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'events']).'"></div>';

                }

              ],

              'conversions'=>[

                'title'=>'Conversions',

                'content'=>function(){
                    echo '<div class="content-iframe" data-src="'.route('google-analytics.report-item',['folder'=>'realtime','view'=>'conversions']).'"></div>';

                }

              ]

          ],false,'realtime');

      }

    ],

    'audience'=>[

      'title'=>'Audience',

      'content'=>function(){


          vn4_tabs_top([
              
              'overview'=>[
                'title'=>'Overview',
                'content'=>function(){
                    echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'overview']).'"></div>';
                }
              ],
              'active-users'=>[
                'title'=>'Active Users',
                'content'=>function(){
                    echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'active-users']).'"></div>';
                }
              ],
              'demographics'=>[
                'title'=>'Demographics',
                'submenu'=>[
                    'overview'=>[
                      'title'=>'Overview',
                      'content'=>function(){
                        echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'demographics-overview']).'"></div>';
                      }
                    ],
                    'age'=>[
                      'title'=>'Age',
                      'content'=>function(){
                        echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'demographics-age']).'"></div>';
                      }
                    ],
                    'gender'=>[
                      'title'=>'Gender',
                      'content'=>function(){
                        echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'demographics-gender']).'"></div>';
                      }
                    ]
                ]
              ],
              'geo'=>[
                'title'=>'Geo',
                'submenu'=>[
                  'language'=>[
                    'title'=>'Language',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'geo-language']).'"></div>';
                    }
                  ],
                  'location'=>[
                    'title'=>'Location',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'geo-location']).'"></div>';
                    }
                  ]
                ]
              ],
              'behavior'=>[
                'title'=>'Behavior',
                'submenu'=>[
                  'new-returning'=>[
                    'title'=>'New vs Returning',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'behavior-new-returning']).'"></div>';
                    }
                  ],
                ]
              ],
              'technology'=>[
                'title'=>'Technology',
                'submenu'=>[
                  'browser-os'=>[
                    'title'=>'Browser & OS',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'technology-browser-os']).'"></div>';
                    }
                  ],
                  'network'=>[
                    'title'=>'Network',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'technology-network']).'"></div>';
                    }
                  ],
                  
                ]
              ],
              'mobile'=>[
                'title'=>'Mobile',
                'submenu'=>[
                  'browser-os'=>[
                    'title'=>'Overview',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'mobile-overview']).'"></div>';
                    }
                  ],
                  'devices'=>[
                    'title'=>'Devices',
                    'content'=>function(){
                      echo '<div class="content-iframe" height="100px" data-src="'.route('google-analytics.report-item',['folder'=>'audience','view'=>'mobile-devices']).'"></div>';
                    }
                  ],
                ]
              ]
          ],false,'audience');
      }
    ],

    'acquisition'=>[

      'title'=>'Acquisition',

      'content'=>function(){



      }

    ],

    'behavior'=>[

      'title'=>'Behavior',

      'content'=>function(){



      }

    ]

  ],false,'type'); 

?>



@stop



@section('js')

<script>

  function load_iframe_in_tab(){

      if( $('.vn4_tabs_left>.content-right>.content-item.active>.vn4_tabs_top>.content-bottom>.content-item.active>.content-iframe>iframe').length < 1){
        show_loading();
        $('.vn4_tabs_left>.content-right>.content-item.active>.vn4_tabs_top>.content-bottom>.content-item.active>.content-iframe').append('<iframe width="100%" id="iframe-'+$('.vn4_tabs_left>.content-right>.content-item.active>.vn4_tabs_top>.content-bottom>.content-item.active>.content-iframe').data('name')+'" onload="resizeIframe(this)" seamless frameborder="0" scrolling="no" src="'+$('.vn4_tabs_left>.content-right>.content-item.active>.vn4_tabs_top>.content-bottom>.content-item.active>.content-iframe').data('src')+'"></iframe>');
      }
      
  }

  $(window).load(function(){
    setTimeout(function() {
        load_iframe_in_tab();
    }, 10);
  });
  
$(document).on('click', '.vn4_tabs_left  .menu-left li a', function(event) {
  setTimeout(function() {
      load_iframe_in_tab();
    }, 10);
});

$(document).on('click', '.vn4_tabs_top .menu-top a', function(event) {
  setTimeout(function() {
      load_iframe_in_tab();
  }, 10);
});
</script>

@stop