<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'partners') ?>
		<!-- block breadcrumbs end -->
		
		<?php if($article): ?>
		
			<h1><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></h1>
			
			<div class="flex">
				<div class="flex__item flex__item--66 flex__item--bp-1200--100">
					<!-- block pic start -->
					<div class="pic">
						<?= $article['map'] ?>
					</div>
					<!-- block pic end -->
				</div>

				<aside class="flex__item flex__item--33 flex__item--bp-1200--100">
					<h4><a href="#"><img src="/images/map.svg" alt="" class="icon icon--big js-svg"><?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?></a></h4>
					
					<?php if(!empty($article['phones']) AND !empty($article['phones'][0])): ?>
						<?php foreach($article['phones'] as $phone): ?>
							<h4><a href="tel:<?= preg_replace('~[^+0-9]+~','', trim($phone)) ?>"><img src="/images/phone.svg" alt="" class="icon icon--big js-svg"> <?= trim($phone) ?></a></h4>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(!empty($article['email'])): ?>
						<h4><a href="mailto:<?= $article['email'] ?>"><img src="/images/mail.svg" alt="" class="icon icon--big js-svg"><?= $article['email'] ?></a></h4>
					<?php endif; ?>
				</aside>
				
				<!-- block article start -->
				<article class="article">
					<?= $article['descriptions'][Data::_('lang_id')]['body'] ?>
				</article>
			</div>

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