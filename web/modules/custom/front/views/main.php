<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<article class="article">
			<?= Categories::get_block($current_param_cat, 'body') ?>
		</article>
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
		<?= Specials::specials_block() ?>
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
	</aside>
</div>

<?//= Articles::get_right_block($current_param_cat, 6) ?>

<!--<?php //if($child_categories): ?>
	<h1><?//= $cat_title ?></h1>
	<div class="service">
		<?php //foreach($child_categories as $value): ?>
			<?php //if($value['services']): ?>
				<div class="service__item">
					<div class="service__header">
						<a href="/<?//= $cat ?>/services/<?//= $value['alias'] ?>"><?//= $value['descriptions'][1]['title'] ?>
							<ul class="service__dropdown js-dropdown">
								<?php //foreach($value['services'] as $item): ?>
									
									<li class="service__dropdown__li"><a href="/<?//= $cat ?>/services/<?//= $value['alias'] ?>/<?//= $item['alias'] ?>"><?//= $item['descriptions'][1]['title'] ?></a></li>
									
								<?php //endforeach; ?> 
							</ul>
						</a>
					</div>
					<?php //if($value['thumb']): ?>
						<a href="/<?//= $cat ?>/services/<?//= $value['alias'] ?>" class="service__preview"><img src="<?//= Im::imagepath('preview', $value['thumb']) ?>"></a>
					<?php //endif; ?>
					<div class="service__text"><?//= $value['descriptions'][1]['body'] ?></div>
				</div>
			<?php //endif; ?>
		<?php //endforeach; ?> 
	</div>
<?php //endif; ?>-->

<?//= Sertifications::get_right_block($current_param_cat, 1) ?>		
<?php //if($current_param_cat == 'epil'): ?>
	<?//= Photos::get_front_block('centr')?>
<?php //endif; ?>