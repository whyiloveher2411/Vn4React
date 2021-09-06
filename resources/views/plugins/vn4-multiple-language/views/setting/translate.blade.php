@extends(backend_theme('master'))
<?php 
	title_head('String Translate');

	$langs = languages();

 ?>
@section('css')
	<style type="text/css">
		
		@-webkit-keyframes scaleAnimation {
		  0% {
		    opacity: 0;
		    -webkit-transform: scale(1.5);
		            transform: scale(1.5);
		  }
		  100% {
		    opacity: 1;
		    -webkit-transform: scale(1);
		            transform: scale(1);
		  }
		}

		@keyframes scaleAnimation {
		  0% {
		    opacity: 0;
		    -webkit-transform: scale(1.5);
		            transform: scale(1.5);
		  }
		  100% {
		    opacity: 1;
		    -webkit-transform: scale(1);
		            transform: scale(1);
		  }
		}
		@-webkit-keyframes drawCircle {
		  0% {
		    stroke-dashoffset: 151px;
		  }
		  100% {
		    stroke-dashoffset: 0;
		  }
		}
		@keyframes drawCircle {
		  0% {
		    stroke-dashoffset: 151px;
		  }
		  100% {
		    stroke-dashoffset: 0;
		  }
		}
		@-webkit-keyframes drawCheck {
		  0% {
		    stroke-dashoffset: 36px;
		  }
		  100% {
		    stroke-dashoffset: 0;
		  }
		}
		@keyframes drawCheck {
		  0% {
		    stroke-dashoffset: 36px;
		  }
		  100% {
		    stroke-dashoffset: 0;
		  }
		}
		@-webkit-keyframes fadeOut {
		  0% {
		    opacity: 1;
		  }
		  100% {
		    opacity: 0;
		  }
		}
		@keyframes fadeOut {
		  0% {
		    opacity: 1;
		  }
		  100% {
		    opacity: 0;
		  }
		}
		@-webkit-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}
		@keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}
		.successAnimationCircle {
		  stroke-dasharray: 151px 151px;
		  stroke: rgba(76, 175, 80, .5);
		}

		.successAnimationCheck {
		  stroke-dasharray: 36px 36px;
		  stroke: #4CAF50;
		}

		.successAnimationResult {
		  fill: #4CAF50;
		  opacity: 0;
		}
		.successAnimation.animated {
		  -webkit-animation: 1s ease-out 0s 1 both scaleAnimation;
		          animation: 1s ease-out 0s 1 both scaleAnimation;
		}
		.successAnimation.animated .successAnimationCircle {
		  -webkit-animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCircle, 0.3s linear 0.9s 1 both fadeOut;
		          animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCircle, 0.3s linear 0.9s 1 both fadeOut;
		}
		.successAnimation.animated .successAnimationCheck {
		  -webkit-animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCheck, 0.3s linear 0.9s 1 both fadeOut;
		          animation: 1s cubic-bezier(0.77, 0, 0.175, 1) 0s 1 both drawCheck, 0.3s linear 0.9s 1 both fadeOut;
		}
		.successAnimation.animated .successAnimationResult {
		  -webkit-animation: 0.3s linear 0.9s both fadeIn;
		          animation: 0.3s linear 0.9s both fadeIn;
		}

		tbody tr td:not(:nth-child(1)){
			position: relative;
		}
/*		.img-flag{
		    position: absolute;
		    left: 0;
		    margin-top: 18px;
		}*/
		.update-success{
			position: absolute;
		    right: 9px;
		    top: 9px;
		}
		.update-success svg{
			
		}
		.update-success svg:hover{
			cursor: pointer;
		}
		.update-success svg:hover .successAnimationCircle{
			stroke: #4CAF50;
		}
		.update-success svg:hover .successAnimationCheck{
			stroke: #347737;
		}
		.btn-back-top, .btn-back-top:active, .btn-back-top:focus{
			position: fixed;
		    bottom: 5px;
		    right: 5px;
		    text-align: center;
		    display: inline-block;
		    width: 50px;
		    height: 50px;
		    font-size: 24px;
		    color: white;
		    background: #dedede;
		    border-radius: 50%;
		    line-height: 50px;
		}
		table td{height: 1px;}
		table td textarea.form-control{height: 100%;}
		.paginate_button{
			cursor: pointer;
		}
		.paginate_button.current{
		    font-weight: bold;
			background: #969696 !important;
		}
		
	</style>
@stop
@section('content')
<form id="form-master">
	

</form>
<?php 
	$lang = language_default();

	vn4_tabs_top([
		'p-core'=>[
					'title'=>'Core',
					'content'=>function() use ($langs, $lang, $plugin) {
						
						echo '<input type="hidden" id="type_trans" value="core" >';
						echo view_plugin($plugin, 'views.setting.translate-core',['langs'=>$langs,'lang'=>$lang]);

					}
				],
		'p-plugin'=>[
					'id'=>'p-plugin',
					'title'=>'Plugin',
					'content'=>function()use ($langs, $lang, $plugin) {
						
						echo '<input type="hidden" id="type_trans" value="plugin" >';
						echo view_plugin($plugin, 'views.setting.translate-plugin',['langs'=>$langs,'lang'=>$lang]);

					}
				],
		'p-theme'=>[
					'id'=>'p-theme',
					'title'=>'Theme',
					'content'=>function() use ($langs, $lang, $plugin) {
						
						echo '<input type="hidden" id="type_trans" value="theme" >';
						echo view_plugin($plugin, 'views.setting.translate-theme',['langs'=>$langs,'lang'=>$lang]);

					}
				],
		
	],true,'type');
 ?>

 <a href="#" class="not-href btn-back-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
@stop

@section('js')
	<!-- Datatables -->
	
	<script type="text/javascript">
		$(document).on('click','.btn-back-top',function(){
			$('html,body').animate({ scrollTop: 0 }, 500);
		});

		var chunks = function(array, size) {
		  var results = [];
		  while (array.length) {
		    results.push(array.splice(0, size));
		  }
		  return results;
		};

		$(document).on('change','.input-value',function(){
			$(this).parent().find('.update-success').remove();
			$(this).parent().prepend('<div class="update-success" ><svg class=" successAnimation animated" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 70 70"><path class="successAnimationResult" fill="#D8D8D8" d="M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z"/><circle class="successAnimationCircle" cx="35" cy="35" r="24" stroke="#979797" stroke-width="5" stroke-linecap="round" fill="transparent"/><polyline class="successAnimationCheck" stroke="#979797" stroke-width="5" points="23 34 34 43 47 27" fill="transparent"/></svg></div>');

		});


		$('form').submit(function(event){
			event.preventDefault();

			var type = $('#type_trans').val();
			var values = $(this).find('.input-value');

			var chunksValues = chunks(values,100);

			var refeshValues = [];

			for (var i = 0; i < chunksValues.length; i++) {

				var formData = $('#form-master').serializeArray();

				for (var j = 0; j < chunksValues[i].length; j++) {
					formData.push({name:$(chunksValues[i][j]).attr('name'),value: $(chunksValues[i][j]).val()});
				}

				formData.push({name:'_token','value':'{!!csrf_token()!!}'});
				formData.push({name:'type','value':type});

				refeshValues[i] = formData;
			}

			$('html').addClass('show-popup');

			$.ajax({
	 			type: 'POST',
	 			dataType: 'Json',
	 			data:{
	 				_token:'{!!csrf_token()!!}',
	 				type: type,
	 				update_key:true,
	 			},
	 			success:function(data){
	 				if( !data.error ){
	 					call_dequi_ajax(refeshValues);
	 				}else{
	 					alert('Error Update key!!');
 						$('html').removeClass('show-popup');
	 				}
	 			},
	 		});

		});

		function call_dequi_ajax(values){

			if( !values[0] ){
				console.log('done');
 				$('html').removeClass('show-popup');
				return 1;
			}

			if( !values[1] ){
				values[0].push({name:'is_lasted',value:true});
			}

			$.ajax({
	 			type: 'POST',
	 			dataType: 'Json',
	 			data:values[0],
	 			success:function(data){
	 				if( !data.error){
	 					values.shift();
	 					call_dequi_ajax(values);
	 				}else{
	 					alert('Error!!');
 						$('html').removeClass('show-popup');
	 				}
	 			},
	 		});
		}
	</script>


@stop
