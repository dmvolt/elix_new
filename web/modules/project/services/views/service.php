<main class="main main_col">
	<section class="main_col__wide">
	
		<?= Breadcrumbs::get_breadcrumbs($service['id'], 'services', $cat2, $current_param_cat) ?>
	
		<?php if($service): ?>
			<article class="article">

				<?= $edit_interface ?>
				<div id="services_content_<?= $service['id'] ?>"><?=$service['descriptions'][Data::_('lang_id')]['body'] ?></div>
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yasharel10n="ru" data-yasharetype="button" data-yasharequickservices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir" <="" p="">
					<p>&gt;</p>
				</div>
			</article>
			
			<?php if($partners): ?>
				<h2 class="header-line">Салоны, в которых есть данная услуга</h2>
				<?php foreach($partners as $item): ?>
					<?php if($item): ?>
						<div class="filial">
							<h2 class="filial__header"><a href="<?= Data::_('lang_uri') . '/contacts/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
							<div class="filial__content">
								<div class="filial__map" style="width:100%"><?= $item['map'] ?></div>
								<div class="filial__text">
									<div class="filial__icon filial__icon_adr"><?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
									
									<?php if(!empty($item['phones']) AND !empty($item['phones'][0])): ?>
										<div class="filial__icon filial__icon_tel">
											<?php foreach($item['phones'] as $phone): ?>
												<a href="tel:<?= preg_replace('~[^+0-9]+~','', trim($phone)) ?>"><?= trim($phone) ?></a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
									<?php if(!empty($item['email'])): ?>
										<div class="filial__icon filial__icon_mail"><a href="mailto:<?= $item['email'] ?>"><?= $item['email'] ?></a></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			
		<?php else: ?>
			<h2 class="title"><?= $text_page_not_found ?></h2>
		<?php endif; ?>
	</section>
	<aside class="main_col__right hide-1200">
		<?= Banners::get_block($current_param_cat, 5) ?>
		<?= Articles::get_right_block($current_param_cat, 3) ?>
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