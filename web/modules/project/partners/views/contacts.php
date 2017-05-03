<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs(0, 'partners') ?>
		<?php if($partners): ?>
			<?php foreach($partners as $actions): ?>
				<div class="filial">
					<h2 class="filial__header"><a href="<?= Data::_('lang_uri') . '/contacts/' . $actions['alias'] ?>"><?= $actions['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
					<div class="filial__content">
						<div class="filial__map" style="width:100%"><?= $actions['map'] ?></div>
						<div class="filial__text">
							<div class="filial__icon filial__icon_adr"><?= $actions['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
							
							<?php if(!empty($actions['phones']) AND !empty($actions['phones'][0])): ?>
								<div class="filial__icon filial__icon_tel">
									<?php foreach($actions['phones'] as $phone): ?>
										<a href="tel:<?= preg_replace('~[^+0-9]+~','', trim($phone)) ?>"><?= trim($phone) ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if(!empty($actions['email'])): ?>
								<div class="filial__icon filial__icon_mail"><a href="mailto:<?= $actions['email'] ?>"><?= $actions['email'] ?></a></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?= Infoblock::get_page_block(Request::detect_uri()) ?>
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2>
		<?php endif; ?>
	</section>
	<aside class="main_col__right main_col__right_1200">
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