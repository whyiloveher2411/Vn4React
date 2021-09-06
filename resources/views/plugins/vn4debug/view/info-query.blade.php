<div class="plugin_debug_error">
<?php do_action('debug_error_query'); ?>
<span style="background:#003c00;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;">Total Query: {!!$GLOBALS['total_query_debug']!!} (Number of database accesses) <a href="#"> (Instructions for improvement) </a></span>
<span style="background:#003c00;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;">Total Time Query: <span id="time1">{!!$GLOBALS['total_query_time_debug']!!}</span> Millisecond (Total time to access the database) (1) <a href="#"> (Instructions for improvement) </a></span>
<span style="background:#003c00;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;">This page took <span id="time2">{!!round(microtime(true) - LARAVEL_START,3)!!}</span> + ~0.025 Seconds to render (Server response time html) (2)<a href="#"> (Instructions for improvement) </a></span>
<span id="loadtime" style="background:#003c00;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;"> </span>
<span style="background:#003c00;color:white;display:inline-block;width:100%;font-size:13px;padding: 5px 10px;">Toal time is (1) + (2) + (3) = <font color="red"><b><span class="total_time" style="color: red;"></span> <span style="color: red;">+ ~ 0.025</span></b></font> Seconds</span>
</div>

