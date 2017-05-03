<main class="main main_col">
	<section class="main_col__wide">
		<?= Breadcrumbs::get_breadcrumbs(0, 'faq', false, $current_param_cat) ?>
	</section>
	<aside class="main_col__right main_col__right_1200">
		<?php  if($modulinfo AND !empty($modulinfo)): ?>
			<article>
				<?= $modulinfo[0]['descriptions'][Data::_('lang_id')]['body'] ?>
			</article>
		<?php endif; ?>
		
		<div class="sticker">
			<form class="form" method="post" id="faq_form">
				<h2 class="form__header">Задайте вопрос</h2>
				<div class="form__group">
					<label for="name">Ваше имя</label>
					<input type="text" name="name" id="faq_form_name" placeholder="Ваше имя">
				</div>
				<div class="form__group">
					<label for="email">E-mail</label>
					<input type="email" name="email" id="faq_form_email" placeholder="E-mail">
				</div>
				<div class="form__group">
					<label for="text">Ваш вопрос</label>
					<textarea name="text" id="faq_form_text" placeholder="Ваш вопрос"></textarea>
				</div>
				<div class="form__group form__group_submit">
					<button type="submit">Отправить вопрос <img src="<?= PARENT_FULLURL ?>/images/admin/loader.gif" width="32" height="32" class="loading" style="display:none;"></button>
				</div>
				<input type="hidden" name="cat" value="<?= $current_param_cat ?>">
				<div id="faq_form_thanks"></div>
			</form>
		</div>
	</aside>
	<section class="main_col__wide">
		<div class="qna">
			<?php if($faq): ?>
				<?php foreach($faq as $article): ?>
					<div class="qna__entry">
						<div class="qna__question">
							<h2 class="qna__header"><?//= $article['descriptions'][Data::_('lang_id')]['title'] ?><?//= $article['date'] ?>Вопрос:</h2>
							<div class="qna__text">
								<p><?= $article['descriptions'][Data::_('lang_id')]['body'] ?></p>
								<em><?= $article['descriptions'][Data::_('lang_id')]['title'] ?></em>
							</div>
						</div>
						<?php if($article['answer']): ?>	
							<?php foreach($article['answer'] as $answer): ?>
								<div class="qna__answer">
									<h2 class="qna__header">Ответ:</h2>
									<div class="qna__text">
										<p><?= $answer['descriptions'][Data::_('lang_id')]['body'] ?></p>
										<em><?= $answer['descriptions'][Data::_('lang_id')]['title'] ?></em>
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
	</section>
</main>