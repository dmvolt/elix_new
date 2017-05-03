<main class="main main_col">
	<section class="main_col__wide">
	
		<?= Breadcrumbs::get_breadcrumbs(0, 'photos', false, $current_param_cat) ?>
	
		<?php  if($photos): ?>		
			
			<?php foreach($photos as $photo): ?>
				<h2><a href="<?= Data::_('lang_uri') . '/photos/' . $photo['alias'] ?>"><?= $photo['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
				
				<?php  if($photo['images']): ?>		
					<?php foreach($photo['images'] as $image): ?>
						<a href="<?= Im::imagepath('colorbox', $image['file']->filepathname) ?>" class="img-popup img-gal"><img src="<?= Im::imagepath('photos', $image['file']->filepathname) ?>" alt=""></a>
					<?php endforeach; ?> 
				<?php endif; ?>
			<?php endforeach; ?> 
			
			<?= Infoblock::get_page_block(Request::detect_uri()) ?>
		
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2> 
		<?php endif; ?>
	</section>
	<aside class="main_col__right hide-1200">
		<?//= Banners::get_block($current_param_cat, 5) ?>
		<?//= Articles::get_right_block($current_param_cat, 3) ?>
		<?//= Sertifications::get_right_block($current_param_cat, 1) ?>
		
		<div class="sticker">
			<div class="main_col__soc">
				<h2>Мы в соцсетях:</h2>
				<div class="flamp-widget">
					<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
				</div>
				<!-- VK Widget --> 
				<?= Text::vk_widget() ?> 
			</div>
		</div>
	</aside>
</main>