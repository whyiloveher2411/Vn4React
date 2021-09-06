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
      .google-visualization-table-td, .google-visualization-table-th{
        height: 29px;
      }
      body{
        background: white;
      }
      a{
        color: #005c9c;
        font-size:12.4px;
      }
      .google-visualization-table-table a:hover{
        text-decoration: underline;
      }
      tr:nth-child(odd){
        background: rgb(248, 248, 248);
      }
      tr:hover, tr:hover td{
        background-color: #d6e9f8 !important;
      }
      th:last-child{
        width: 110px;
      }
      .google-visualization-table-table th{
        text-align: left;
      }
      td:last-child ,td:nth-last-child(2){
        width:29px;
       background: rgb(243, 243, 243);
      }
      tr:nth-child(odd) td:last-child, tr:nth-child(odd) td:nth-last-child(2){
       background: rgb(234, 234, 234);
      }
      .google-visualization-table-table td{
        border: solid #ddd;
        border-width: 0 1px 1px 0;
      }
      .title-rl{
        font-size: 17px;
        color: #005c9c;
        border-bottom: 2px solid #666;
      }
      .device_item:first-child{
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
      }
      .device_item{
        border-right: 1px solid white;
        box-sizing: border-box;
      }
      .device_item:last-child{
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
      }
      .google-visualization-tooltip-item-list .google-visualization-tooltip-item:first-child{

      }
      .google-visualization-tooltip-item-list{
        margin: 10px 0;
      }
      .google-visualization-tooltip-item{
        margin: 5px 0 !important;
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
    <a href="javascript:void(0)" onClick="isInIframe?parent.show_loading('Refresh Data'):'';window.location.reload()"><img src="{!!plugin_asset($plugin->key_word,'img/refresh_icon.svg')!!}" class="icon-refesh" alt=""></a>
  	{!!view_plugin($plugin, 'views.report.'.$folder.'.'.$view,['r'=>$r,'access_code'=>$access_code,'webpropertie_id'=>$webpropertie_id,'access_token'=>$access_token])!!}

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