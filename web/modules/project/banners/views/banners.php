<?php if(!empty($banners_data)): ?>	
	<div class="swiper-slider">
		<div class="swiper-container js-slider">
			<div class="swiper-wrapper">
				<?php foreach($banners_data[0]['files'] as $file): ?>	
					<?php if(!empty($file['description'][Data::_('lang_id')]['link'])): ?>
						<a href="<?= $file['description'][Data::_('lang_id')]['link'] ?>" class="swiper-slide"><img src="<?= Im::imagepath('top', $file['file']->filepathname) ?>" alt="" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>"></a>		
					<?php else: ?>
						<div class="swiper-slide"><img src="<?= Im::imagepath('top', $file['file']->filepathname) ?>" alt="" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>"></div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="swiper-slider__pagination"></div>
		</div>
	</div>
<?php endif; ?>