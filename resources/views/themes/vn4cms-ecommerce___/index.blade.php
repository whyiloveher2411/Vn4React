@extends(theme_extends())

<?php 
	title_head('Home');
 ?>

@section('css')
	<link rel="stylesheet" href="@theme_asset()css/style.min.css">
	<link rel="stylesheet" href="@theme_asset()js/lib/slick/slick.css">
@stop
@section('content')

<main id="main-content">
	<div class="block1">
		<div class="container">
			<div class="space"></div>
			<div class="col2">
				<div class="home-slick1">
					<a href="#">
						<img class="img" data-src="@theme_asset()img/8b51b5e49bd856a3b65b6f3176879467.png" alt="">
					</a>
					<a href="#">
						<img class="img" data-src="@theme_asset()img/aa696affd93190550c31d84a15eb5631.png" alt="">
					</a>
					<a href="#">
						<img class="img" data-src="@theme_asset()img/4d8ace31c7c11540583e5e131b4228f9.png" alt="">
					</a>
					<a href="#">
						<img class="img" data-src="@theme_asset()img/46a88fc4e854d24819ef9e55296fe6ef.png" alt="">
					</a>
					<a href="#">
						<img class="img" data-src="@theme_asset()img/afb80633a3c8d9b6b02766e5654df6b8.png" alt="">
					</a>
					<a href="#">
						<img class="img" data-src="@theme_asset()img/f12df7a966f7de7c67107a07d2c27d3b.png" alt="">
					</a>
				</div>
				<div class="flex">
					<a href="#" class="link-banner col-6">
						<img data-src="@theme_asset()img/4b14e9d11c4e76bbc6b9a13dcaa28b15.png" class="img" alt="">
					</a>
					<a href="#" class="link-banner col-6">
						<img data-src="@theme_asset()img/4b14e9d11c4e76bbc6b9a13dcaa28b15.png" class="img" alt="">
					</a>
				</div>
			</div>
			
			<div class="flex flex-wrap justify pd-h-10 flex-1">
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/db8c3c3fbb805314ab740d08b6a93879.png" alt="">
				</a>
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/706d4d16cf6b1a03f623b08b8f9e028e.png" alt="">
				</a>
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/38f78fa7cf1494f681acd46646694fdb.png" alt="">
				</a>
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/b56b989968981846153c116effec4952.png" alt="">
				</a>
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/bbb38c9ad579fb587db23d3b1bac9189.png" alt="">
				</a>
				<a href="#" class="link-banner col-6">
					<img class="img" data-src="@theme_asset()img/33bdbe4d40ebaff94028227b124d5d2c.png" alt="">
				</a>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="block2">
			<div class="flex">
				<div class="col-3">
					<a href="#">
						<img class="img" data-src="@theme_asset()img/49c7e4ddab1c78e1b42fc8d21a5eff87.png" alt="">
					</a>
				</div>
				<div class="col-3">
					<a href="#">
						<img class="img" data-src="@theme_asset()img/239a9b88aacac6ff8c22a48e602fb0b1.png" alt="">
					</a>
				</div>
				<div class="col-3">
					<a href="#">
						<img class="img" data-src="@theme_asset()img/86052c2520f695e69304802684251de1.png" alt="">
					</a>
				</div>
				<div class="col-3">
					<a href="#">
						<img class="img" data-src="@theme_asset()img/91cf1444762f752868c7b568abca9da1.png" alt="">
					</a>
				</div>
			</div>
		</div>
		<div class="group-product mg-t-40">
			<div class="header">
				<i class="shopicon2 icon-hot-deal-icon"></i>
				<div>
					<h3 class="title">Tiki Deal</h3>
					<p class="description">Cập nhật hàng giờ tất cả những deal giảm giá đặc biệt trên Tiki. Hãy bookmark trang này và quay lại thường xuyên để không bỏ lỡ bạn nhé!</p>
				</div>
			</div>
			<div class="body">
				<div class="list-wraper5">
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/d81c915fe494774b5f6580b53d3061b9.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Ghế ăn dặm Đa năng cho Bé với 07 tính năng- 03 chế độ mang lại sự khác biệt, CÓ ĐỆM VÀ BÁNH XE- Màu Hồng
						</div>
						<div class="price">
							500.000 ₫
							<span class="percent deal">-42%</span>
							<span class="original deal">850.000 ₫</span>
						</div>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/13a9ca26951b589e4b068fd7c80837a0.jpg" class="img" alt="">
						</div>
						<div class="title">
							Máy hâm sữa & tiệt trùng bình sữa đa năng cao cấp 2 in 1 Sassy CHÍNH HÃNG
						</div>
						<div class="price">
							1.090.000 ₫
							<span class="percent deal">-46%</span>
							<span class="original deal">1.990.000 ₫</span>
						</div>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/bd63c472a787af0863f525aea1eae113.png" class="img" alt="">
						</div>
						<div class="title">
							Chăn 4 Mùa 2 Lớp Không Rơi Lông Êm Mềm Cho Bé Yêu (Cỡ Lớn)
						</div>
						<div class="price">
							150.000 ₫
							<span class="percent deal">-35%</span>
							<span class="original deal">230.000 ₫</span>
						</div>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/2061ff8e7232989dae49b18970a95ca0.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Nhiệt Kế Điện Tử Đa Năng - Đo Nhiệt Độ Nước, Sữa, Thực Phẩm
						</div>
						<div class="price">
							89.000 ₫
							<span class="percent deal">-51%</span>
							<span class="original deal">180.000 ₫</span>
						</div>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/fee0e4fcca585a0bb79b805d59bb243e.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Thanh chặn giường cao cấp Umoo
						</div>
						<p class="price">
							449.000 ₫
							<span class="percent deal">-31%</span>
							<span class="original deal">649.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/cbfbd042dc6d72282d7dd71b08880464.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Xe Đẩy Trẻ Em 2 Chiều Có Nhạc Baobaohao 709N - Xanh
						</div>
						<p class="price">959.000 ₫
							<span class="percent deal">-4%</span>
							<span class="original deal">990.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/b1b2b71c4dda21e0293628b05cb5263a.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Túi Đựng Sữa Mẹ (Trữ Sữa Mẹ) Unimom Compact Không Có BPA UM870268 210ml (60 Túi/Hộp)
						</div>
						<p class="price">151.500 ₫
							<span class="percent deal">-10%</span>
							<span class="original deal">167.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/6da282be91fda7583582af8d773e81a4.jpg" class="img" alt="">
						</div>
						<div class="title">
							Tủ lạnh Sharp Inverter 626 lít SJ-FX631V-SL - Hàng Chính Hãng
						</div>
						<p class="price">14.550.000 ₫
							<span class="percent deal">-22%</span>
							<span class="original deal">18.447.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/ae532e4ca236e651762a472ec5508a7f.jpg" class="img" alt="">
						</div>
						<div class="title">
							<i class="iconnow-15"></i>
							Thảm Xốp XPE Nằm Chơi Cho Bé - Nhiều Miếng Ghép
						</div>
						<p class="price">749.000 ₫
							<span class="percent deal">-30%</span>
							<span class="original deal">1.070.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
					<a href="#" class="item_product">
						<div class="cover">
							<img data-src="@theme_asset()img/92535cb6c5e91f552a5a5a9ce306ddc7.jpg" class="img" alt="">
						</div>
						<div class="title">
							Voucher FLC 2020 - Nghỉ Dưỡng 4N3Đ Siêu Tiết Kiệm - Áp Dụng Quy Nhơn, Sầm Sơn, Hạ Long, Vĩnh Phúc
						</div>
						<p class="price">3.888.000 ₫
							<span class="percent deal">-49%</span>
							<span class="original deal">7.500.000 ₫</span>
						</p>
						<div class="progress">
						    <div class="bar">
						        <div class="percent" style="width: 75%;"></div>
						        <div class="content">
						        	<span class="icon tikicon icon-hot_12"></span>
						            <p class="text">Đã bán 75</p>
						        </div>
						    </div>
						    <p class="countdown" style="width: 90px; margin-left: 10px;">0 ngày 01:10:49</p>
						</div>
					</a>
				</div>
			</div>
			<div class="footer flex center-x">
				<a class="btn transparent blue" href="#">Xem thêm</a>
			</div>
		</div>
	</div>
</main>
	
@stop