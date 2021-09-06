<!DOCTYPE html>
<html {!!get_language_attributes()!!} >
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	@head

	<style>
		:root {
			--cl-link: #000;  
			--cl-main: #000;
			--cl-black: #000;
			--cl-white: #fff;
			--cl-text1:#373737;
			--cl-text2:#373737;
			--bg-body: #e9ebee;
		}
		*{
			margin: 0;
			padding: 0;
			list-style: none;
			box-sizing: border-box;
			text-decoration: none;
		}
		.flex{
			flex:1;
		}
		img{
			max-width:100%;
		}
		.color-white{
			color: var(--cl-white);
		}
		.color-black{
			color: var(--cl-black);
		}
		html {
			font-size:16px;
		}
		body{
			min-height: 100vh;
			font-family: 'Roboto', Arial, Helvetica, sans-serif;
		}
		.height-full{
			height: 100%;
		}
		.width-full{
			width: 100%;
		}
		.display-between{
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.display-top{
			display: flex;
			justify-content: space-between;
		}
		.display-center{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.container{
			width: 1190px;
			padding:  0 10px;
			max-width: 100%;
			margin: 0 auto;
		}

		header{
			height: 65px;
			z-index: 99;
			background: var(--cl-white);
			position: fixed;
			width: 100%;
			border-bottom: 1px solid rgba(0, 0, 0, 0.05);
			box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.05);
		}
		#menuToggle span
		{
			display: block;
			width: 34px;
			height: 4px;
			margin-bottom: 5px;
			position: relative;
			
			background: #cdcdcd;
			border-radius: 3px;
			
			z-index: 1;
			
			transform-origin: 21.5px;
			
			transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
						background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
					opacity 0.55s ease;
		}
		#menuToggle{
			display:none;
		}
		#menuToggle span:first-child
		{
			transform-origin: 0% 0%;
		}

		#menuToggle span:nth-last-child(2)
		{
			transform-origin: 22.5px;
		}
		#menuToggle span:last-child{
			margin:0;
		}


		#menuToggle.active span
		{
		opacity: 1;
		transform: rotate(45deg) translate(-2px, -1px);
		background:var(--cl-black);
		}

		/*
		* But let's hide the middle one.
		*/
		#menuToggle.active span:nth-last-child(3)
		{
		opacity: 0;
		transform: rotate(0deg) scale(0.2, 0.2);
		}

		/*
		* Ohyeah and the last one should go the other direction
		*/
		#menuToggle.active span:nth-last-child(2)
		{
		transform: rotate(-45deg) translate(0, -1px);
		}


		header .nav a{
			color: var(--cl-black);
			display: inline-block;
			padding: 0 15px;
			opacity: 0.6;
			transition: 0.5s;
		}
		header .nav a.active{
			opacity: 1;
		}

		header .nav a:hover{
			opacity: 1;
			transition: 0.5s;
		}
		.title-1{
			text-align: center;
			max-width: 740px;
			padding: 20px;
			line-height: 60px;
			font-size: 3rem;
			margin: 35px 0;
			color: var(--cl-text1);
		}
		.title-2{
			font-size: 1.5rem;
		}
		.description{
			line-height:25px;
			margin-bottom:10px;
			font-size:0.875rem;
			color:var(--cl-text2);
		}
		.info{
			line-height:25px;
			font-size:0.875rem;
			margin-bottom:10px;
			color:var(--cl-text2);
		}
		main{
			z-index: 1;
			padding-top:100px;
		}
		.margin-top-45{
			margin-top:45px;
		}
		main .sidebar{
			width: 300px;
			max-width:100%;
			padding-left:45px;
		}
		.lists-blog .item{
			margin-bottom:25px;
			padding-bottom:20px;
			border-bottom:1px solid #d2d2d2;
		}
		.lists-blog .item .left{
			padding-right:20px;
			margin-bottom:20px;
		}

		.lists-blog .item .thumbnail{
			border-radius: 4px;
		}

		.lists-blog .item .right{
			padding:20px 0 0 20px;
			width: 300px;
			max-width:100%;
			margin-bottom:20px;
		}
		.info .dif{
			display: flex;
			align-items: center;
		}
		.info span{
			display:inline-block;
		}
		.info .dot{
			margin: 0 10px;
			height: 3px;
			width:3px;
			border-radius: 50%;
			background-color: var(--cl-black);
		}
		.lists-blog .item h2{
			margin-bottom:15px;
			color: var(--cl-text1);
		}
		.sidebar .lists-blog .item h2{
			font-size:1rem;
		}
		footer{
			background:black;
			color:white;
			padding:35px 0;
		}
		footer a{
			color: var(--cl-white);
		}
		footer .nav a{
			display:inline-block;
			padding: 10px;
			transition: 0.5s;
		}
		footer .nav a:hover{
			opacity: 0.5;
			transition: 0.5s;
		}

		.content {
			max-width: 740px;
			margin: 0 auto;
			font-size: 20px;
			line-height: 36px;
			padding-bottom: 40px;
		}

		.content p {
			margin-top: 2em;
		}
		.content .block{
			background: #ededed;
			padding: 25px;
			margin-top: 2em;
			border-radius: 4px;
		}
		.content .block h2{
			font-size: 1.5rem;
			position: relative;
		}
		.content .block h2:before{
			content: "";
			display: inline-block;
			width: 50px;
			height: 4px;
			background: #cdcdcd;
			position: absolute;
			bottom: -2px;
		}
		.content .block p{
			margin-top: 1em;
		}
		.btn-read{
			display: inline-flex;
			padding: 8px 45px;
			border: 1px solid #dedede;
			border-radius: 40px;
			margin-top: 15px;
			font-size: 14px;
			color: var(--cl-text2);
			align-items: center;
		}
		

		.btn-read img{
			height: 15px;
			margin-left:5px;    
			filter: opacity(0.6);
		}
		.btn-read:hover{
			color: var(--cl-black);
			border: 1px solid #8b8b8b;
		}
		.btn-read:hover img{
			filter: none;
		}
		.pagination{
			display: flex;
			margin-bottom: 25px;
		}
		.pagination li.active a{
			opacity: 1;
			cursor: not-allowed;
		}
		.pagination a{
		    width: 35px;
		    height: 35px;
		    border: 1px solid;
		    display: flex;
		    align-items: center;
		    justify-content: center;
		    margin-right: 5px;
		    border-radius: 5px;
		    color: var(--cl-text2);
		    opacity: .5;
		    transition: .5s;
		}
		.pagination li.dot a{
			border:none;
		}
		.pagination a:hover{
			opacity: 1;
		    transition: .5s;
		}
		#myTopnav{
			margin-right: -15px;
		}
		@media  screen and  (max-width: 768px){
			#myTopnav{
				margin-right: 0;
			}
			#menuToggle{
				display:block;
			}
			header .nav{
				display:none;
			}
			header .nav.responsive{
				position: absolute;
				right: 0;
				display: flex;
				flex-direction: column;
				width: 100%;
				top: 65px;
				padding: 40px 20px;
				background: var(--cl-white);
				box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.05);
			}
			header .nav.responsive a{
				padding: 10px 0;
				font-size: 20px;
			}

			.lists-blog .item{
				flex-direction: column-reverse;
			}
			.lists-blog .item .left{

			}
			.lists-blog .item .right, .lists-blog .item .left{
				width:100%;
				padding:0;
			}
		}


		
	
	</style>


</head>
<body {!!get_body_class()!!}>

	@header

	@yield('content')

	@footer
	
	<script>
		document.getElementById('menuToggle').addEventListener('click',function(){
			this.classList.toggle('active');
			var x = document.getElementById("myTopnav");
			if( this.classList.contains('active') ){
				x.className += " responsive";
			}else{
				x.className = "nav";
			}
		});
	</script>
 	@yield('js')

</body>
</html>
