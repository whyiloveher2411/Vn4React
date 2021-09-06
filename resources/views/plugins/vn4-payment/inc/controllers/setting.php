<?php

return [
	'payments'=>function($r,$plugin) {

		if( $r->isMethod('GET') ){
			return view_plugin($plugin,'views.setting.payments');
		}


		if( $r->isMethod('POST') ){

			if( env('EXPERIENCE_MODE') ){
			    return experience_mode();
			}
			
			$input = $r->get('paypal');

			if( $input['mode'] === '1' ){
				$input['mode'] = 'sandbox';
			}else{
				$input['mode'] = 'live';
			}

			$payment = $plugin->getMeta('payment');

			if( !is_array($payment) ) $payment = [];

			$payment = ['paypal'=>$input];

			$plugin->updateMeta('payment',$payment);

			vn4_create_session_message( __('Success'), __p('Update payment providers Success.',$plugin->key_word), 'success' , true);
			return redirect()->back();

		}
	}

];