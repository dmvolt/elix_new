<main class="main main_col">
	<section class="main_col__wide">
	
		<?= Breadcrumbs::get_breadcrumbs(0, 'services', $cat2, $current_param_cat) ?>
		
		<article class="article">
			<?php  if($category_info2): ?>
				<?= $category_info2[0]['descriptions'][1]['body'] ?>
			<?php else: ?>
				<?= $category_info1[0]['descriptions'][1]['body'] ?>
			<?php endif; ?>
		</article>
		
		<?php  if($child_categories AND !$category_info2): ?>
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
								<a href="/<?= $cat ?>/services/<?= $value['alias'] ?>" class="service__preview"><img src="<?= Im::imagepath('thumbnails', $value['thumb']) ?>"></a> <!-- 120 X 150 -->
							<?php endif; ?>
							<div class="service__text"><?= $value['descriptions'][1]['body'] ?></div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?> 
			</div>
		<?php  elseif($category_info2): ?>
			<?php if($services): ?>
				<h2 class="header-line">Услуги данной категории</h2>
				<div class="article">
					<ul class="service-list__ul">
						<?php foreach($services as $item): ?>
							<li><a href="/<?= $cat ?>/services/<?= $category_info2[0]['alias'] ?>/<?= $item['alias'] ?>"><?= $item['descriptions'][1]['title'] ?></a></li>
						<?php endforeach; ?> 
					</ul>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</section>
	<aside class="main_col__right hide-1200">
		<?= Banners::get_block($current_param_cat, 5) ?>
		<?= Articles::get_right_block($current_param_cat, 3) ?>
		<?//= Sertifications::get_right_block($current_param_cat, 1) ?>
		
		<div class="main_col__soc">
			<h2>Мы в соцсетях:</h2>
			<div class="flamp-widget">
				<a class="flamp-widget" href="http://novosibirsk.flamp.ru/firm/elix_centr_ehpilyacii-141266769558749"  data-flamp-widget-type="medium" data-flamp-widget-color="green" data-flamp-widget-id="141266769558749" data-flamp-widget-width="100%">Отзывы о нас на Флампе</a><script>!function(d,s){var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="http://widget.flamp.ru/loader.js";fjs.parentNode.insertBefore(js,fjs);}(document,"script");</script>
			</div>
			
			<!-- VK Widget --> 
			<?= Text::vk_widget() ?>
		</div>
	</aside>
</main>