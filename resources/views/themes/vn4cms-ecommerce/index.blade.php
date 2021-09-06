@extends(theme_extends())
@section('content')
<main>
	<section class="uk-position-relative uk-visible-toggle uk-light"
		uk-slideshow="min-height: 300; max-height: 600;">
		<ul class="uk-slideshow-items">
			<li style="background-color: #0b0a12"><a href="#">
					<figure class="uk-container uk-height-1-1"><img src="@theme_asset()images/promo/macbook-new.jpg"
							alt="New Macbook" width="1200" height="600" uk-cover></figure>
				</a></li>
			<li style="background-color: #ce071e"><a href="#">
					<figure class="uk-container uk-height-1-1"><img src="@theme_asset()images/promo/iphone.jpg" alt="iPhone"
							width="1200" height="600" uk-cover></figure>
				</a></li>
			<li style="background-color: #1f2024"><a href="#">
					<figure class="uk-container uk-height-1-1"><img src="@theme_asset()images/promo/ipad.jpg" alt="iPad"
							width="1200" height="600" uk-cover></figure>
				</a></li>
		</ul><a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#"
			uk-slideshow-item="previous" uk-slidenav-previous></a><a
			class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slideshow-item="next"
			uk-slidenav-next></a>
		<div class="uk-position-bottom-center uk-position-small">
			<ul class="uk-slideshow-nav uk-dotnav"></ul>
		</div>
	</section>
	<section class="uk-section uk-section-default uk-section-small">
		<div class="uk-container">
			<div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-6@m" uk-grid>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/laptops.png" alt="Laptops"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Laptops</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $149</div>
						</div>
					</a></div>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/smartphones.png" alt="Smartphones"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Smartphones</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $99</div>
						</div>
					</a></div>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/tablets.png" alt="Tablets"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Tablets</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $129</div>
						</div>
					</a></div>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/watches.png" alt="Smart Watches"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Smart Watches</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $49</div>
						</div>
					</a></div>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/consoles.png" alt="Gaming Consoles"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Gaming Consoles</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $399</div>
						</div>
					</a></div>
				<div><a class="uk-link-muted uk-text-center uk-display-block uk-padding-small uk-box-shadow-hover-large"
						href="subcategory">
						<div class="tm-ratio tm-ratio-4-3">
							<div class="tm-media-box">
								<figure class="tm-media-box-wrap"><img class="item-brand"
										src="@theme_asset()images/catalog/cameras.png" alt="Cameras"></figure>
							</div>
						</div>
						<div class="uk-margin-small-top">
							<div class="uk-text-truncate">Cameras</div>
							<div class="uk-text-meta uk-text-xsmall uk-text-truncate">from $129</div>
						</div>
					</a></div>
			</div>
			<div class="uk-margin uk-text-center"><a class="uk-link-muted uk-text-uppercase tm-link-to-all"
					href="catalog"><span>see all categories</span><span
						uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
		</div>
	</section>
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<h2 class="uk-text-center">Trending Items</h2>
			<div class="uk-card uk-card-default tm-ignore-container">
				<div class="uk-grid-collapse uk-child-width-1-3 uk-child-width-1-4@m tm-products-grid" uk-grid>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<div class="tm-product-card-labels"><span
											class="uk-label uk-label-warning">top selling</span><span
											class="uk-label uk-label-danger">trade-in</span></div>
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/1/1-medium.jpg"
											alt="Apple MacBook Pro 15&quot; Touch Bar MPTU2LL/A 256GB (Silver)" />
									</figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Apple MacBook Pro 15&quot; Touch Bar MPTU2LL/A 256GB
										(Silver)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>15.4"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i7</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>16&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>AMD Radeon Pro
											555</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices"><del class="uk-text-meta">$1899.00</del>
									<div class="tm-product-card-price">$1599.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites tm-action-button-active js-added-to"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare tm-action-button-active js-added-to"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<div class="tm-product-card-labels"><span
											class="uk-label uk-label-success">new</span><span
											class="uk-label uk-label-danger">trade-in</span></div>
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/2/2-medium.jpg"
											alt="Apple MacBook 12&quot; MNYN2LL/A 512GB (Rose Gold)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Apple MacBook 12&quot; MNYN2LL/A 512GB (Rose
										Gold)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>12"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i5</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>8&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>Intel® HD Graphics
											615</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices">
									<div class="tm-product-card-price">$1549.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites tm-action-button-active js-added-to"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare tm-action-button-active js-added-to"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/3/3-medium.jpg"
											alt="Lenovo IdeaPad YOGA 920-13IKB 80Y7001RRK (Copper)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Lenovo IdeaPad YOGA 920-13IKB 80Y7001RRK
										(Copper)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>13.9"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™ i7
											8550U</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>16&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>Intel® HD Graphics
											620</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices">
									<div class="tm-product-card-price">$1199.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites tm-action-button-active js-added-to"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<div class="tm-product-card-labels"><span
											class="uk-label uk-label-warning">top selling</span></div>
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/4/4-medium.jpg"
											alt="ASUS Zenbook UX330UA-FC020T (Rose Gold)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">ASUS Zenbook UX330UA-FC020T (Rose Gold)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>13.3"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i7-6500U</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>8&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>Intel® HD Graphics
											520</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices">
									<div class="tm-product-card-price">$749.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/5/5-medium.jpg"
											alt="Dell XPS 15 9560-8968 (Silver)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Dell XPS 15 9560-8968 (Silver)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>15.6"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™ i7
											7700HQ</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>16&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>NVIDIA GeForce GTX
											960M</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices"><del class="uk-text-meta">$999.00</del>
									<div class="tm-product-card-price">$949.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<div class="tm-product-card-labels"><span
											class="uk-label uk-label-danger">trade-in</span></div>
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/6/6-medium.jpg"
											alt="Apple MacBook Air 13&quot; MQD32LL/A 128GB (Silver)" />
									</figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Apple MacBook Air 13&quot; MQD32LL/A 128GB
										(Silver)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>13.3"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i5</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>8&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>Intel® HD Graphics
											6000</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices">
									<div class="tm-product-card-price">$849.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare tm-action-button-active js-added-to"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/7/7-medium.jpg"
											alt="Dell Inspiron 5378-2063 (Gray)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Dell Inspiron 5378-2063 (Gray)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>13.3"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i3-7100U</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>4&nbsp;GB</span></li>
									<li><span class="uk-text-muted">HDD Capacity: </span><span>1&nbsp;TB</span>
									</li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices"><del class="uk-text-meta">$599.00</del>
									<div class="tm-product-card-price">$579.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
					<article class="tm-product-card">
						<div class="tm-product-card-media">
							<div class="tm-ratio tm-ratio-4-3"><a class="tm-media-box" href="product">
									<div class="tm-product-card-labels"><span
											class="uk-label uk-label-success">new</span></div>
									<figure class="tm-media-box-wrap"><img src="@theme_asset()images/products/8/8-medium.jpg"
											alt="Lenovo Yoga 720-13IKB 80X60059RK (Silver)" /></figure>
								</a></div>
						</div>
						<div class="tm-product-card-body">
							<div class="tm-product-card-info">
								<div class="uk-text-meta uk-margin-xsmall-bottom">Laptop</div>
								<h3 class="tm-product-card-title"><a class="uk-link-heading"
										href="product">Lenovo Yoga 720-13IKB 80X60059RK (Silver)</a></h3>
								<ul class="uk-list uk-text-small tm-product-card-properties">
									<li><span class="uk-text-muted">Diagonal display: </span><span>13.3"</span>
									</li>
									<li><span class="uk-text-muted">CPU: </span><span>Intel®&nbsp;Core™
											i5-7200U</span></li>
									<li><span class="uk-text-muted">RAM: </span><span>8&nbsp;GB</span></li>
									<li><span class="uk-text-muted">Video Card: </span><span>Intel® HD Graphics
											620</span></li>
								</ul>
							</div>
							<div class="tm-product-card-shop">
								<div class="tm-product-card-prices">
									<div class="tm-product-card-price">$1099.00</div>
								</div>
								<div class="tm-product-card-add">
									<div class="uk-text-meta tm-product-card-actions"><a
											class="tm-product-card-action js-add-to js-add-to-favorites"
											title="Add to favorites"><span
												uk-icon="icon: heart; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to
												favorites</span></a><a
											class="tm-product-card-action js-add-to js-add-to-compare"
											title="Add to compare"><span
												uk-icon="icon: copy; ratio: .75;"></span><span
												class="tm-product-card-action-text">Add to compare</span></a>
									</div><button
										class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart"><span
											class="tm-product-card-add-button-icon" uk-icon="cart"></span><span
											class="tm-product-card-add-button-text">add to cart</span></button>
								</div>
							</div>
						</div>
					</article>
				</div>
			</div>
			<div class="uk-margin uk-text-center"><a class="uk-link-muted uk-text-uppercase tm-link-to-all"
					href="subcategory"><span>shop all</span><span
						uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
		</div>
	</section>
	<section class="uk-section uk-section-default uk-section-small">
		<div class="uk-container">
			<h2 class="uk-text-center">Popular Brands</h2>
			<div class="uk-margin-medium-top" uk-slider="finite: true">
				<div class="uk-position-relative">
					<div class="uk-grid-small uk-flex-middle" uk-grid>
						<div class="uk-visible@m"><a href="#" uk-slidenav-previous
								uk-slider-item="previous"></a></div>
						<div class="uk-width-expand uk-slider-container">
							<ul
								class="uk-slider-items uk-child-width-1-3 uk-child-width-1-6@s uk-grid uk-grid-large">
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Apple">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/apple.svg"
													alt="Apple"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Samsung">
											<figure class="tm-media-box-wrap"><img
													src="@theme_asset()images/brands/samsung.svg" alt="Samsung"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Sony">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/sony.svg"
													alt="Sony"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Microsoft">
											<figure class="tm-media-box-wrap"><img
													src="@theme_asset()images/brands/microsoft.svg" alt="Microsoft"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Intel">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/intel.svg"
													alt="Intel"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#" title="HP">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/hp.svg"
													alt="HP"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#" title="LG">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/lg.svg"
													alt="LG"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Lenovo">
											<figure class="tm-media-box-wrap"><img
													src="@theme_asset()images/brands/lenovo.svg" alt="Lenovo"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="ASUS">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/asus.svg"
													alt="ASUS"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Acer">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/acer.svg"
													alt="Acer"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Dell">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/dell.svg"
													alt="Dell"></figure>
										</a></div>
								</li>
								<li>
									<div class="tm-ratio tm-ratio-16-9"><a
											class="uk-link-muted tm-media-box tm-grayscale" href="#"
											title="Canon">
											<figure class="tm-media-box-wrap"><img src="@theme_asset()images/brands/canon.svg"
													alt="Canon"></figure>
										</a></div>
								</li>
							</ul>
						</div>
						<div class="uk-visible@m"><a href="#" uk-slider-item="next" uk-slidenav-next></a></div>
					</div>
				</div>
				<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top uk-hidden@m"></ul>
			</div>
			<div class="uk-margin uk-text-center"><a class="uk-link-muted uk-text-uppercase tm-link-to-all"
					href="brands"><span>see all brands</span><span
						uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
		</div>
	</section>
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<h2 class="uk-text-center">Blog</h2>
			<div class="uk-grid-medium uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
				<div><a href="article">
						<article
							class="uk-card uk-card-default uk-card-small uk-article uk-overflow-hidden uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
							<div class="tm-ratio tm-ratio-16-9">
								<figure class="tm-media-box uk-cover-container uk-margin-remove"><img
										src="@theme_asset()images/articles/macbook-photo.jpg"
										alt="Everything You Need to Know About the MacBook Pro"
										uk-cover="uk-cover" /></figure>
							</div>
							<div class="uk-card-body">
								<div class="uk-article-body">
									<div class="uk-article-meta uk-margin-xsmall-bottom"><time>May 21,
											2018</time></div>
									<div>
										<h3 class="uk-margin-remove">Everything You Need to Know About the
											MacBook Pro</h3>
									</div>
									<div class="uk-margin-small-top">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
											sodales eget ipsum id aliquam. Nam consectetur interdum nibh eget
											sodales. Cras volutpat efficitur ornare.</p>
									</div>
								</div>
							</div>
						</article>
					</a></div>
				<div><a href="article">
						<article
							class="uk-card uk-card-default uk-card-small uk-article uk-overflow-hidden uk-box-shadow-hover-large uk-height-1-1 tm-ignore-container">
							<div class="tm-ratio tm-ratio-16-9">
								<figure class="tm-media-box uk-cover-container uk-margin-remove"><img
										src="@theme_asset()images/articles/macos.jpg" alt="Apple introduces macOS Mojave"
										uk-cover="uk-cover" /></figure>
							</div>
							<div class="uk-card-body">
								<div class="uk-article-body">
									<div class="uk-article-meta uk-margin-xsmall-bottom"><time>May 21,
											2018</time></div>
									<div>
										<h3 class="uk-margin-remove">Apple introduces macOS Mojave</h3>
									</div>
									<div class="uk-margin-small-top">
										<p>Praesent consequat justo eu massa malesuada posuere. Donec ultricies
											tincidunt nisl, sed euismod nulla venenatis maximus. Maecenas sit
											amet semper tellus. Pellentesque imperdiet finibus sapien, a
											consectetur eros auctor a.</p>
									</div>
								</div>
							</div>
						</article>
					</a></div>
			</div>
			<div class="uk-margin uk-text-center"><a class="uk-link-muted uk-text-uppercase tm-link-to-all"
					href="blog"><span>see all articles</span><span
						uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
		</div>
	</section>
	<section class="uk-section uk-section-default uk-section-small">
		<div class="uk-container">
			<div class="uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
				<section>
					<h2 class="uk-text-center uk-text-left@s">About</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at neque vulputate,
						vestibulum magna in, accumsan urna. Nulla feugiat ipsum ex, molestie porttitor nibh
						faucibus at. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam hendrerit
						lorem ut finibus semper. Donec ac vehicula erat, nec consequat massa.</p>
					<p>Quisque rhoncus fermentum sapien id congue. Nam at rutrum turpis. Aliquam sagittis
						imperdiet tortor vel dignissim. Ut ipsum nunc, egestas et odio id, vestibulum posuere
						orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus
						mus.</p>
					<div class="uk-text-center uk-text-left@s"><a
							class="uk-link-muted uk-text-uppercase tm-link-to-all" href="about"><span>read
								more</span><span uk-icon="icon: chevron-right; ratio: .75;"></span></a></div>
				</section>
				<section>
					<h2 class="uk-text-center uk-text-left@s">Latest News</h2>
					<ul class="uk-list uk-list-small uk-list-divider">
						<li>
							<article class="uk-article">
								<div class="uk-article-body">
									<div class="uk-article-meta uk-margin-xsmall-bottom"><time>June 4,
											2018</time></div>
									<h3 class="uk-h4 uk-margin-remove"><a class="uk-link-heading"
											href="article">Highlights from WWDC</a></h3>
									<div class="uk-margin-xsmall-top uk-text-small">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
											sodales eget ipsum id aliquam. Nam consectetur interdum nibh eget
											sodales. Cras volutpat efficitur ornare.</p>
									</div>
								</div>
							</article>
						</li>
						<li>
							<article class="uk-article">
								<div class="uk-article-body">
									<div class="uk-article-meta uk-margin-xsmall-bottom"><time>June 4,
											2018</time></div>
									<h3 class="uk-h4 uk-margin-remove"><a class="uk-link-heading"
											href="article">Apple introduces macOS Mojave</a></h3>
									<div class="uk-margin-xsmall-top uk-text-small">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
											sodales eget ipsum id aliquam. Nam consectetur interdum nibh eget
											sodales. Cras volutpat efficitur ornare.</p>
									</div>
								</div>
							</article>
						</li>
						<li>
							<article class="uk-article">
								<div class="uk-article-body">
									<div class="uk-article-meta uk-margin-xsmall-bottom"><time>May 29,
											2018</time></div>
									<h3 class="uk-h4 uk-margin-remove"><a class="uk-link-heading"
											href="article">iOS 11.4 brings stereo pairs and multi-room
											audio with AirPlay 2</a></h3>
									<div class="uk-margin-xsmall-top uk-text-small">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
											sodales eget ipsum id aliquam. Nam consectetur interdum nibh eget
											sodales. Cras volutpat efficitur ornare.</p>
									</div>
								</div>
							</article>
						</li>
					</ul>
					<div class="uk-margin uk-text-center uk-text-left@s"><a
							class="uk-link-muted uk-text-uppercase tm-link-to-all" href="news"><span>see
								all news</span><span uk-icon="icon: chevron-right; ratio: .75;"></span></a>
					</div>
				</section>
			</div>
		</div>
	</section>
	<section class="uk-section uk-section-primary uk-section-small uk-light">
		<div class="uk-container">
			<div class="uk-text-center">
				<div class="uk-h2 uk-margin-remove">Subscribe for updates</div>
				<div>Be aware of new products and special offers.</div>
			</div>
			<div class="uk-margin">
				<form>
					<div class="uk-grid-small uk-flex-center" uk-grid>
						<div class="uk-width-1-1 uk-width-medium@s">
							<div class="uk-inline uk-width-1-1"><span class="uk-form-icon"
									uk-icon="mail"></span><input class="uk-input" type="email"
									placeholder="Your email" required></div>
						</div>
						<div><button class="uk-button uk-button-primary">subscribe</button></div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<section class="uk-section uk-section-default uk-section-small">
		<div class="uk-container">
			<div uk-slider>
				<ul
					class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-5@m uk-grid">
					<li>
						<div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
							<div><span uk-icon="icon: star; ratio: 2.5;"></span></div>
							<div class="uk-text-center uk-text-left@s uk-width-expand@s">
								<div>Mauris placerat</div>
								<div class="uk-text-meta">Donec mollis nibh dolor, sit amet auctor</div>
							</div>
						</div>
					</li>
					<li>
						<div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
							<div><span uk-icon="icon: receiver; ratio: 2.5;"></span></div>
							<div class="uk-text-center uk-text-left@s uk-width-expand@s">
								<div>Lorem ipsum</div>
								<div class="uk-text-meta">Sit amet, consectetur adipiscing elit</div>
							</div>
						</div>
					</li>
					<li>
						<div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
							<div><span uk-icon="icon: location; ratio: 2.5;"></span></div>
							<div class="uk-text-center uk-text-left@s uk-width-expand@s">
								<div>Proin pharetra</div>
								<div class="uk-text-meta">Nec quam a fermentum ut viverra</div>
							</div>
						</div>
					</li>
					<li>
						<div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
							<div><span uk-icon="icon: comments; ratio: 2.5;"></span></div>
							<div class="uk-text-center uk-text-left@s uk-width-expand@s">
								<div>Praesent ultrices</div>
								<div class="uk-text-meta">Praesent ultrices, orci nec finibus</div>
							</div>
						</div>
					</li>
					<li>
						<div class="uk-grid-small uk-flex-center uk-flex-left@s" uk-grid>
							<div><span uk-icon="icon: happy; ratio: 2.5;"></span></div>
							<div class="uk-text-center uk-text-left@s uk-width-expand@s">
								<div>Duis condimentum</div>
								<div class="uk-text-meta">Pellentesque eget varius arcu</div>
							</div>
						</div>
					</li>
				</ul>
				<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>
			</div>
		</div>
	</section>
</main>	
@stop