<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'partners') ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>

		<?php if($partners): ?>
			<?php foreach($partners as $actions): ?>
			
				<div class="flex">
					<div class="flex__item flex__item--66 flex__item--bp-1200--100">
						<h2><a href="<?= Data::_('lang_uri') . '/contacts/' . $actions['alias'] ?>"><?= $actions['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>
						<!-- block pic start -->
						<div class="pic">
							<?= $actions['map'] ?>
						</div>
						<!-- block pic end -->
					</div>

					<aside class="flex__item flex__item--33 flex__item--bp-1200--100">
						<h3>Контакты</h3>
						<h4><a href="#"><img src="/images/map.svg" alt="" class="icon icon--big js-svg"><?= $actions['descriptions'][Data::_('lang_id')]['teaser'] ?></a></h4>
						
						<?php if(!empty($actions['phones']) AND !empty($actions['phones'][0])): ?>
							<?php foreach($actions['phones'] as $phone): ?>
								<h4><a href="tel:<?= preg_replace('~[^+0-9]+~','', trim($phone)) ?>"><img src="/images/phone.svg" alt="" class="icon icon--big js-svg"> <?= trim($phone) ?></a></h4>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if(!empty($actions['email'])): ?>
							<h4><a href="mailto:<?= $actions['email'] ?>"><img src="/images/mail.svg" alt="" class="icon icon--big js-svg"><?= $actions['email'] ?></a></h4>
						<?php endif; ?>
					</aside>
				</div>
		
			<?php endforeach; ?>
			<?= Infoblock::get_page_block(Request::detect_uri()) ?>
		<?php else: ?>
			<h2><?= $text_page_not_found ?></h2>
		<?php endif; ?>
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

<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<?= Articles::get_block($current_param_cat, 9) ?>
	</div>
</div>