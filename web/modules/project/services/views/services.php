<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">

		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'services', $cat1, $cat2, $cat3) ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>
		
		<article class="article">
			<?php  if($service_info): ?>
				<?= $service_info['descriptions'][1]['body'] ?>
			<?php endif; ?>
			<?php  if(!empty($service_info['price'])): ?>
				<h2>Прайс лист</h2>
				<?= $service_info['price'] ?>
			<?php endif; ?>
		</article>
		
		<?php if($partners): ?>
			<article class="article article--adr">
				<h2>Адреса салонов где оказывают данную услугу</h2>
				<?php foreach($partners as $item): ?>
					<?php if($item): ?>
						<h4><a href="<?= Data::_('lang_uri') . '/contacts/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?> <?//= $item['descriptions'][Data::_('lang_id')]['teaser'] ?></a></h4>
					<?php endif; ?>
				<?php endforeach; ?>
			</article>
		<?php endif; ?>

		<div class="flex">
			<?php if($services): ?>
				<?php foreach($services as $item): ?>
				
					<div class="flex__item flex__item--50 flex__item--bp-480--100">

						<!-- block topic end -->
						<div class="topic topic--big">
							<?= $item['edit_interface'] ?>
							<?php if($item['thumb']): ?>
								<a href="/services<?= $cat_tree_prelink ?><?= $item['alias'] ?>" class="topic__figure">
									<img src="<?= Im::imagepath('200x150', $item['thumb']) ?>" class="img-left">
								</a>
							<?php endif; ?>
							<div class="topic__header"><a href="/services<?= $cat_tree_prelink ?><?= $item['alias'] ?>"><?= $item['descriptions'][1]['title'] ?></a></div>
							<div class="topic__date"><?= Text::format_date($item['date']) ?></div>
							<div class="topic__text">
								<?= $item['descriptions'][1]['teaser'] ?>
							</div>
							<a href="/services<?= $cat_tree_prelink ?><?= $item['alias'] ?>" class="topic__more">Читать далее</a>
						</div>
						<!-- block topic end -->

					</div>
			
				<?php endforeach; ?> 
			<?php endif; ?>
		</div>

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