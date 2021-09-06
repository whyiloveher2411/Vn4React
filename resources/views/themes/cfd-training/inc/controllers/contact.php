<?php

return [
	'post'=>function($r){

		if( $r->isMethod('POST') ){

			$result = Vn4Model::create('cfd_contact', [] , $r->all() );

			if( !$result['error'] ){
				return Redirect::back()->with('success',true)->withInput(Request::all());
			}else{
				return Redirect::back()->with('messages',$result['error'])->withInput(Request::all());
			}

		}

		return redirect()->back();
	},

	'demoapi'=>function($r){
		?>
		<script type="text/javascript">
			(async () => {
			  const rawResponse = await fetch('http://stylebypnj.com.vn/api/index', {
			    method: 'POST',
			    headers: {
			      'Accept': 'application/json',
			      'Content-Type': 'application/json'
			    },
			    body: JSON.stringify({a: 1, b: 'Textual content'})
			  });
			  const content = await rawResponse.json();
			  
			  console.log(content);
			})();
		</script>
		<?php
	}

];