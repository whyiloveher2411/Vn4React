
if( !$('body').hasClass('is-iframe') ){

$('head').append(`
	<style type="text/css">

		.messenger{
    		justify-content: space-between;
		    position: fixed;
		    right: 5px;
		    z-index: 9;
		    bottom: 45px;
		    overflow: auto;
		    width: 45px;
		    height: 45px;
		    background: url({!!plugin_asset($plugin, 'img/plugin.png')!!}) no-repeat center center;
	        background-size: contain;
		}
		.messenger header{
			background: white;
			padding: 8px;
			display: none;
			font-weight: bold;
		    font-size: 12px;
		}
		.messenger header span{
			color: #9c9c9c;
		    font-weight: normal;
		}

		.list-user{
			display: none;
			width: 205px;
			box-shadow: 1px 0 0 #f0f0f2 inset;
		}
		.vn4-messenger{
			position: relative;
			z-index: 10000;
		}
		.vn4-messenger.active .messenger{
			width: auto;
			height: auto;
		    background: #e9ebee;
			top: 44px;
		    bottom: 0;
			border-left: 1px solid #ccc;
		}
		.vn4-messenger.active .list-user,.vn4-messenger.active .messenger header{
			display: block;
		}

		.user-item{
			position: relative;
			cursor: pointer;
		}
		.list-user .user-item{
		    display: flex;
		    align-items: center;
		    justify-content: space-between;
		    height: 40px;
		    cursor: pointer;
			padding:0 8px;
		}
		.list-user .user-item:hover{
		    background-color: #dddfe2;
		    box-shadow: 1px 0 0 #eaebed inset;
		    text-decoration: none;
		}
		.user-item img{
			width: 32px;
			height: 32px;
			border-radius: 50%;
			box-shadow: none;
		}
		.user-item .name{
			padding:0 8px;
			font-weight: bold;
			font-size: 12px;
			color: #1c1e21;
		}
		.user-item .status{
		    width: 5px;
		    height: 5px;
	        font-size: 11px;
		    border-radius: 50%;
		    /*background: rgb(66, 183, 42);*/
		    background: #90949c;
		}
		.user-item .status.info{
			width: auto;
		    height: auto;
		    background: none;
		}
		.user-item .status.active{
		    background: rgb(66, 183, 42);
		}

		.list-chatting{
			display: inline-flex;
		    position: fixed;
		    bottom: 0;
			right: 50px;
		    align-items: flex-end;
		}

		.vn4-messenger.active .list-chatting{
		    right: 210px;
		}
		.list-chatting .user-item{
			padding: 0 8px;
		    margin: 0 7.5px;
		    background: white;
		    height: 40px;
		    display: flex;
		    align-items: center;
		    border-radius: 10px 10px 0 0;
		    color: transparent;
	        overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .3);
		}
		.list-chatting .user-item:hover{
			background-color: #f2f3f5;
    		transition: background-color .1s;
		}

		.list-chatting .user-item .status{
		    width: 10px;
    		height: 10px;
		    position: absolute;
		    left: 23px;
		    bottom: 10px;
		    border: 2px solid white;
		    overflow: hidden;
		    background: #90949c;
		}

		.list-chatting .user-item .status.active{
			background: rgb(66, 183, 42);
		}
		.list-chatting .user-item img{
			width: 20px;
			height: 20px;
			margin-right: 5px;
		}
		.user-item.open header img, .list-chatting .user-item .list-message  img.avata{
			width: 28px;
			height: 28px;
		}
		.list-chatting .user-item.open .status{
		    left: 28px;
			bottom: 8px;
		}
		.list-chatting .user-item.open{
			width: 280px;
		    height: auto;
	        display: inline-block;
	        padding: 0;
		}
		.list-chatting .user-item header{
		    display: flex;
		    height: 43px;
	        width: 180px;
		    align-items: center;
		    justify-content: space-between;
	        box-shadow: 0 2px 1px rgba(0, 0, 0, .1);
			z-index: 3;
		    cursor: pointer;
		    padding: 8px 4px 7px 8px;
		    position: relative;
		}
		.list-chatting .user-item.open header{
			width: 100%;
		}
		.list-chatting .user-item main{
		    height: 300px;
		    background: white;
		    width: 100%;
	        color: black;
	        display: flex;
			flex-direction: column;
		}
		.list-chatting .user-item form{

		}

		.list-chatting .user-item main{
			display: none;
		}
		.list-chatting .user-item.open main{
			display: flex;
		}

		.list-chatting .user-item .list-message{
		    padding: 0 0 10px 0;
		}

		.list-chatting .user-item .list-message .message-item{
		    border-style: solid;
		    border-color: transparent;
		    display: flex;
	        align-items: flex-end;
		}
		.message-item.message-of-me .group-messages{
			text-align: right;
		}
		.message-item .group-messages div:first-child span{
			border-top-left-radius: 15px;
		}
		.message-item .group-messages div:last-child span{
			border-bottom-left-radius: 15px;
		}

		.message-item.message-of-me .group-messages div:first-child span{
			border-top-right-radius: 15px;
		}
		.message-item.message-of-me .group-messages div:last-child span{
			border-bottom-right-radius: 15px;
		}


		.list-chatting .user-item.open .list-message .message-item span{
			line-height: 19px;
			padding: 0 10px;
			line-height: 16px;
			padding:5px 10px;
			display: inline-block;
			margin-top: 2px;
		    word-break: break-all;
		}

		.list-chatting .user-item.open .list-message .message-item.message-not-me span{
			border-top-right-radius: 15px;
			border-bottom-right-radius: 15px;
		    background: #f1f0f0;
		}
		.list-chatting .user-item.open .list-message .message-typing .message-item.message-not-me span{
			border-radius: 15px;
		}
		.list-chatting .user-item.open .list-message .message-item.message-of-me span{
			border-top-left-radius: 15px;
			border-bottom-left-radius: 15px;
		}




		.list-chatting .user-item.open .list-message .message-item.message-not-me{
		    border-width: 2px 50px 0px 8px;
		}

		.list-chatting .user-item.open .list-message .message-item.message-of-me{
		    justify-content: flex-end;
		    border-width: 2px 18px 0px 50px;
		}
		.list-chatting .user-item.open .list-message .message-item.message-of-me span{
 			background: #3578E5;
 			color: white;
		}
		.list-chatting .user-item.open .list-message .message-item.message-of-me img{
			display: none;
		}


		.list-chatting .user-item.open .input-message{
		    color: black;
	        border-top: 1px solid #c9d0da;
		    cursor: text;
		    font-size: 13px;
		    max-height: 90px;
		    min-height: 16px;
		    overflow-x: hidden;
		    overflow-y: auto;
		    padding: 10px 8px 6px;
		    position: relative;
		}
		.message-warpper{
			background: #fff;display: flex;flex-direction: column;height: 100%;overflow-x: hidden;position: relative;width: 100%;z-index: 2;
		}
		.tiblock {
		    align-items: center;
		    display: flex;
		    height: 17px;
		}
		.ticontainer{
		    display: inline-block;
		}
		.ticontainer .tidot {
		    background-color: #90949c;
		}

		.tidot {
		    -webkit-animation: mercuryTypingAnimation 1.5s infinite ease-in-out;
		    border-radius: 2px;
		    display: inline-block;
		    height: 4px;
		    margin-right: 2px;
		    width: 4px;
		}

		@-webkit-keyframes mercuryTypingAnimation{
		0%{
		  -webkit-transform:translateY(0px)
		}
		28%{
		  -webkit-transform:translateY(-5px)
		}
		44%{
		  -webkit-transform:translateY(0px)
		}
		}

		.tidot:nth-child(1){
		-webkit-animation-delay:200ms;
		}
		.tidot:nth-child(2){
		-webkit-animation-delay:300ms;
		}
		.tidot:nth-child(3){
		-webkit-animation-delay:400ms;
		margin: 0;
		}
	</style>
`);


$('.right_col').append(`
	<div class="vn4-messenger">
		<div class="messenger custom_scroll">

			<header>
				Chat <span>62 đang online</span>
			</header>
			<div class="list-user ">
				<?php 
					$users = get_posts('user',20)->keyBy('id');
					$myUser = Auth::user();
				 ?>

				 @foreach($users as $user)

					<?php 
						$src = get_media($user->getMeta('profile_picture'), asset('admin/images/face_user_default.jpg'), 'nav-top');;
					 ?>
					<div class="user-item" data-user="{!!$user->id!!}">
						<div><img src="{!!$src!!}"> <span class="name">{!!$user->last_name,' ',$user->first_name!!}</span></div>
						<div class="status" data-id="{!!$user->id!!}"></div>
					</div>
				@endforeach
			</div>
		</div>
		<div class="list-chatting">
			@foreach($users as $key => $user)
			 	<?php 
					$src = get_media($user->getMeta('profile_picture'), asset('admin/images/face_user_default.jpg'), 'nav-top');
					$users[$key]['image_url'] = $src;
					$users[$key]['meta'] = '';
				 ?>
			@endforeach
		</div>
	</div>
`);


$('body').append(`
<script>

// $(window).on('load',function(){

	let script = document.createElement('script');
	window.listenEvent = [];

	function scrollToButton(elemnt){
		elemnt.each( (index, e) => {
			e.scrollTop =e.scrollHeight;
		});
	}

	// function strip(html) {
 //      var tempDiv = document.createElement("DIV");
 //      tempDiv.innerHTML = html;
 //      return tempDiv.innerText;
 //    }

    window.users = {!!json_encode($users)!!};

	function diffForHumans(date){
		// Make a fuzzy time
		let delta = Math.round((+new Date -date) / 1000);

		let minute = 60,
		    hour = minute * 60,
		    day = hour * 24,
		    week = day * 7;

		let fuzzy;

		if (delta < 30) {
		    // fuzzy = 'just then.';
		    fuzzy = true;
		} else if (delta < minute) {
		    fuzzy = true;
		} else if (delta < 2 * minute) {
		    fuzzy = '1 phút';
		} else if (delta < hour) {
		    fuzzy = Math.floor(delta / minute) + ' phút';
		} else if (Math.floor(delta / hour) == 1) {
		    fuzzy = '1 giờ';
		} else if (delta < day) {
		    fuzzy = Math.floor(delta / hour) + ' giờ';
		} else if (delta < day * 2) {
		    fuzzy = false;
		}else{
			fuzzy = false;
		}
		return fuzzy;
	}



	script.onload = function () {

		let script2 = document.createElement('script');

		script2.onload = function () {

			window.typingTimeout = [];
			//

				// Your web app's Firebase configuration
				var firebaseConfig = {
					apiKey: "AIzaSyAiQZKfrGBdquN7ioumm1z7oupRf_UIs5o",
					authDomain: "dna-dat-phong-2020.firebaseapp.com",
					databaseURL: "https://dna-dat-phong-2020.firebaseio.com/",
					projectId: "dna-dat-phong-2020",
					storageBucket: "dna-dat-phong-2020.appspot.com",
					messagingSenderId: "716146972818",
					appId: "1:716146972818:web:917474e9791ec0daa7ae4b",
					measurementId: "G-78994Z62V0"
				};
				// Initialize Firebase
				firebase.initializeApp(firebaseConfig);

				let database = firebase.database();

				function writeData(url, data){
					// console.log('writeData: ',url);
					database.ref(url).set(data);
				}

				function updateData(url, data){
					return database.ref(url).update(data);
				}

				function getData(url, callback){

					// console.log('getData: ',url);
					database.ref(url).once('value').then(function(snapshot) {
					  let data = (snapshot.val() && snapshot.val()) || [];
					  callback(data);
					});
				}


				function listenChange( key, url, callback){

					database.ref(url).on('child_changed', (snapshot) => {
				    	callback(snapshot, 'changed'); 
					});

					database.ref(url).on('child_added', (snapshot) => {
				    	callback(snapshot, 'added'); 
					});

					database.ref(url).on('child_removed', (snapshot) => {
				    	callback(snapshot, 'removed'); 
					});

				}

				function updateStatusOnline( id,  user ){
					let status = diffForHumans(new Date(user.time));
					if( status === true ){
						$('.status[data-id="'+id+'"]').attr('class','status active').text('');
					}else if( status === false ){
						$('.status[data-id="'+id+'"]').attr('class','status').text('');
					}else{
						$('.status[data-id="'+id+'"]').attr('class','status info').text(status);
					}

					return status;

				}

				function checkUserOnline( id ){

					if( id ){
						getData('messenger/online/'+id,function( data ){
							if( data ){
								updateStatusOnline(id, data);
							}
						});
					}else{
						getData('messenger/online',function( data ){
							let status = false;
							let count = 0;
							for( let i in data){
								status = updateStatusOnline(i, data[i]);
								if( status ){
									count++;
								}
							}

							$('.vn4-messenger .messenger header span').text(count+' đang online');
						});
					}


				}

				function sendMessage(roomId, message){

					if( message ){
			    		writeData('messenger/room/private/'+roomId+'/messages/'+(new Date()).getTime()+'_'+{!!$myUser->id!!},{
			    			user: {!!$myUser->id!!},
			    			message: message
			    		});


			    		getData('messenger/room/private/'+roomId+'/users',function(data){
			    			for( let i in data){
			    				if( i != {!!$myUser->id!!} ){
			    					if( data[i].opened == 0 ){
			    						writeData('messenger/room/private/'+roomId+'/users/'+i+ '/opened', 2);
			    					}
			    				}
			    			}

			    		});
		    		}
				}

				function getRoomGuest( userGuest ){

					let myId = {!!$myUser->id!!}, roomId = myId+'_'+userGuest;

		    		if( myId > userGuest ){
		    			roomId = userGuest+'_'+myId;
		    		}

		    		return roomId;

				}

				function showRoomId( roomId, classOpened, user ){

					if( !$('.list-chatting .user-item[data-user="'+user.id+'"]').length ){

		    			$('.list-chatting').append('<div class="user-item '+classOpened+'" data-roomId="'+roomId+'" data-user="'+user.id+'">'
							+'<header>'
								+'<div><img src="'+user.image_url+'"> <span class="name">'+user.last_name+' '+user.first_name+'</span></div>'
								+'<span class="icon-close"><svg xmlns="http://www.w3.org/2000/svg" height="16"  width="16" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></span>'
								+'<div class="status" data-id="'+user.id+'"></div>'
							+'</header>'
							+'<main class="" >'
									+'<div class="custom_scroll message-warpper" >'
										+'<div class="list-message " >'
											+'<div class="messages">'
											+'</div>'
											+'<div class="message-typing">'
											+'</div>'
										+'</div>'
									+'</div>'
								+'<form>'
									+'<div class="input-message custom_scroll" data-id="'+user.id+'" contenteditable="true"></div>'
								+'</form>'
							+'</main>'
						+'</div>');

						document.querySelector('div[contenteditable="true"][data-id="'+user.id+'"]').addEventListener("paste", function(e) {
					        e.preventDefault();
					        var text = e.clipboardData.getData("text/plain");
					        document.execCommand("insertHTML", false, text);
					    });

		    			let classMessage, lat_child;

				    	listenChange('update-chatting-'+roomId,'messenger/room/private/'+roomId+'/messages',function(data, type){
				    		if( type == 'added' ){

				    			data = data.val();

				    			if( data.user == {!!$myUser->id!!} ){
				    				classMessage = 'message-of-me';
				    			}else{
				    				classMessage = 'message-not-me';
				    			}

				    			lat_child = $('.user-item[data-roomId="'+roomId+'"] .list-message .messages .message-item:last-child');

				    			if( lat_child.hasClass(classMessage) ){
					    			lat_child.find('.group-messages').append('<div><span>'+data.message+'</span></div>');
				    			}else{
					    			$('.user-item[data-roomId="'+roomId+'"] .list-message .messages').append(' <div class="message-item '+classMessage+'"><img class="avata" src="'+users[data.user].image_url+'"> <div class="group-messages"><div><span>'+data.message+'</span></div></div></div>');
				    			}


								$('#typing-'+roomId).remove();

				    		}
							scrollToButton($('.message-warpper'));
						});

					}else{
						$('.list-chatting .user-item[data-roomId="'+roomId+'"]').removeClass('open').addClass(classOpened);
					}

				}

				



				writeData('messenger/online/{!!$myUser->id!!}',{
					time: (new Date()).toString(),
				});

				writeData('users/{!!$myUser->id!!}',{
					email: '{!!$myUser->email!!}',
					name: '{!!$myUser->last_name,' ',$myUser->first_name!!}',
				});

				// getData('messenger/online',function( data ){
				// 	console.log(data);
				// });

				listenChange('check-online', 'messenger/online',function(data){

					updateStatusOnline(data.key, data.val());

				});

				

				
				
				scrollToButton($('.message-warpper'));


				// $(document).on('paste','div[contenteditable="true"]',function(event){
			 //        event.preventDefault();
			 //        var text = window.clipboardData.getData("text/plain");
			 //        document.execCommand("insertHTML", false, text);
			 //    });




			    $(document).on('keypress','.input-message',function( event ){

			    	let roomId = getRoomGuest( $(this).data('id') );

			    	if( event.keyCode == 13 ){
			    		if( event.ctrlKey ||  event.altKey || event.shiftKey ){

			    		}else{
				    		event.preventDefault();
				    		sendMessage( roomId , $(this).text() );
				    		$(this).text('');
			    		}
			    	}else{


			    		getData( 'messenger/room/private/'+roomId+'/users',function(data){

			    			if( !data.length ){
			    				updateData( 'messenger/room/private/'+roomId+'/users/{!!$myUser->id!!}', {acction_last:'keypress',time_keypress:(new Date()).toString()} );
			    			}

			    		});

			    	}
			    });



			    for( let i in users){

			    	let roomId = getRoomGuest( users[i].id );

					listenChange('render-room-chat-'+roomId, 'messenger/room/private/'+roomId+'/users',function(data, type){

						let opened = data.val(), key = data.key;

			    		if( key == {!!$myUser->id!!} ){
			    			if( opened && opened.opened ){
			    				let classOpened= opened.opened == 2 ? 'open' : '';
			    				showRoomId( roomId, classOpened, users[i] );
			    			}else{
			    				database.ref('messenger/room/private/'+roomId+'/messages').off('child_changed');
			    				database.ref('messenger/room/private/'+roomId+'/messages').off('child_removed');
			    				database.ref('messenger/room/private/'+roomId+'/messages').off('child_added');
			    				$('.list-chatting .user-item[data-roomId="'+roomId+'"]').remove();
			    			}
			    		}

			    		checkUserOnline(users[i].id);

						let delta = Math.round((+new Date - (new Date(data.val().time_keypress))) / 1000);
						let minute = 60,
						    hour = minute * 60,
						    day = hour * 24,
						    week = day * 7;

						if( delta < 10 && opened.acction_last == 'keypress' ){

							if( !$('#typing-'+roomId+'').length ){
	    						$('.user-item[data-user="'+users[data.key].id+'"]:not([data-user="{!!$myUser->id!!}"]) .list-message .message-typing').append('<div id="typing-'+roomId+'" class="message-item message-not-me"><img class="avata" src="'+users[data.key].image_url+'"> <span><div class="ticontainer"><div class="tiblock"><div class="tidot"></div><div class="tidot"></div><div class="tidot"></div>										  </div></div></span></div>');
    						}

	    					if( window.typingTimeout[roomId] ){
	    						clearTimeout(window.typingTimeout[roomId]);
	    					}

	    					window.typingTimeout[roomId] = setTimeout(function() {
	    						$('#typing-'+roomId).animate({
	    							opacity: 0
	    						},200,function(){
	    							$('#typing-'+roomId).remove();
	    						});
	    					}, 8000);

							scrollToButton($('.message-warpper'));

	    				}
			    		
					});


			    }


			 //    document.onkeyup = function(e) {
				//   if (e.which == 77) {
				//     alert("M key was pressed");
				//   } else if (e.ctrlKey && e.which == 66) {
				//     alert("Ctrl + B shortcut combination was pressed");
				//   } else if (e.ctrlKey && e.altKey && e.which == 89) {
				//     alert("Ctrl + Alt + Y shortcut combination was pressed");
				//   } else if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 85) {
				//     alert("Ctrl + Alt + Shift + U shortcut combination was pressed");
				//   }
				// };


			checkUserOnline();

			setInterval(function() {

				writeData('messenger/online/{!!$myUser->id!!}',{
					time: (new Date()).toString(),
				});

				checkUserOnline();

			}, 60000);

			$(document).on('click','.vn4-messenger:not(.active) .messenger',function(){
				$(this).closest('.vn4-messenger').addClass('active');
			});

			$(document).on('click','.vn4-messenger.active .messenger header',function(){
				$(this).closest('.vn4-messenger').removeClass('active');
			});

			$(document).on('click','.list-chatting .user-item header',function(event){

				let chatItem = $(this).closest('.user-item'), roomId = getRoomGuest( chatItem.data('user') );

				event.stopPropagation();
				chatItem.toggleClass('open');

				if( chatItem.hasClass('open') ){
    				updateData( 'messenger/room/private/'+roomId+'/users/{!!$myUser->id!!}', {acction_last:'extend',opened:2} );
				}else{
    				updateData( 'messenger/room/private/'+roomId+'/users/{!!$myUser->id!!}', {acction_last:'unextend',opened:1} );
				}

				scrollToButton( chatItem.find( '.message-warpper' ) );

			});

			$(document).on('click','.list-chatting .user-item header .icon-close',function(event){
				let chatItem = $(this).closest('.user-item'), roomId = getRoomGuest( chatItem.data('user') );
				event.stopPropagation();
				writeData('messenger/room/private/'+roomId+'/users/{!!$myUser->id!!}',{opened: 0, time_keypress: 0});
			});

			$(document).on('click','.list-user .user-item',function(){
				let  user = $(this).data('user'), roomId = getRoomGuest( user );

				getData('messenger/room/private/'+roomId, function(data){

					if( data.users ){
						writeData('messenger/room/private/'+roomId+'/users/{!!$myUser->id!!}/opened',2);
					}else{
						let dataUpdate = [];

						dataUpdate[ user ] = {'opened':  0};
						dataUpdate[ {!!$myUser->id!!} ] = {'opened':  2};

						writeData('messenger/room/private/'+roomId+'/users',dataUpdate);
					}
				});

			});

		};

		script2.src = 'https://www.gstatic.com/firebasejs/7.19.1/firebase-database.js';

		document.head.appendChild(script2);

	};

	script.src = 'https://www.gstatic.com/firebasejs/7.19.1/firebase-app.js';

	document.head.appendChild(script);
// });
</script>
`);

}
