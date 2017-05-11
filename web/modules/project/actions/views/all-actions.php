<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'actions', false, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<?php if($all_actions): ?>
			<h1><?= $page_title ?></h1>

			<?= $pagination ?>

			<div class="flex">
				<?php foreach($all_actions as $article): ?>
					<div class="flex__item flex__item--50 flex__item--bp-480--100">
						<a href="<?= Data::_('lang_uri') . $cat_url . '/actions/' . $article['alias'] ?>">
							<!-- block pic start -->
							<?php if($article['thumb']): ?>
								<div class="pic">
									<img src="<?= Im::imagepath('600x150', $article['thumb']) ?>" class="pic__img">
								</div>
							<?php endif; ?>
							<!-- block pic end -->
						</a>
					</div>
				<?php endforeach; ?> 
			</div>

			<?= $pagination ?>
		
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
	
		<?//= Infoblock::get_page_block(Request::detect_uri()) ?>

		<?= Articles::get_block($current_param_cat, 9) ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
		<!-- block widgets start -->
		<div class="info info--widgets pos-sticky">
			<?= Banners::get_right_block2($current_param_cat, 5) ?>
		</div>
		<!-- block widgets end -->
	</aside>
</div>