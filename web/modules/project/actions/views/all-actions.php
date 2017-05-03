<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs(0, 'actions', false, $current_param_cat) ?>
		
		<?php  if($all_actions): ?>
		
			<div class="announce-pager">
				<?= $pagination ?>
			</div>
			
			<div class="announce">
				<?php foreach($all_actions as $article): ?>
					<div class="announce__entry">
						<?php if($article['thumb']): ?>
							<a href="<?= Data::_('lang_uri') . $cat_url . '/actions/' . $article['alias'] ?>" class="announce__a"><img src="<?= Im::imagepath('preview', $article['thumb']) ?>"></a> <!-- 230 X 230 -->
						<?php endif; ?>
						<div class="announce__text">
							<?= $article['edit_interface'] ?>
							<h3><a href="<?= Data::_('lang_uri') . $cat_url . '/actions/' . $article['alias'] ?>"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
							<div id="actions_content_<?= $article['id'] ?>"><?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
						</div>
						<div class="announce__footer"><a href="<?= Data::_('lang_uri') . $cat_url . '/actions/' . $article['alias'] ?>">Читать далее</a></div>
					</div>
				<?php endforeach; ?> 
			</div>
			
			<div class="announce-pager">
				<?= $pagination ?>
			</div>
			
		<?php else: ?>
			<article>	
					<h2><?= $text_page_not_found ?></h2>
			</article>	   
		<?php endif; ?>
		
		<?php  if($modulinfo AND !empty($modulinfo)): ?>
			<article>
				<?= $modulinfo[0]['descriptions'][Data::_('lang_id')]['body'] ?>
			</article>
		<?php endif; ?>
	
		<?= Infoblock::get_page_block(Request::detect_uri()) ?>
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