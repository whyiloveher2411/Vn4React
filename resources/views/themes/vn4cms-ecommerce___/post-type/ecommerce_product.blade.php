 @extends(theme_extends())


@section('css')
	<link rel="stylesheet" href="@theme_asset()js/lib/slick/slick.css">
	<link rel="stylesheet" href="@theme_asset()css/lib/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="@theme_asset()css/lib/fontawesome/css/solid.css">
	<link rel="stylesheet" href="@theme_asset()css/style.min.css">
@stop
@section('content')
 <?php 
	$meta = $post->getMeta('product-info');


	if( isset($meta['price_min']) && isset($meta['sale_price_min']) ){
		if( $meta['price_min'] === $meta['price_max'] ) $price = number_format($meta['price_min'],0,',','.');
		else $price = number_format($meta['price_min'],0,',','.').' - '.number_format($meta['price_max'],0,',','.');
		if( $meta['sale_price_min'] === $meta['sale_price_max'] ) $sale_price = number_format($meta['sale_price_min']);
		else $sale_price = number_format($meta['sale_price_min'],0,',','.').' - '.number_format($meta['sale_price_max'],0,',','.');
		$price_avg = number_format($meta['price_max'] - $meta['sale_price_max'],0,',','.');
	}

	$up_selling = [];

	if( isset($meta['up-selling'][0]) ){

		$up_selling = get_posts('ecommerce_product',['callback'=>function( $q ) use ($meta) {

			$q->whereIn('id',$meta['up-selling']);

			// dd($q->whereIn('id',$meta['up-selling'])->dd());
		}]);
	}

	$cross_selling = [];

	if( isset($meta['cross-selling'][0]) ){

		$cross_selling = get_posts('ecommerce_product',['callback'=>function( $q ) use ($meta) {

			$q->whereIn('id',$meta['cross-selling']);

			// dd($q->whereIn('id',$meta['up-selling'])->dd());
		}]);
	}

	$faqs = $post->related('ecommerce_faq','ecommerce_product',['count'=>5]);


	// dd($meta);
 ?>

<main id="main-content">
<div class="breadcrumb">
	<div class="container">
		<ul>
		    <li><a href="/">Trang chủ</a></li>
		   
		    <?php 
		    	$categories = $meta['categories']??[];
		     ?>

		     @foreach($categories as $c)
		    <li><a href="{!!get_permalinks($c)!!}"><span>{!!$c['title']!!}</span></a></li>
		    @endforeach
		    <li><a href="{!!get_permalinks($post)!!}"><span>{!!$post->title!!}</span></a></li>

		</ul>
	</div>
</div>
<div class="container">
	<div class="product-detail flex">
		<div class="list-img">
			<div class="flex-wrap">
				<div class="col-3 ">

					<?php 
						$images = get_media($post->images,[]);
						$count = count($images);
					 ?>

					 @for( $i = 0 ; $i < 4; $i ++ )

					 @if( isset($images[$i]) )
					 <div class="img-item">
						<img class="img" data-src="{!!$images[$i]!!}" alt="">
					</div>
					@endif
					 @endfor
					
					@if( isset($images[4]) )
					<div class="img-item last">
						<img class="img" data-src="{!!$images[4]!!}" alt="">
						<span>Xem thêm {!!$count - 4!!} hình</span>
					</div>
					@endif

				</div>
				<div class="col-9">
					<div class="img-current">
						<img class="img" data-src="{!!get_media($post->thumbnail)!!}" alt="">
						<p class="note">
							<img data-src="@theme_asset()img/zoom-in.png" alt="">Rê chuột lên hình để phóng to
						</p>
					</div>
				</div>
				<div class="product-feature-images mg-t-30">
					<p>Hình ảnh thực tế từ khách hàng</p>
					<div class="flex6">
						<div class="img-item">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
						</div>
						<div class="img-item">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
						</div>
						<div class="img-item">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
						</div>
						<div class="img-item">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
						</div>
						<div class="img-item">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
						</div>
						<div class="img-item last">
							<img class="img" data-src="@theme_asset()img/e29df37653dfa3dca7dc94d8f36270ed.jpg" alt="">
							<span>Xem thêm 4 hình</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="product-info">
			<h1 class="title pd-h-20">{!!$post->title!!}</h1>
			<div class="product-brand-block pd-h-20">
			    <div class="item-row1 brand-block">
			        <div class="item-price">
			            <div class="brand-block-row">
			                <div class="item-other">
			                    <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
			                        <meta itemprop="ratingValue" content="4.5">
			                        <meta itemprop="ratingCount" content="19">
			                    </div>
			                    <div class="item-rating" style="">
			                        <p class="rating">
			                            <span class="rating-box">
			                                <i class="star"></i>
			                                <i class="star"></i>
			                                <i class="star"></i>
			                                <i class="star"></i>
			                                <i class="star"></i>
			                                <span style="width:90%">
			                                    <i class="star"></i>
			                                    <i class="star"></i>
			                                    <i class="star"></i>
			                                    <i class="star"></i>
			                                    <i class="star"></i>
			                                </span>
			                            </span>
			                            <a id="reiews-url" class="review-url" href="tu-lanh-inverter-sharp-sj-x201e-sl-182l-hang-chinh-hang-p813202/nhan-xet">(Xem <span class="-reviews-count">19</span> đánh giá)</a>
			                        </p>
			                    </div>
			                </div>
			            </div>
			            <div class="brand-block-row">
			                <p class="item-bestseller">
			                    <strong>Đứng thứ 8</strong> trong <a href="/bestsellers-month/tu-lanh/c2328">Top 100 Tủ lạnh bán chạy tháng này</a>
			                </p>
			            </div>
			            <div class="brand-block-row">
			                <div itemprop="brand" itemscope="" itemtype="http://schema.org/Brand">
			                    <meta itemprop="name" content="Sharp">
			                    <meta itemprop="url" content="http://tiki.vn/thuong-hieu/sharp.html">
			                </div>
			                <div class="item-brand">
			                    <h6>Thương hiệu: </h6>
			                    <p>
			                        <a target="_blank" href="http://tiki.vn/thuong-hieu/sharp.html">Sharp</a>
			                    </p>
			                </div>
			                <div class="item-brand item-sku" id="product-sku">
			                    <h6>SKU: </h6>
			                    <p>6009934254637 </p>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
			<div class="flex">
				<div class="col-8 pd-l-20">
					<div class="item-row1">
					    <div class="item-price">
					        <div class="price-block show-border">
					            <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
					                <meta itemprop="priceCurrency" content="VND">
					                <meta itemprop="price" content="4148000">
					                <link itemprop="availability" href="http://schema.org/InStock">
					            </div>
					            <p class="special-price-item" data-value="4148000" id="p-specialprice">
					                <span id="flash-sale-price-label" class="">
					                    <img class="icon-hot-deal" data-src="@theme_asset()img/deal-hot@2x.png" width="91">Giá: </span>
					                <span id="span-price">{!!$sale_price!!} ₫</span>
					            </p>
					            <p style="" class="saleoff-price-item" id="p-saving-price">
					                <span class="price-label">Tiết kiệm:</span>
					                <span id="span-discount-percent" class="discount-percent">{!!$meta['discount']!!}</span>
					                <span id="span-saving-price">
					                    ({!!$price_avg!!}đ)
					                </span>
					            </p>
					            <p style="" class="old-price-item" data-value="7300000" id="p-listpirce">
					                <span class="price-label">Giá thị trường:</span>
					                <span id="span-list-price">{!!$price!!}đ</span>
					            </p>
					        </div>
					        <!-- END SAVE & SUB -->
					        <div class="top-feature-item bullet-wrap">
					            {!!$post->short_description!!}
					        </div>
					    </div>
					</div>
					<p class="out-of-stock-msg" style="color: red;">Sản phẩm đã hết hàng</p>
					<div class="item-product-options">
					    <div id="add-cart-action" class="is-installment">
					        <div class="add-cart-action" style="display: block">
					            <div class="quantity-box">
					                <div class="tiki-save-wrapper">
					                    <div id="deal-max" class="alert alert-warning alert-small deal-max">
					                        Sản phẩm này có giới hạn số lượng khi đặt hàng:<br>
					                        Bạn có thể mua tối đa <span></span> sản phẩm cho mỗi đơn hàng
					                    </div>
					                </div>
					                <div id="qtySelector" class="quantity-col1">
					                    <div class="quantity-label">Số lượng:</div>
					                    <div class="shop-number-input">
					                        <div class="input-group bootstrap-touchspin">
					                        	<button class="btn btn-default" type="button">-</button>
					                        	<input id="qty" type="tel" name="qty" value="1" min="1" max="100" class="form-control" style="display: block;    width: 30px;" />
					                        	<button class="btn" type="button">+</button>
					                        </div>
					                    </div>
					                </div>
					                <div class="cta-box">
					                    <button id="#mainAddToCart" class="add-to-cart  js-add-to-cart is-css" type="button">
					                        <span class="text">CHỌN MUA</span>
					                    </button>
					                    <a href="javascript:" class="add-to-wishlist  is-css">
					                        <span class="icon js-product-gift-icon" data-placement="bottom" data-toggle="tooltip" data-title="Thêm Vào Yêu Thích" data-original-title="" title="">
					                            <i class="ico ico-ic-fav"></i>
					                        </span>
					                    </a>
					                    <div id="btn-installment-fee"><a data-reactroot="" class="btn-installment-fee" href=""><span>TRẢ GÓP QUA THẺ TÍN DỤNG</span><br><span> Chỉ từ 345.667 ₫/tháng </span></a></div>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					<div class="item-product-options">
					    <div id="combo-shopping" data-impress-list-title="Product Detail | Thường được mua cùng">
					        <div class="combo-shopping">
					            <h2>THƯỜNG ĐƯỢC MUA CÙNG</h2>
					            <div class="list style-list">

					            	@foreach($up_selling as $p)
				            		<a href="{!!get_permalinks($p)!!}">
						                <div class="item current" data-sid="1337297" data-id="1274913" id="combo_1274913" data-price="2265000">
						                    <div class="checkbox-wrap">
						                        <label class="checkbox">
						                            <input type="checkbox" class="combo-checkbox current" value="1274913" name="combo_1274913" checked="" readonly="">
						                            <span class="ico"></span>
						                        </label>
						                    </div>

						                    <div class="image">
						                        <img data-src="https://salt.tikicdn.com/cache/80x80/ts/product/80/89/aa/f3735094f91e6f0395fcc3c4e15f51ee.jpg" alt="">
						                    </div>
						                    <div class="name">{!!$p->title!!}</div>

						                    <?php 

						                    	$meta = $p->getMeta('product-info');
						                    	if( isset($meta['price_min']) && isset($meta['sale_price_min']) ){
													if( $meta['price_min'] === $meta['price_max'] ) $price = number_format($meta['price_min'],0,',','.');
													else $price = number_format($meta['price_min'],0,',','.').' - '.number_format($meta['price_max'],0,',','.');
													if( $meta['sale_price_min'] === $meta['sale_price_max'] ) $sale_price = number_format($meta['sale_price_min']);
													else $sale_price = number_format($meta['sale_price_min'],0,',','.').' - '.number_format($meta['sale_price_max'],0,',','.');
													$price_avg = number_format($meta['price_max'] - $meta['sale_price_max'],0,',','.');
												}

						                     ?>
						                    <div class="price">{!!$sale_price!!}đ</div>

						                </div>
				           			 </a>
					                @endforeach

					            </div>
					            <div class="summary">
					                <div class="text-right">
					                    <p>Tổng tiền: <span class="total-price price">3.841.000đ</span></p>
					                    <button class="add-combo" type="button">Thêm 4 sp vào giỏ hàng</button>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					<div id="onlyShipToV2" style="">
					    <p class="content">
					        <span class="address">Sản phẩm chỉ giao tại TP HCM</span> Bạn hãy chọn địa chỉ nhận hàng để được dự báo thời gian giao hàng một cách chính xác nhất.
					    <a href="javascript:" class="link">Nhập địa chỉ</a></p>
					</div>
					<div id="report-product" class=" mg-t-20">
					    <div data-reactroot="">
					        <span id="edpIngressContainer">
					            <span class="edpIngressIcon"></span>
					            <a id="edpIngress" class="a-declarative" href="#">
					                <span class="edpIngressText"> Phản ánh thông tin sản phẩm không chính xác.</span>
					            </a>
					        </span>
					    </div>
					</div>
					<div class="footer-block mg-t-20">
					    <div class="item-promotion" id="promotion">
					        <div class="promotion-content">
					            <div class="item-promotion-content ">
					                <div class="title">DỊCH VỤ &amp; KHUYẾN MÃI LIÊN QUAN</div>
					                <ul class="no-left bullet-wrap">
					                    <li>
					                        <p>Hoàn tiền cho thành viên TikiNOW (tối đa 100k/tháng), <b style="color:#ff3425;">0.25%</b> (10.370đ) - <a href="#" target="_blank">Xem chi tiết</a> </p>
					                    </li>
					                </ul>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
				<div class="col-4">
					
				</div>
			</div>
		</div>
	</div>

	<!-- END: PRODUCT INFO -->
	<div class="side-banner-wrap slider-product">
		<h4 class="title">Sản phẩm thường được xem cùng</h4>
		<div class="list">
			@for($i = 0; $i < 7; $i ++)
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
			@endfor

		</div>
	</div>
	<div class="product-introduction">
		<div class="left">
	        <h3 class="product-table-title">Thông Tin Chi Tiết</h3>
	        <div class="white-panel">
	            <div class="attribute-table multi-table"></div>
	           {!!$post->details!!}
	        </div>
	        <h3 class="product-table-title">Mô Tả Sản Phẩm</h3>
	        <div class="white-panel">
	            <div class="product-description">
	                <div class="product-content-detail">
	                    <div id="gioi-thieu" class="content js-content" itemprop="description" style="max-height: 500px;">
	                        {!!$post->long_description!!}
	                    </div>
	                    <p class="description-addon">
	                        * Giá sản phẩm trên Tiki đã bao gồm thuế theo luật hiện hành. Tuy nhiên tuỳ vào từng loại sản phẩm hoặc phương thức, địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như phí vận chuyển, phụ phí hàng cồng kềnh, ..
	                    </p>
	                    <div class="text-center">
	                    	<a class="js-show-more btn transparent blue" href="#" title="Xem Thêm Nội Dung">Xem Thêm Nội Dung</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="right">
	    </div>
	</div>
	<div id="hoi-dap" class="question-answer-box">
	    <div class="question-answer-title">
	        <h2>Hỏi, đáp về sản phẩm</h2>
	    </div>
	    <div class="question-answer-content">

	    	@forif($faqs as $p)
	        <div class="item">
	            <div class="item-col-1">
	                <div class="group">
	                    <p class="number js-numhelpfulness-question" data-js-numhelpfulness-item="1716659">
	                        0 </p>
	                    <p class="text">Thích</p>
	                </div>
	            </div>
	            <div class="item-col-2">
	                <div class="group">
	                    <p class="name">{!!$p->title!!}</p>
	                    <p class="ans-content">{!!$p->anwser!!}</p>
	                    <p class="tiki-support-ans">Tiki trả lời vào 16/03/2020</p>
	                    <p class="action">
	                        <a href="javascript:void(0)" class="js-like-question" data-js-id="1716659">Thích</a>
	                        <a href="https://tiki.vn/tu-lanh-mini-electrolux-eum0900sa-90l-hang-chinh-hang-p1274913/hoi-dap/1716659" class="js-reply-question">Trả lời</a>
	                    </p>
	                </div>
	            </div>
	        </div>
	        @endforif

	    </div>
	    <div class="question-answer-form">
	        <p class="all"><a href="/product/1274913/hoi-dap">Xem tất cả các câu hỏi đã được trả lời</a></p>
	        <p class="form" id="qaForm">
	            <input type="text" name="content" id="content" data-product="1274913" class="form-control" value="" placeholder="Hãy đặt câu hỏi liên quan đến sản phẩm...">
	            <button type="button" class="btn yellow">Gửi câu hỏi</button>
	        </p>
	    </div>
	</div>
	<div class="product-customer-box">
		<h2>Khách Hàng Nhận Xét</h2>
		<div class="product-customer-content">
		    <div class="product-customer-col-1">
		        <h4>Đánh Giá Trung Bình</h4>
		        <p class="total-review-point">3.5/5</p>
		        <div class="item-rating" style="text-align: center">
		            <p class="rating">
		                <span class="rating-box">
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <span style="width: 70%;">
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                    </span>
		                </span>
		            </p>
		            <p class="comments-count"><a href="tu-lanh-mini-electrolux-eum0900sa-90l-hang-chinh-hang-p1274913/nhan-xet">(53 nhận xét)</a></p>
		        </div>
		    </div>
		    <div class="product-customer-col-2">
		        <div class="item rate-5">
		            <span class="rating-num">5</span>
		            <div class="progress">
		                <div class="progress-bar progress-bar-success" style="width: 36%;">
		                    <span class="sr-only"></span>
		                </div>
		            </div>
		            <span class="rating-num-total">36%</span>
		        </div>
		        <div class="item rate-4">
		            <span class="rating-num">4</span>
		            <div class="progress">
		                <div class="progress-bar progress-bar-success" style="width: 31%;">
		                    <span class="sr-only"></span>
		                </div>
		            </div>
		            <span class="rating-num-total">31%</span>
		        </div>
		        <div class="item rate-3">
		            <span class="rating-num">3</span>
		            <div class="progress">
		                <div class="progress-bar progress-bar-success" style="width: 15%;">
		                    <span class="sr-only"></span>
		                </div>
		            </div>
		            <span class="rating-num-total">15%</span>
		        </div>
		        <div class="item rate-2">
		            <span class="rating-num">2</span>
		            <div class="progress">
		                <div class="progress-bar progress-bar-success" style="width: 7%;">
		                    <span class="sr-only"></span>
		                </div>
		            </div>
		            <span class="rating-num-total">7%</span>
		        </div>
		        <div class="item rate-1">
		            <span class="rating-num">1</span>
		            <div class="progress">
		                <div class="progress-bar progress-bar-success" style="width: 11%;">
		                    <span class="sr-only"></span>
		                </div>
		            </div>
		            <span class="rating-num-total">11%</span>
		        </div>
		    </div>
		    <div class="product-customer-col-3">
		        <h4>Chia sẻ nhận xét về sản phẩm</h4>
		        <button type="button" class="btn yellow btn-default js-customer-button">
		            Viết nhận xét của bạn
		        </button>
		    </div>
		    <div class="clearfix"></div>
		    <h3 class="js-customer-h3">Gửi nhận xét của bạn</h3>
		    <div class="product-customer-col-4 js-customer-col-4">
		        <form action="" method="post" id="addReviewFrm" novalidate="novalidate" class="bv-form">
		            <div class="rate form-group has-feedback" id="rating_wrapper">
		                <label>1. Đánh giá của bạn về sản phẩm này:</label>
		                <div class="rating-input">
		                	<i class="glyphicon glyphicon-star-empty" data-value="1"></i><i class="glyphicon glyphicon-star-empty" data-value="2"></i><i class="glyphicon glyphicon-star-empty" data-value="3"></i><i class="glyphicon glyphicon-star-empty" data-value="4"></i><i class="glyphicon glyphicon-star-empty" data-value="5"></i>
		                </div>
		                <small class="help-block" data-bv-validator="callback" data-bv-for="rating_star" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng chọn đánh giá của bạn về sản phẩm này.</small><small class="help-block" data-bv-validator="integer" data-bv-for="rating_star" data-bv-result="NOT_VALIDATED" style="display: none;">Please enter a valid number</small>
		            </div>
		            <div class="title form-group" id="title_wrapper">
		                <label for="review_title">2. Tiêu đề của nhận xét:</label>
		                <input type="text" placeholder="Nhập tiêu đề nhận xét (không bắt buộc)" name="title" id="review_title" class="form-control input-sm">
		            </div>
		            <div class="review-content form-group has-feedback">
		                <label for="review_detail">3. Viết nhận xét của bạn vào bên dưới:</label>
		                <textarea placeholder="Nhận xét của bạn về sản phẩm này" class="form-control" name="detail" id="review_detail" cols="30" rows="10" data-bv-field="detail"></textarea><i class="form-control-feedback" data-bv-icon-for="detail" style="display: none;"></i>
		                <small class="help-block" data-bv-validator="callback" data-bv-for="detail" data-bv-result="NOT_VALIDATED" style="display: none;">Nội dung chứa ít nhất 50 ký tự</small></div>
		            <div id="imageUploader">
		                <div data-reactroot="" class="review-file form-group"><input type="hidden" id="imageUploadPath" name="images[][file_path]" value=""><input type="file" multiple="" id="fileSelector" accept="image/*" style="display: none;"><label for="fileSelector">
		                        <!-- react-text: 5 -->Thêm hình sản phẩm nếu có (tối đa 5 hình):
		                        <!-- /react-text --><span class="button">Chọn hình</span></label>
		                    <p class="error-wrap"></p>
		                    <div class="files"></div>
		                </div>
		            </div>
		            <div class="action">
		                <div class="word-counter"></div>
		                <div class="checkbox" style="display:none;">
		                    <label>
		                        <input id="show_information" type="checkbox" checked="" value="1"> Hiển thị thông tin mua hàng trong phần nhận xét
		                    </label>
		                </div>
		                <div class="text-right">
		                	<button type="submit" class="btn yellow btn-default btn-add-review ">Gửi nhận xét</button>
		                </div>
		                <p class="note">* Để nhận xét được duyệt, quý khách lưu ý tham khảo <a class="js-open-freegift" href="#review-favor">Tiêu chí duyệt nhận xét</a> của Tiki</p>
		            </div>
		        </form>
		    </div>
		    <div class="product-customer-col-5 js-customer-col-5">
		        <div class="product-detail">
		            <div class="image">
		                <a href="https://tiki.vn/tu-lanh-mini-electrolux-eum0900sa-90l-hang-chinh-hang-p1274913.html">
		                    <img src="https://salt.tikicdn.com/cache/215x215/ts/product/80/89/aa/f3735094f91e6f0395fcc3c4e15f51ee.jpg" alt="">
		                </a>
		            </div>
		            <div class="info">
		                <div class="title">Tủ Lạnh Mini Electrolux EUM0900SA (90L) - Hàng Chính Hãng</div>
		                <div itemprop="brand" itemscope="" itemtype="http://schema.org/Brand">
		                    <meta itemprop="name" content="Electrolux">
		                    <meta itemprop="url" content="http://tiki.vn/thuong-hieu/electrolux.html">
		                </div>
		                <div class="item-brand">
		                    <h6>Thương hiệu: </h6>
		                    <p>
		                        <a target="_blank" href="http://tiki.vn/thuong-hieu/electrolux.html">Electrolux</a>
		                    </p>
		                    <div class="item-other">
		                        <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		                            <meta itemprop="ratingValue" content="3.7">
		                            <meta itemprop="ratingCount" content="53">
		                        </div>
		                        <div class="item-rating">
		                            <p class="rating">
		                                <span class="rating-box">
		                                    <i class="star"></i>
		                                    <i class="star"></i>
		                                    <i class="star"></i>
		                                    <i class="star"></i>
		                                    <i class="star"></i>
		                                    <span style="width:74%">
		                                        <i class="star"></i>
		                                        <i class="star"></i>
		                                        <i class="star"></i>
		                                        <i class="star"></i>
		                                        <i class="star"></i>
		                                    </span>
		                                </span>
		                                <a id="reiews-url" href="tu-lanh-mini-electrolux-eum0900sa-90l-hang-chinh-hang-p1274913/nhan-xet">(53 đánh giá)</a>
		                            </p>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <ul>
		            <li>Quý khách có thắc mắc về sản phẩm hoặc dịch vụ của Tiki? Quý khách đang muốn khiếu nại hay phản hồi về đơn hàng đã mua?</li>
		            <li>• Tham khảo thông tin thêm tại <a title="Thông tin hỗ trợ" href="http://hotro.tiki.vn/" target="_blank">Thông tin hỗ trợ</a>.</li>
		            <li>• Liên hệ hotline <a href="tel:1900-6035">1900-6035</a> (1,000đ/phút), hoặc gửi thông tin về email <a href="mailto:hotro@tiki.vn">hotro@tiki.vn</a> để được hỗ trợ ngay.</li>
		        </ul>
		        <div class="promote">
		            <img src="https://salt.tikicdn.com/assets/img/promote-review.png" alt="">
		            <p>
		                Sử dụng Tiki App bạn có thể review tốt hơn với tính năng chụp ảnh và upload trong nháy mắt!
		            </p>
		            <div class="applink">
		                <a rel="nofollow" href="https://play.google.com/store/apps/details?id=vn.tiki.app.tikiandroid" target="_blank">
		                    <img src="https://salt.tikicdn.com/assets/img/icon/playstore@2x.png">
		                </a>
		                <a rel="nofollow" href="https://itunes.apple.com/vn/app/id958100553" target="_blank">
		                    <img src="https://salt.tikicdn.com/assets/img/icon/Appstore@2x.png">
		                </a>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="review-list">
		<div class="item" itemprop="review" itemtype="http://schema.org/Review">
		    <div itemprop="itemReviewed" itemtype="http://schema.org/Product">
		        <span itemprop="name" content=""></span>
		    </div>
		    <div class="product-col-1">
		        <div class="avatar-img" style="background-image: url(&quot;https://graph.facebook.com/1850488568381245/picture?type=large&amp;return_ssl_resources=1&quot;);">
		            </div>
		        <p class="name" itemprop="author">Nguyễn Ngọc Thoa</p>
		        <p class="days">3 tháng trước</p>
		    </div>
		    <div class="product-col-2">
		        <div class="infomation">
		            <div class="flex">
		            	<div class="rating">
			                <div itemprop="reviewRating" itemtype="http://schema.org/Rating">
			                    <meta itemprop="ratingValue" content="4">
			                </div>
			                <span class="rating-box">
			                    <i class="star"></i>
			                    <i class="star"></i>
			                    <i class="star"></i>
			                    <i class="star"></i>
			                    <i class="star"></i>
			                    <span style="width: 80%;">
			                        <i class="star"></i>
			                        <i class="star"></i>
			                        <i class="star"></i>
			                        <i class="star"></i>
			                        <i class="star"></i>
			                    </span>
			                </span>
			            </div>
			            <p class="review" itemprop="name">Hài lòng vừa phải!!!</p>
		            </div>
		            <p class="buy-already">Đã mua sản phẩm này tại Tiki</p>
		            <div class="description js-description">
		                <p class="review_detail" itemprop="reviewBody"><span>
		                        -Tủ giao bị thiếu mất khung chứa đá (trong sách hướng dẫn rõ ràng có ảnh 1 mình chụp) mình hi vọng được tiki số sung thêm.<br></span>
		                        <span>- Tủ đẹp đúng như mô tả web!<br></span>
		                        <span>- Bị cấn móp nhìn khá rõ.<br></span>
		                        <span>- Chưa sủ<br></span>
		                </p>
		            </div>
		            <div class="images">
		                <a rel="photo-review-2729527" href="#">
		                    <span class="thumb" style="background-image: url(&quot;https://vcdn.tikicdn.com/cache/w170/ts/review/ee/26/5d/7d1d9f20f9b2fade19527c363b2bd932.jpg&quot;);"></span>
		                </a>
		                <a rel="photo-review-2729527" href="https://vcdn.tikicdn.com/ts/review/74/0d/68/d54aea0a756cefa30aa173f8de0cfbf5.jpg">
		                    <span class="thumb" style="background-image: url(&quot;https://vcdn.tikicdn.com/cache/w170/ts/review/74/0d/68/d54aea0a756cefa30aa173f8de0cfbf5.jpg&quot;);"></span>
		                </a>
		                <a rel="photo-review-2729527" href="https://vcdn.tikicdn.com/ts/review/27/2d/22/283b86eee1ce69961c1580f7e5926ba4.jpg">
		                    <span class="thumb" style="background-image: url(&quot;https://vcdn.tikicdn.com/cache/w170/ts/review/27/2d/22/283b86eee1ce69961c1580f7e5926ba4.jpg&quot;);"></span>
		                </a>
		                <a rel="photo-review-2729527" href="https://vcdn.tikicdn.com/ts/review/f4/18/9b/6572096e265019ae58cc760bfd05b2dd.jpg">
		                    <span class="thumb" style="background-image: url(&quot;https://vcdn.tikicdn.com/cache/w170/ts/review/f4/18/9b/6572096e265019ae58cc760bfd05b2dd.jpg&quot;);"></span>
		                </a>
		            </div>
		            <div class="link">
		                <p class="review_action">
		                    <a href="#" class="js-quick-reply">Gửi trả lời</a>
		                    <a href="#" class="js-quick-reply">Share Facebook</a>
		                </p>
		                <span>Nhận xét này hữu ích với bạn?</span>
		                <button type="button" class="btn yellow thank-review" data-review-id="2729527" data-product-id="813202">Cảm ơn</button><br>
		            </div>
		            <div class="quick-reply">
		                <textarea class="form-control review_comment" placeholder="Nhập nội dung trả lời tại đây. Tối đa 1500 từ" id=""></textarea>
		                <button type="button" class="btn yellow btn_add_comment" data-review-id="2729527">Gửi trả lời của bạn</button>
		                <button type="button" class="btn btn-default js-quick-reply-hide">Hủy bỏ</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="item" itemprop="review" itemtype="http://schema.org/Review">
		    <div itemprop="itemReviewed" itemtype="http://schema.org/Product">
		        <span itemprop="name" content=""></span>
		    </div>
		    <div class="product-col-1">
		        <div class="avatar-img">
	                <span class="avatar-letter">ST</span>
	            </div>
		        <p class="name" itemprop="author">Sơn Trà</p>
		        <p class="days">một năm trước</p>
		    </div>
		    <div class="product-col-2">
		        <div class="infomation">
		            <div class="rating">
		                <div itemprop="reviewRating" itemtype="http://schema.org/Rating">
		                    <meta itemprop="ratingValue" content="5">
		                </div>
		                <span class="rating-content">
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <i class="star"></i>
		                    <span style="width: 100%;">
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                        <i class="star"></i>
		                    </span>
		                </span>
		            </div>
		            <p class="review" itemprop="name">Cực kì hài lòng</p>
		            <p class="buy-already">Đã mua sản phẩm này tại Tiki</p>
		            <div class="description js-description">
		                <p class="review_detail" itemprop="reviewBody">
		                    <span>rất hài lòng, địa chỉ giao hàng của mình tận Củ Chi nhưng nhân viên Tiki giao hàng rất nhiệt tình và đúng giờ. Cảm ơn Tiki.<br></span>
		                </p>
		            </div>
		            <div class="link">
		                <p class="review_action">
		                    <a href="#" class="js-quick-reply">Gửi trả lời</a>
		                    <a href="#" class="js-quick-reply">Share Facebook</a></p><span class="text-success">1 người đã cảm ơn nhận xét này</span>
		                    <span>Nhận xét này hữu ích với bạn?</span>
		                    <button type="button" class="btn btn-primary thank-review" data-review-id="2115391" data-product-id="813202">Cảm ơn</button>
		                    <br>
		            </div>
		            <div class="quick-reply">
		                <textarea class="form-control review_comment" placeholder="Nhập nội dung trả lời tại đây. Tối đa 1500 từ" id=""></textarea>
		                <button type="button" class="btn yellow btn_add_comment" data-review-id="2115391">Gửi trả lời của bạn</button>
		                <button type="button" class="btn btn-default js-quick-reply-hide">Hủy bỏ</button>
		            </div>
		        </div>
		    </div>
		</div>
		<ul class="paginate ">
			<li><a rel="prev" class="prev" href="#"><i class="fa fa-angle-left"></i></a></li>
			<li>
				<a href="#">1</a>
			</li>
			<li>
				<a href="#">2</a>
			</li>
			<li>
				<a href="#">3</a>
			</li>
			<li >
				<a class="current" href="#">4</a>
			</li>
			<li>
				<a href="#">5</a>
			</li>
			<li>
				<a href="#">6</a>
			</li>
			<li>
				<a href="#">7</a>
			</li>
			<li><a class="next" rel="next" href="#"><i class="fa fa-angle-right"></i></a></li>
		</ul>
	</div>
	
</div>
</main>

	
@stop
		
	