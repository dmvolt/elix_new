<aside class="main_col__right">
	
	<?= Banners::get_block($current_param_cat, 5) ?>
	<?= Articles::get_right_block($current_param_cat, 3) ?>
	<?= Sertifications::get_right_block($current_param_cat, 1) ?>
	
	<div class="main_col__soc">
		<h2>Мы в соцсетях:</h2>
		<div class="flamp-widget">
			<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
		</div>
		<!-- VK Widget --> 
		<?= Text::vk_widget() ?> 
	</div>
</aside>
<section class="main_col__left">
	
	<?= Breadcrumbs::get_breadcrumbs($article['id'], 'photos', false, $current_param_cat) ?>
	
	<?php  if($article AND $article['images']): ?>		
		<?php foreach($article['images'] as $image): ?>
			<a href="<?= Im::imagepath('colorbox', $image['file']->filepathname) ?>" class="img-popup img-gal"><img src="<?= Im::imagepath('photos', $image['file']->filepathname) ?>" alt=""></a>
		<?php endforeach; ?> 
		
		<?= Infoblock::get_page_block(Request::detect_uri()) ?>
	
	<?php else: ?>
		<h2><?= $text_page_not_found ?></h2> 
	<?php endif; ?>
</section>