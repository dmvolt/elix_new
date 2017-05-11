<?php if($specials): ?>
	<h2><a href="/doctors"><?= $text_all_specials ?></a></h2>
	<!-- block swiper-carousel start -->
	<div class="swiper swiper--carousel">
		<div class="swiper-container js-swiper-carousel">
			<div class="swiper-wrapper">
				<?php foreach($specials as $special): ?>
				
					<div class="swiper-slide">
						<!-- block person start -->
						<div class="photo">
							<?php if($special['thumb']): ?>
								<a href="<?= Data::_('lang_uri') . '/doctors/' . $special['alias'] ?>" class="photo__figure"><img src="<?= Im::imagepath('250x200', $special['thumb']) ?>"></a>
							<?php endif; ?>
							<div class="photo__name"><?= $special['descriptions'][Data::_('lang_id')]['title'] ?></div>
							<div class="photo__info text-small"><?= $special['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
						</div>
						<!-- block person end -->
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="swiper-button-prev js-slider-prev"><img src="<?= PARENT_FULLURL ?>/images/arrow.svg" class="icon js-svg"></div>
		<div class="swiper-button-next js-slider-next"><img src="<?= PARENT_FULLURL ?>/images/arrow.svg" class="icon js-svg"></div>
	</div>
	<!-- block swiper-slider end -->
<?php endif; ?>