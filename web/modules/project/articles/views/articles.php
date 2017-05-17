<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'articles') ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>

		<?php  if($articles): ?>
		
			<?= $pagination ?>
			
			<div class="flex">
				<?php foreach($articles as $article): ?>

					<div class="flex__item flex__item--50 flex__item--bp-480--100">
						<!-- block topic end -->
						<div class="topic topic--big">
							<?= $article['edit_interface'] ?>
							<?php if($article['thumb']): ?>
								<a href="<?= Data::_('lang_uri') . '/articles/' . $article['alias'] ?>" class="topic__figure"><img src="<?= Im::imagepath('200x150', $article['thumb']) ?>" class="img-left"></a>
							<?php endif; ?>
							
							<div class="topic__header"><a href="<?= Data::_('lang_uri') . '/articles/' . $article['alias'] ?>"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></a></div>
							<div class="topic__date"><?= Text::format_date($article['date']) ?></div>
							<div class="topic__text">
								<?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?>
							</div>
							<a href="<?= Data::_('lang_uri') . '/articles/' . $article['alias'] ?>" class="topic__more">Читать далее</a>
						</div>
						<!-- block topic end -->
					</div>
				
				<?php endforeach; ?> 
			</div>

			<?= $pagination ?>
		
		<?php else: ?>
			<article>	
				<h2><?= $text_page_not_found ?></h2>
			</article>	   
		<?php endif; ?>
	
		<?//= Infoblock::get_page_block(Request::detect_uri()) ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">

		<!-- block info start -->
		<div class="info pos-sticky">
			<?= Banners::get_right_block2($current_param_cat, 5) ?>
		</div>
		<!-- block info end -->
		<?//= Sertifications::get_right_block($current_param_cat, 1) ?>
		<!-- VK Widget --> 
		<?//= Text::vk_widget() ?>
		
	</aside>
</div>