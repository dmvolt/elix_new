<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<article class="article">
			<h1>404</h1>
			<h2><?= $message ?><br><br><?= $text_error_404 ?></h2>
			<?= Infoblock::get_page_block('text-404') ?>
		</article>
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