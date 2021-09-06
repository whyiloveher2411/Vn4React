<html>

  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style type="text/css">
      *{
        font-family: Roboto, sans-serif;
        margin: 0;
        padding: 0;
        color: #222;
        text-decoration: none;
      }
      .icon-refesh{
        position: absolute;
        right: 0;
        top: 0;
        z-index: 999;
        height: 20px;
      }
    </style>

  </head>



<body>

    <div class="div-warper">
      <a href="javascript:void(0)" onClick="isInIframe?parent.show_loading('Refresh Data'):'';window.location.reload()"><img src="{!!plugin_asset($plugin->key_word,'img/refresh_icon.svg')!!}" class="icon-refesh" alt=""></a>
      <script type="text/javascript" src="{!!asset('')!!}vendors/jquery/jquery.min.js?v=1"></script>
    	{!!view_plugin($plugin, 'views.report.'.$folder.'.'.$view,['r'=>$r,'access_code'=>$access_code,'webpropertie_id'=>$webpropertie_id,'access_token'=>$access_token])!!}
    </div>

    <script>
      var isInIframe = (window.location != window.parent.location) ? true : false;

      document.addEventListener("DOMContentLoaded", function(event) {
        if( isInIframe ){
          parent.hide_loading();
        }
      });
    </script>

</body>

</html>