<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'specials', false, $current_param_cat) ?>
	</section>
	<aside class="main_col__right">
		<div class="main_col__soc">
			<h2>Мы в соцсетях:</h2>
			<div class="flamp-widget">
				<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
			</div>
			<!-- VK Widget --> 
			<?= Text::vk_widget() ?>
		</div>
	</aside>
	<aside class="main_col__left main_col__left_doc"><img src="https://unsplash.it/350/400/?random" alt="">
		<?php if($article): ?>
			<img src="<?= Im::imagepath('preview2', $article['thumb']) ?>" alt=""> <!-- 350 X 400 -->
			<h4><?=$article['descriptions'][Data::_('lang_id')]['teaser'] ?></h4>
		<?php endif; ?>
	</aside>
	<section class="main_col__center">
		<article class="article">
			<?php if($article): ?>
			
				<?= $edit_interface ?>
				<div id="specials_content_<?= $article['id'] ?>"><?=$article['descriptions'][Data::_('lang_id')]['body'] ?></div>
			
			<?php else: ?>
				<h2 class="title"><?= $text_page_not_found ?></h2>
			<?php endif; ?>
			
		</article>
	</section>
</main>