<?php

function paypal_start($config){

	include __DIR__.'/../PayPal/vendor/autoload.php';

	$api = new PayPal\Rest\ApiContext(
		new PayPal\Auth\OAuthTokenCredential(
			$config['client-id'],
			$config['client-secret']
		)
	);

	$api->setConfig([
	 'mode'=>$config['mode'],
	 'http.ConnectionTimeOut'=>30,
	 'log.LogEnabled'=>true,
	 'log.FileName'=>cms_path('storage').'logs/'.$_SERVER['HTTP_HOST'].'/paypal-log-'.date('Y-m-d').'.log',
	 'log.LogLevel'=>'FINE',
	 'validation.level'=>'log'
	]);

	return $api;
}

function get_link_payment( $parameters, $config ){

	$parametersUrl = $parameters;

	extract( shortcode_atts([
		'shipping'=>'0.00',
		'tax'=>'0.00',
		'subTotal'=>false,
		'description'=>'Vn4 Payment',
		], $parameters) );

	if( $subTotal ){

		$api = paypal_start($config);

		$total = $shipping + $tax + $subTotal;

		$payer = new PayPal\Api\Payer();
		$details = new PayPal\Api\Details();
		$amount = new PayPal\Api\Amount();
		$transaction = new PayPal\Api\Transaction();
		$payment = new PayPal\Api\Payment();
		$redirectUrls = new PayPal\Api\RedirectUrls();

		//Payer
		$payer->setPaymentMethod('paypal');

		//Details
		$details->setShipping($shipping)->setTax($tax)->setSubtotal($subTotal);

		//amount
		$amount->setCurrency('USD')->setTotal($total)->setDetails($details);

		//Transaction
		$transaction->setAmount($amount)->setDescription($description);

		//payment
		$payment->setIntent('sale')->setPayer($payer)->setTransactions([$transaction]);

		$log = [
			['time'=>date(DATE_RFC2822),'status'=>'initialization']
		];

		$transaction = Vn4Model::createPost('payment_transaction',[
			'title'=>time().'_'.str_random(20),'method'=>'paypal','description'=>$description, 'payment_status'=>'initialization','currency'=>'USD','shipping'=>$shipping,'tax'=>$tax,'sub_total'=>$subTotal, 'total'=>$total,'log'=>json_encode($log)
		]);

		//Redirect URLs
		$parametersUrl['payment_method'] = 'paypal';
		$parametersUrl['transactionId'] = $transaction->id;

		$redirectUrls->setReturnUrl(route('checkout', array_merge($parametersUrl, ['approved'=>true])))->setCancelUrl(route('checkout',array_merge($parametersUrl, ['approved'=>false])));

		$payment->setRedirectUrls($redirectUrls);

		try {
			$payment->create($api);
		} catch (PPConnectionException $e) {
			$transaction->payment_status = 'error';
			$log[] = ['time'=>date(DATE_RFC2822),'status'=>'error'];
			$transaction->log = json_encode($log);
			$transaction->save();
			dd($e);
		}

		$transaction->title = $payment->getId();
		$transaction->payment_object = serialize($payment);
		$transaction->payment_status = 'created';

		$log[] = ['time'=>date(DATE_RFC2822),'status'=>'created'];
		$transaction->log = json_encode($log);
		$transaction->save();

		$links = $payment->getLinks();

		foreach ($links as $link) {
			if( $link->getRel() === 'approval_url'){
				$redirectUrl = $link->getHref();
			}
		}

		return $redirectUrl;

	}else{
		return false;
	}
}

function get_info_payment($config, $payment){
	$api = paypal_start($config);

	$payment = PayPal\Api\Payment::get($payment->title, $api);

	return $payment;
}