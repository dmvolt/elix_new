<!DOCTYPE html>
<html lang="<?= Data::_('lang_ident') ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<title><?= $title ?> : <?= $region_title ?> : <?= $page_title ?></title>
	<meta name="description" content="<?= $meta_description ?>" />
	<meta name="Keywords" content="<?= $meta_keywords ?>" />

	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="apple-touch-icon" href="<?= PARENT_FULLURL ?>/apple-touch-icon.png"/>
	<link rel="shortcut icon" href="<?= PARENT_FULLURL ?>/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Philosopher:400italic,700italic&amp;subset=latin,cyrillic"/>

	<?php foreach ($styles as $style): ?>
		<link href="<?= $style ?>.css" rel="stylesheet" type="text/css" />
	<?php endforeach; ?>

	<?php if(isset($scripts1) AND count($scripts1)>0): ?>
		<?php foreach ($scripts1 as $script): ?>
			<script type="text/javascript" src="<?= $script ?>.js" ></script>
		<?php endforeach; ?>
	<?php endif; ?>
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?124"></script>
</head>

<body dir="<?= Data::_('lang_dir') ?>" class="<?= $page_class ?>">
	<!--[if lte IE 7]>
	<p class="chromeframe"><?= $text_old_browser_warning ?></p>
	<![endif]-->
	
	<header class="header">
		<div class="header__top">
			<div class="header__logo">
				<a href="<?= FULLURL ?>">
					<img src="<?= PARENT_FULLURL ?>/images/logo-b.png" alt=""/>
				</a>
			</div>
			<div class="header__center">
				<?= $menu_category_parent ?>
			</div>
			<div class="header__right">
			
				<?= Filials::get_block($filial) ?>
				<?= $menu_social ?>
				
				<div id="menu" class="menu">
					<div class="menu__button js-menu-button">
						<span class="menu__button-text">Меню</span>
						<span data-icon-name="hamburgerCross" class="si-icon si-icon-hamburger-cross"></span>
					</div>
					<div class="menu__list">
						<ul class="menu__ul">
							<?= $menu_left ?>
							<hr/>
							<?= $menu_right ?>
							
							<div class="menu__mobile">
								<hr/>
								<li class="menu__li">
									<?= $menu_social_mobile ?>
								</li>
							</div>
							<?= $login_block ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="header__bottom">
			<nav class="nav">
				<ul class="nav__ul">
					<?= $menu_category_childs2 ?>
				</ul>
			</nav>
			
			<?php if($address):?>
				<address class="address">
					<?php foreach($address as $item):?>
						<div class="address__item">
							<div class="address__place"><a href="<?= Data::_('lang_uri') . '/contacts/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?></a></div>
							<div class="address__tel"><a href="<?= $item['phones'][0] ?>"><?= $item['phones'][0] ?></a></div>
						</div>
					<?php endforeach;?>
				</address>
			<?php endif;?>
		</div>
		<div class="header__mobile">
			<?= $menu_category_childs ?>
		</div>
	</header>

	<?= $content ?>

	<?//= Tags::get_cloud() ?>

	<?//= $feedback_block ?>
	<?//= $review_block ?>
	<?//= $check_block ?>
	
	<footer class="footer">
		<div class="footer__top cont"><?= $licence ?></div>
		<div class="footer__bottom">
			<div class="cont"><?= Text::get_footer_info() ?></div>
		</div>
	</footer>

	<?php foreach ($scripts2 as $script): ?>
		<script type="text/javascript" src="<?= $script ?>.js" ></script>
	<?php endforeach; ?>
	<script src="https://use.fontawesome.com/8b844d3da3.js"></script>
</body>
</html>
<?//= $bottom_script // Код LiteEdit ?>