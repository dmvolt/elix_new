<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'articles', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<!-- block article start -->
		<article class="article">
			<?php if($article): ?>

				<?= $edit_interface ?>
				<?= $article['descriptions'][Data::_('lang_id')]['body'] ?>
				
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yasharel10n="ru" data-yasharetype="button" data-yasharequickservices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir" <="" p="">
					<p>&gt;</p>
				</div>
				<?//= Comments::get_block($article['id']) ?>
				
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