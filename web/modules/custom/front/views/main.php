<main class="main main_col">
	<section class="main_col__wide">
		<div class="price-parallax clearfix">
		
			<?= Infoblock2::get_blocks($current_param_cat) ?>
			
			<div class="price-parallax__left">
				<?= Infoblock::infoblock_block(3, 2)?>
			</div>
			<div class="price-parallax__more"><a href="/price">Полный прайс-лист</a></div>
		</div>
	</section>
	<aside class="main_col__right">

		<?= Banners::get_block($current_param_cat, 5) ?>
		<?= Articles::get_right_block($current_param_cat, 6) ?>
		
		<div class="main_col__soc">
			<h2>Мы в соцсетях:</h2>
			<div class="flamp-widget">
				<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
			</div>
			<!-- VK Widget --> 
			<?= Text::vk_widget() ?>
		</div>
	</aside>
	<aside class="main_col__left">
		<?= Sertifications::get_right_block($current_param_cat, 1) ?>
	</aside>
	<section class="main_col__center">
		<?php if($child_categories): ?>
			<h1><?= $cat_title ?></h1>
			<div class="service">
				<?php foreach($child_categories as $value): ?>
					<?php if($value['services']): ?>
						<div class="service__item">
							<div class="service__header">
								<a href="/<?= $cat ?>/services/<?= $value['alias'] ?>"><?= $value['descriptions'][1]['title'] ?>
									<ul class="service__dropdown js-dropdown">
										<?php foreach($value['services'] as $item): ?>
											
											<li class="service__dropdown__li"><a href="/<?= $cat ?>/services/<?= $value['alias'] ?>/<?= $item['alias'] ?>"><?= $item['descriptions'][1]['title'] ?></a></li>
											
										<?php endforeach; ?> 
									</ul>
								</a>
							</div>
							<?php if($value['thumb']): ?>
								<a href="/<?= $cat ?>/services/<?= $value['alias'] ?>" class="service__preview"><img src="<?= Im::imagepath('preview', $value['thumb']) ?>"></a> <!-- 120 X 150 -->
							<?php endif; ?>
							<div class="service__text"><?= $value['descriptions'][1]['body'] ?></div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?> 
			</div>
		<?php endif; ?>
		
		<article class="main_col__article">
			<?= Categories::get_block($current_param_cat, 'body') ?>
		</article>
		
		<?php  if($current_param_cat == 'epil'): ?>
			<?= Photos::get_front_block('centr')?>
		<?php endif; ?>
	</section>
</main>