<main class="main main_col">
	<section class="main_col__wide">
	
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'partners') ?>
		
		<article class="article">
			<?php if($article): ?>
			
				<div class="filial">
					<h2 class="filial__header"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></h2>
					<div class="filial__content">
						<div class="filial__map" style="width:100%"><?= $article['map'] ?></div>
						<div class="filial__text">
							<div class="filial__icon filial__icon_adr"><?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
							
							<?php if(!empty($article['phones']) AND !empty($article['phones'][0])): ?>
								<div class="filial__icon filial__icon_tel">
									<?php foreach($article['phones'] as $phone): ?>
										<a href="tel:<?= preg_replace('~[^+0-9]+~','', trim($phone)) ?>"><?= trim($phone) ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if(!empty($article['email'])): ?>
								<div class="filial__icon filial__icon_mail"><a href="mailto:<?= $article['email'] ?>"><?= $article['email'] ?></a></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
		
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
		</article>
	
		<h2 class="header-line">Услуги в данном филиале</h2>
		<div class="article service-list">
			<div class="service-list__col">
				<h3 class="service-list__header"><a href="#">Эпиляция</a></h3>
				<ul class="service-list__ul">
					<li><a href="#">Профессиональные косметологические уходовые программы Eldan</a></li>
					<li><a href="#">Косметический пилинг</a></li>
					<li><a href="#">Механический пилинг</a></li>
					<li><a href="#">Пилинг с применением физических методов</a></li>
					<li><a href="#">Химический пилинг</a></li>
				</ul>
			</div>
			<div class="service-list__col">
				<h3 class="service-list__header"><a href="#">Косметология</a></h3>
				<ul class="service-list__ul">
					<li><a href="#">Профессиональные косметологические уходовые программы Eldan</a></li>
					<li><a href="#">Косметический пилинг</a></li>
					<li><a href="#">Механический пилинг</a></li>
					<li><a href="#">Пилинг с применением физических методов</a></li>
					<li><a href="#">Химический пилинг</a></li>
				</ul>
			</div>
		</div>
	</section>
	<aside class="main_col__right hide-1200">
		<?//= Banners::get_block($current_param_cat, 5) ?>
		<?//= Articles::get_right_block($current_param_cat, 3) ?>
		<?//= Sertifications::get_right_block($current_param_cat, 1) ?>
		
		<div class="main_col__soc">
			<h2>Мы в соцсетях:</h2>
			<div class="flamp-widget">
				<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
			</div>
			<!-- VK Widget --> 
			<?= Text::vk_widget() ?>
		</div>
	</aside>
</main>