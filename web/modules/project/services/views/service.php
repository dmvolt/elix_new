<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs($service['id'], 'services', $cat2, $current_param_cat) ?>
		<!-- block breadcrumbs end -->

		<?php if($service): ?>
			<!-- block article start -->
			<article class="article">
				<?= $edit_interface ?>
				
				<h1><?= $service['descriptions'][Data::_('lang_id')]['title'] ?></h1>
				
				<?=  $service['descriptions'][Data::_('lang_id')]['body'] ?>
				
				<?php  if(!empty($service['price'])): ?>
					<h2>Прайс лист</h2>
					<?= $service['price'] ?>
				<?php endif; ?>
				
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yasharel10n="ru" data-yasharetype="button" data-yasharequickservices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir" <="" p="">
					<p>&gt;</p>
				</div>
			</article>
			<!-- block article end -->

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
		<?php else: ?>
			<h2 class="title"><?= $text_page_not_found ?></h2>
		<?php endif; ?>
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
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center main__grad">

		<!-- block swiper-carousel start -->
		<div class="swiper swiper--carousel">
			<div class="swiper-container js-swiper-carousel">
				<div class="swiper-wrapper">

					<div class="swiper-slide">

						<!-- block photo start -->
						<div class="photo">
							<a href="img/border.png" class="photo__figure js-popup-image"><img data-src="holder.js/250x200?auto=yes&theme=social"></a>
						</div>
						<!-- block photo end -->

					</div>

					<div class="swiper-slide">

						<!-- block photo start -->
						<div class="photo">
							<a href="img/border.png" class="photo__figure js-popup-image"><img data-src="holder.js/250x200?auto=yes&theme=social"></a>
						</div>
						<!-- block photo end -->

					</div>

					<div class="swiper-slide">

						<!-- block photo start -->
						<div class="photo">
							<a href="img/border.png" class="photo__figure js-popup-image"><img data-src="holder.js/250x200?auto=yes&theme=social"></a>
						</div>
						<!-- block photo end -->

					</div>

					<div class="swiper-slide">

						<!-- block photo start -->
						<div class="photo">
							<a href="img/border.png" class="photo__figure js-popup-image"><img data-src="holder.js/250x200?auto=yes&theme=social"></a>
						</div>
						<!-- block photo end -->

					</div>
				</div>

			</div>

			<div class="swiper-button-prev js-slider-prev"><img src="/images/arrow.svg" class="icon js-svg"></div>
			<div class="swiper-button-next js-slider-next"><img src="/images/arrow.svg" class="icon js-svg"></div>
		</div>
		<!-- block swiper-slider end -->

	</div>
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