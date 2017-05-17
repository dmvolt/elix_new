<div class="flex">
	<div class="flex__item flex__item--66 flex__item--bp-720--100 main__center">
		<!-- block breadcrumbs start -->
		<?= Breadcrumbs::get_breadcrumbs(0, 'reviews') ?>
		<!-- block breadcrumbs end -->

		<h1><?= $page_title ?></h1>
		
		<?php if($reviews): ?>
			<?php foreach($reviews as $article): ?>
				<div class="flex feedback feedback--one">
				
					<div class="flex__item flex__item--50 flex__item--bp-720--100">
						<?= $article['descriptions'][Data::_('lang_id')]['body'] ?>
						<p class="feedback__name"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></p>
					</div>
				
					<?php if($article['answer']): ?>	
						<?php foreach($article['answer'] as $answer): ?>
							<div class="flex__item flex__item--50 flex__item--bp-720--100">
								<?= $answer['descriptions'][Data::_('lang_id')]['body'] ?>
								<p class="feedback__name"><?= $answer['descriptions'][Data::_('lang_id')]['title'] ?></p>
							</div>
						<?php endforeach; ?> 
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php else: ?>	
			<h2><?= $text_page_not_found ?></h2>  
		<?php endif; ?>
	</div>

	<aside class="flex__item flex__item--33 flex__item--bp-720--100 main__right">
	
		<form class="form pos-sticky pt-2e pl-2e pr-3e" id="reviews_form" method="post">
			<h2 class="header-main">Оставте ваш отзыв</h2>
			
			<div class="form__row required">
				<label for="name" class="form__label">Ваше имя</label>
				<input id="reviews_form_name" name="name" type="text">
			</div>
		
			<div class="form__row required">
				<label for="text" class="form__label">Ваш отзыв</label>
				<textarea id="reviews_form_text" name="text"></textarea>
			</div>
			
			<div class="form__row form__row--buttons">
				<button type="submit" class="button button--main js-ripple">Отправить отзыв <img src="<?= PARENT_FULLURL ?>/images/admin/loader.gif" width="32" height="32" class="loading" style="display:none;" /></button>
			</div>
			<div id="reviews_form_thanks"></div>
		</form>
	</aside>
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