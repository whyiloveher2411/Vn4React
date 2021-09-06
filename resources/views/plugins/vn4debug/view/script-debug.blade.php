<script type="text/javascript">
 	var before_loadtime = new Date().getTime();

 	if (window.addEventListener)
	{
	  window.addEventListener('load', function(){
	     if( document.getElementById("loadtime") ){
		  	var aftr_loadtime = new Date().getTime();
	         pgloadtime = (aftr_loadtime - before_loadtime) / 1000;
	         	document.getElementById("loadtime").innerHTML = 'Page load time is <font color="red"><b style="color:red;"><span id="time3" style="color:red;">' + pgloadtime + '</span></b></font> Seconds (Time users download the required resources VD: javascript, style, image, fonts, ....) (3)<a href="#"> (Instructions for improvement) </a>';
	         var total_time = document.getElementsByClassName("total_time"),
	         	kqdb = (parseFloat( document.getElementById("time1").innerHTML) / 1000 + parseFloat(document.getElementById("time2").innerHTML) + pgloadtime ).toFixed(5);

			for (var i = 0; i < total_time.length; i++) {
				total_time[i].innerHTML = kqdb;
			};
	     }
	  }, false);
	}
</script>