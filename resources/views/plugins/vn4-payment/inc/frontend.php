<?php

$GLOBALS['listPlugin']['vn4-payment'] = $plugin;

add_route('buy_now/{payment}','buy_now','frontend',function($r, $payment_method) use ($plugin) {
	

	if( $r->has('approved') ){
		dd($r->all());
	}

	$payment = $plugin->getMeta('payment');

	if( isset($payment[$payment_method]) && $payment[$payment_method]['status'] ){

		include __DIR__.'/payment/'.$payment_method.'.php';

		$parameters = [];

		$parameters = do_action('payment_checkout',$parameters, $r, $payment_method);

		if( $parameters ){

			$link = get_link_payment($parameters, $payment[$payment_method]);

			if( $link ){
				vn4_redirect($link);
			}
		}
	}

	return redirect()->back();

});


add_route('checkout/{payment_method}','checkout','frontend',function($r, $payment_method) use ($plugin){

	$payment = $plugin->getMeta('payment');

	if( isset($payment[$payment_method]) && $payment[$payment_method]['status'] ){

		$transaction = get_post('payment_transaction',$r->get('transactionId'));

		$transaction->payment_status = $r->get('approved')?'approved':'disapproved';
		$log = json_decode($transaction->log);
		$log[] = ['time'=>date(DATE_RFC2822),'status'=>$transaction->payment_status];
		$transaction->log = json_encode($log);

		$transaction->result = json_encode($r->all());

		$transaction->save();

		return do_action('payment_completed',$transaction, $r);

	}

	return redirect()->back();
});

function get_links_checkout($parameters){

	$plugin = $GLOBALS['listPlugin']['vn4-payment'];

	$payment = $plugin->getMeta('payment');

	$result = [];

	foreach ($payment as $key => $value) {
		if( $value['status'] ){
			$result[$key] = ['title'=>$value['title'],'link'=>route('buy_now',array_merge(['payment'=>$key], $parameters))];
		}
	}

	return $result;
}
