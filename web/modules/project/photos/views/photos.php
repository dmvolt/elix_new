<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'photos', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->
		
		<?php  if($photos): ?>		
			
			<?php foreach($photos as $photo): ?>
				<h2><a href="<?= Data::_('lang_uri') . '/photos/' . $photo['alias'] ?>"><?= $photo['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
				
				<?php  if($photo['images']): ?>	
					<div class="flex">
						<?php foreach($photo['images'] as $image): ?>
						
							<div class="flex__item flex__item--33 flex__item--bp-980--50">
								<!-- block photo start -->
								<div class="photo">
									<a href="<?= Im::imagepath('colorbox', $image['file']->filepathname) ?>" class="photo__figure js-popup-image"><img src="<?= Im::imagepath('250x200', $image['file']->filepathname) ?>"></a>
								</div>
								<!-- block photo end -->
							</div>
			
						<?php endforeach; ?> 
					</div>
				<?php endif; ?>
			<?php endforeach; ?> 
			
			<?= Infoblock::get_page_block(Request::detect_uri()) ?>
		
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2> 
		<?php endif; ?>

		<?= Articles::get_block($current_param_cat, 9) ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<!-- block widgets start -->
		<div class="info info--widgets pos-sticky">
			<?= Banners::get_right_block2($current_param_cat, 5) ?>
		</div>
		<!-- block widgets end -->
		<!-- VK Widget --> 
		<?//= Text::vk_widget() ?>
	</aside>
</div>