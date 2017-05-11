<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'specials', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<div class="flex">
		
			<?php if($article['thumb']): ?>
				<div class="flex__item flex__item--33 flex__item--bp-1200--100 text-center">
					<img src="<?= Im::imagepath('250x300', $article['thumb']) ?>" class="img-specialist">
				</div>
			<?php endif; ?>
			
			<div class="flex__item flex__item--66 flex__item--bp-1200--100">
				<!-- block article start -->
				<article class="article">
					<?php if($article): ?>
			
						<?= $edit_interface ?>
						<?=$article['descriptions'][Data::_('lang_id')]['body'] ?>
					
					<?php else: ?>
						<h2 class="title"><?= $text_page_not_found ?></h2>
					<?php endif; ?>
				</article>
				<!-- block article end -->

			</div>
		</div>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<!-- block info start -->
		<div class="info pos-sticky">
			<?= Banners::get_right_block1($current_param_cat, 5) ?>
		</div>
		<!-- block info end -->
	</aside>
</div>

<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
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