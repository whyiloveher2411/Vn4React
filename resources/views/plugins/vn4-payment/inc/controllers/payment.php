<?php

return [
	'get-info'=>function($r, $plugin){

		$transaction = get_post('payment_transaction',$r->get('transactionId'));

		$payment = $plugin->getMeta('payment');

		$payment_method = $transaction->method;

		if( $transaction ){

			if( isset($payment[$payment_method]) && $payment[$payment_method]['status'] ){
				include __DIR__.'/../payment/'.$payment_method.'.php';
				$payment_object = get_info_payment($payment[$payment_method], $transaction);

				$log = json_decode($transaction->log);
				$log[] = ['time'=>date(DATE_RFC2822),'status'=>$transaction->payment_status, 'action'=>'get info payment'];
				$transaction->log = json_encode($log);
				$transaction->payment_object = $payment_object;

				$transaction->save();

				vn4_create_session_message( __('Success'), 'Get Info Success.', 'success');
				return redirect()->back();

			}else{
				vn4_create_session_message( __('Error'), 'No method '.$payment_method.' found.', 'error');
				return redirect()->back();
			}
			
		}else{
		 	vn4_create_session_message( __('Error'), __('No transaction found.'), 'error');
			return redirect()->back();
		}

	}
];