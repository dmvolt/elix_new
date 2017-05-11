<!DOCTYPE html>
<html lang="<?= Data::_('lang_ident') ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?= $title ?> : <?= $region_title ?> : <?= $page_title ?></title>
	<meta name="description" content="<?= $meta_description ?>">
	<meta name="Keywords" content="<?= $meta_keywords ?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="<?= PARENT_FULLURL ?>/apple-touch-icon.png">
	<link rel="shortcut icon" href="<?= PARENT_FULLURL ?>/favicon.ico" type="image/x-icon">

	<!-- vk -->
	<link rel="image_src" href="http://examplehost.ru/images/share-big.png">
	<!-- vk -->

	<!-- opengraph  -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="http://examplehost.ru">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:title" content="<?= $page_title ?>">
	<meta property="og:site_name" content="site name">
	<meta property="og:description" content="<?= $meta_description ?>">
	<meta property="og:image" content="http://examplehost.ru/images/share-big.png">
	<meta property="og:image" content="http://examplehost.ru/images/share-small.png">
	<!-- opengraph  -->

	<?php foreach ($styles as $style): ?>
		<link href="<?= $style ?>.css" rel="stylesheet" type="text/css" />
	<?php endforeach; ?>

	<?php if(isset($scripts1) AND count($scripts1)>0): ?>
		<?php foreach ($scripts1 as $script): ?>
			<script type="text/javascript" src="<?= $script ?>.js" ></script>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<!--<script type="text/javascript" src="//vk.com/js/api/openapi.js?124"></script>-->
</head>
<body class="page-<?= $page_class ?>">

	<!--[if lt IE 9]>
		<p class="upgrade"><?= $text_old_browser_warning ?></p>
	<![endif]-->
	
	<div id="js-slideout-panel" class="wrap">
		<!-- block header start -->
		<header class="header">
			<section class="section">
				<div class="section__content">
					<div class="flex header__wrap">
						<div class="flex__item flex__item--10 flex__item--bp-1200--20 flex__item--bp-720--50 header__logo">

							<!-- block logo start -->
							<a href="<?= FULLURL ?>" class="logo">
								<img src="<?= PARENT_FULLURL ?>/images/logo.svg" alt="logo" class="logo__img">
							</a>
							<!-- block logo end -->

							<a href="#popup-city" class="header__city js-popup-inline" data-effect="mfp-move-horizontal"><?= $region_title ?>&nbsp;<span class="text-small">▼</span></a>
						</div>

						<div class="flex__item flex__item--5 flex__item--bp-1200--10"></div>

						<div class="flex__item flex__item--70 flex__item--bp-720--40 header__mobile">
							<?php if($address):?>
								<div class="header__mobile-adr">
									<?php foreach($address as $item):?>
										<div class="header__mobile-adr-item">
											<a href="<?= Data::_('lang_uri') . '/contacts/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?></a>
											<a href="tel:<?= $item['phones'][0] ?>"><?= $item['phones'][0] ?></a>
										</div>
									<?php endforeach;?>
								</div>
							<?php endif;?>

							<div id="js-mobile-menu" class="mobile-menu">
								<div class="mobile-menu__button js-menu-button">
									<span data-icon-name="hamburgerCross" class="si-icon si-icon-hamburger-cross"></span>
								</div>

								<ul class="mobile-menu__list">
								
									<?= $menu_mobile ?>

									<li class="mobile-menu__item pt-1e pb-1e">
										<form class="header__search">
											<input type="search" placeholder="Поиск" class="header__search-input">
											<button type="submit" class="header__search-button"><img src="<?= PARENT_FULLURL ?>/images/elix.svg" alt="" class="icon icon--big js-svg"></button>
										</form>
									</li>

									<li class="mobile-menu__item mobile-menu__social text-center pt-2e pb-1e">
										<?= $menu_social_mobile ?>
									</li>
								</ul>
							</div>
						</div>

						<div class="flex__item flex__item--40 header__vertical">
							<!-- block nav start -->
							<?= $menu ?>
							<!-- block nav end -->
						</div>

						<div class="flex__item flex__item--20 header__vertical">
							<form class="header__search">
								<input type="search" placeholder="Поиск" class="header__search-input">
								<button type="submit" class="header__search-button"><img src="<?= PARENT_FULLURL ?>/images/elix.svg" alt="" class="icon icon--big js-svg"></button>
							</form>
						</div>

						<div class="flex__item flex__item--15 header__vertical">
							<?php if($address):?>
								<address>
									<table class="header__address text-small">
										<?php foreach($address as $item):?>
											<tr>
												<td><a href="<?= Data::_('lang_uri') . '/contacts/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?></a></td>
												<td><a href="tel:<?= $item['phones'][0] ?>"><?= $item['phones'][0] ?></a></td>
											</tr>
										<?php endforeach;?>
									</table>
								</address>
							<?php endif;?>
						</div>

						<div class="flex__item flex__item--10 header__vertical">
							<div class="header__social">
								<?= $menu_social ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</header>
		<!-- block header end -->
	
		<!-- Popup itself -->
		<?= Filials::get_block($filial) ?>
		
		<main class="main">
			<section class="section">
			
				<?php if(Request::current()->controller() == 'front'):?>
					<header class="section__header main__top">
						
						<!-- block pic start -->
						<?= Banners::get_main_block($current_param_cat, 5) ?>
						<!-- block pic end -->

						<!-- <script src="/vtour/tour.js"></script>
						<div id="tour" style="height:400px;">
							<noscript><table style="width:100%;height:100%;"><tr style="valign:middle;"><td><div style="text-align:center;">ERROR:<br/><br/>Javascript not activated<br/><br/></div></td></tr></table></noscript>
							<script>
								var tourheight= document.getElementById('tour').offsetHeight;
								embedpano({swf:"/vtour/tour.swf", xml:"/vtour/tour.xml", target:"tour", html5:"auto", initvars:{divheight:tourheight}, passQueryParameters:true});
							</script> -->
					</header>
				<?php endif;?>
				
				<div class="section__content main__content">
					<div class="flex main__flex">
						<aside class="flex__item flex__item--25 flex__item--bp-1200--0 main__left">
							<!-- block menu start -->
							<?= $menu_category ?>
							<!-- block menu end -->
						</aside>
						<div class="flex__item flex__item--75 flex__item--bp-1200--100 main__cont">
							<?= $content ?>
						</div>
					</div>
				</div>
			</section>
		</main>

		<?//= $login_block ?>
		<?//= Tags::get_cloud() ?>

		<?//= $feedback_block ?>
		<?//= $review_block ?>
		<?//= $check_block ?>
		
		<!-- block footer start -->
		<footer class="footer">
			<section class="section">
				<div class="section__content">
					<div class="container">
						<div class="flex">
							<div class="flex__item flex__item--70 flex__item--bp-1200--100 text-big">
								<?= $licence ?>
							</div>

							<div class="flex__item flex__item--30 flex__item--bp-1200--100 text-right">
								<?= Text::get_footer_info() ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</footer>
		<!-- block footer end -->
	</div>

	<?php foreach ($scripts2 as $script): ?>
		<script type="text/javascript" src="<?= $script ?>.js" ></script>
	<?php endforeach; ?>
	<script src="https://use.fontawesome.com/8b844d3da3.js"></script>
</body>
</html>
<?//= $bottom_script // Код LiteEdit ?>