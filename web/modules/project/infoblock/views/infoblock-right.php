<?php if($infoblocks): ?>
	<section class="branches">
		<div id="car-before"></div>
		<div id="car-next"></div>
		<div id="carousel-horisontal">
			<?php foreach($infoblocks as $key => $block): ?>	
				<div class="branch clearfix">
					<?php if($block['thumb']): ?>
						<?php if(!empty($block['date'])): ?>
							<a href="<?= $block['date'] ?>" class="branch-image-link"><img src="/files/preview/<?= $block['thumb'] ?>" alt="" class="branch-image"></a>
						<?php else: ?>
							<div class="branch-image-link"><img src="/files/preview/<?= $block['thumb'] ?>" alt="" class="branch-image"></div>
						<?php endif; ?>
					<?php endif; ?>
					<div class="branch-contant">
						<?php if(!empty($block['date'])): ?>
							<h3><a href="<?= $block['date'] ?>"><?= $block['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
						<?php else: ?>
							<h3><?= $block['descriptions'][Data::_('lang_id')]['title'] ?></h3>
						<?php endif; ?>
						<p><?= $block['descriptions'][Data::_('lang_id')]['teaser'] ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>