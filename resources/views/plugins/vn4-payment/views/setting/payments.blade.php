@extends(backend_theme('master'))
<?php 
	 title_head( __('Payment providers') );

 ?>


@section('content')
<style type="text/css">
	.setting-field label{
		margin-top:10px;
	}

	.setting-field .col-right label{
		margin: 0 0 5px 0;
		height: 30px;
	}

</style>
<form method="POST">
	<input type="hidden" value="{!!csrf_token()!!}" name="_token">
	<div class=" max-width-1000 margin-center">
	<?php 

		vn4_setting_template([
	 		'payment-providers'=>[
	 			'title'=>'Payment providers',
	 			'description'=>'Accept payments through your store using providers like third-party services, or other payment methods.',
	 			'contents'=>[
	 				function() use ($plugin) {
	 					$payment = $plugin->getMeta('payment');
	 					$paypal = $payment['paypal']??[];
	 					$paypal_status = $paypal['status']??0;
		 				?>

		 				<img class="title-img" src="https://cdn.shopify.com/shopifycloud/web/assets/v1/d51d907b39ad5a2baa9adfe0a26fc1f8.svg">
		 				<label>{!!get_field('true_false',['title'=>'Enable','label'=>'','key'=>'paypal_status','name'=>'paypal[status]','value'=> $paypal_status])!!} Enable PayPal</label>

		 				<h2>Paypal</h2>
		 				<p>PayPal Standard redirects customers to PayPal to enter their payment information</p>

		 				<div class="setting-field paypal-config @if( !$paypal_status ) disable_event @endif">
		 					
		 					<div class="display-flex margin-bottom-10">
		 						<div class="col-md-3 col-left"><label for="paypal_method">Title</label></div>
		 						<div class="col-md-9 col-right">{!!get_field('text',['title'=>'Method','key'=>'paypal_title', 'name'=>'paypal[title]','value'=>$paypal['title']??''])!!}</div>
		 					</div>

		 					<div class="display-flex margin-bottom-10">
		 						<div class="col-md-3 col-left"><label for="paypal_client_id">Client ID</label></div>
		 						<div class="col-md-9 col-right">{!!get_field('text',['title'=>'Method','key'=>'paypal_client_id','name'=>'paypal[client-id]','value'=>$paypal['client-id']??''])!!}</div>
		 					</div>
		 					<div class="display-flex margin-bottom-10">
		 						<div class="col-md-3 col-left"><label for="paypal_client_secret">Client Secret</label></div>
		 						<div class="col-md-9 col-right">{!!get_field('text',['title'=>'Method','key'=>'paypal_client_secret','name'=>'paypal[client-secret]','value'=>$paypal['client-secret']??''])!!}</div>
		 					</div>
		 					<div class="display-flex">
		 						<div class="col-md-3 col-left"><label for="paypal_mode">PayPal sandbox</label></div>
		 						<div class="col-md-9 col-right">
		 							<label> {!!get_field('true_false',['title'=>'Method','label'=>'','key'=>'paypal_mode','name'=>'paypal[mode]','value'=> (isset($paypal['mode']) && $paypal['mode'] === 'sandbox' ?1:0 )])!!} Enable PayPal sandbox </label>
		 							<p class="note">PayPal sandbox can be used to test payments. Sign up for a  <a href="https://developer.paypal.com/developer/applications/" target="_blank">developer account</a>.</p>
		 						</div>
		 					</div>
		 				</div>
		 				
		 				<?php
		 			}
	 			]
	 		],
	 	]);

	 ?>
	 	<input style="margin-left:10px;" data-message="The process is running, please wait a moment" type="submit" class="vn4-btn vn4-btn-blue pull-right" name="save-change" value="@__('Save changes')">
		<div class="clearfix"></div>
	 </div>
</form>

@stop

@section('js')
	<script type="text/javascript">
		$(window).load(function(){
			$(document).on('change','#paypal_status input[type="checkbox"]',function(){
				if( $(this).prop('checked') ){
					$('.paypal-config').removeClass('disable_event');
				}else{
					$('.paypal-config').addClass('disable_event');
				}
			});
		});
	</script>
@stop