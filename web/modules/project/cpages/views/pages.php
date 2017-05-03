<main class="main main_col">
	<aside class="main_col__right">
		<div class="article">
			<ul>
				<li>
					<h4><a href="#">Специалисты</a></h4>
				</li>
				<li>
					<h4><a href="#">Лицензии</a></h4>
				</li>
				<li>
					<h4><a href="#">Рекомендации</a></h4>
				</li>
				<li>
					<h4><a href="#">Реквизиты</a></h4>
				</li>
				<li>
					<h4><a href="#">Вакансии</a></h4>
				</li>
			</ul>
		</div>
		<?//= Banners::get_block($current_param_cat, 5) ?>
		<?//= Articles::get_right_block($current_param_cat, 3) ?>
		
		<div class="main_col__soc">
			<h2>Мы в соцсетях:</h2>
			<div class="flamp-widget">
				<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
			</div>
			<!-- VK Widget --> 
			<?= Text::vk_widget() ?>
		</div>
	</aside>
	<aside class="main_col__left">
		<?= Sertifications::get_right_block($current_param_cat, 1) ?>
	</aside>
	<section class="main_col__center">
		<?= Breadcrumbs::get_breadcrumbs($page['id'], 'cpages', false, $current_param_cat) ?>
		<article class="article">
			<?php if($page): ?>
				<?= $edit_interface ?>
				<?=$page['descriptions'][Data::_('lang_id')]['body'] ?>
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
		</article>
	</section>
</main>