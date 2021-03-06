<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs($actions['id'], 'actions', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>
		
		<!-- block article start -->
		<article class="article">
			<?php if($actions): ?>

				<?= $edit_interface ?>
				<?=$actions['descriptions'][Data::_('lang_id')]['body'] ?>
				
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
		</article>
		<!-- block article end -->
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