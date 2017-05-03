<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs(0, 'reviews', false, $current_param_cat) ?>
	</section>
	<aside class="main_col__right main_col__right_1200">
		<div class="sticker">
			<form class="form" id="reviews_form" method="post">
				<h2 class="form__header">Оставте ваш отзыв</h2>
				<div class="form__group">
					<label for="name">Ваше имя</label>
					<input id="reviews_form_name" type="text" name="name" placeholder="Ваше имя"/>
				</div>
				<div class="form__group">
					<label for="text">Ваш отзыв</label>
					<textarea id="reviews_form_text" name="text" placeholder="Ваш отзыв"></textarea>
				</div>
				<div class="form__group form__group_submit">
					<button type="submit">Отправить отзыв <img src="<?= PARENT_FULLURL ?>/images/admin/loader.gif" width="32" height="32" class="loading" style="display:none;" /></button>
				</div>
				<div id="reviews_form_thanks"></div>
			</form>
		</div>
	</aside>
	<section class="main_col__wide">
		<div class="feedback">
			<?php if($reviews): ?>
				<?php foreach($reviews as $article): ?>
					<div class="feedback__entry">
						<h2 class="feedback__header"><?= $article['descriptions'][Data::_('lang_id')]['title'] ?>, <?= $article['date'] ?></h2>
						<div class="feedback__text">
							<?= $article['descriptions'][Data::_('lang_id')]['body'] ?>
						</div>
					
						<?php if($article['answer']): ?>	
							<?php foreach($article['answer'] as $answer): ?>
								<div class="reply">
									<div class="reply-content">
										<p><?= $answer['descriptions'][Data::_('lang_id')]['body'] ?></p>
									</div>
								</div>
							<?php endforeach; ?> 
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php else: ?>	
				<h2><?= $text_page_not_found ?></h2>  
			<?php endif; ?>
		</div>
		
		<?php  if($modulinfo AND !empty($modulinfo)): ?>
			<article>
				<?= $modulinfo[0]['descriptions'][Data::_('lang_id')]['body'] ?>
			</article>
		<?php endif; ?>
	</section>
</main>