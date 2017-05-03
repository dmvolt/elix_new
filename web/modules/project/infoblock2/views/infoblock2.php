<?php if($contents): ?>
	<div class="price-parallax__girl-mobile">
		<img src="<?= PARENT_FULLURL ?>/images/<?= $main_bg_mobile ?>" alt="">
		<?php foreach($contents as $block): ?>
			<div style="left: <?= $block['pos_x']?>; top:<?= $block['pos_y']?>;" class="price-parallax__item <?= $layers[$block['type']]['class']?>">
				<div class="price-parallax__header"><?= $block['title']?></div>
				<div class="price-parallax__val"><?= $block['info']?> <span class="rub">Р</span></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if($contents): ?>
	<div class="price-parallax__girl js-parallax">
		<img src="<?= PARENT_FULLURL ?>/images/<?= $main_bg ?>" alt="">
		<?php foreach($contents as $block): ?>
			<div style="left: <?= $block['pos_x']?>; top:<?= $block['pos_y']?>;" <?= $layers[$block['type']]['depth']?> class="price-parallax__item <?= $layers[$block['type']]['class']?>">
				<div class="price-parallax__header"><?= $block['title']?></div>
				<div class="price-parallax__val"><?= $block['info']?> <span class="rub">Р</span></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
