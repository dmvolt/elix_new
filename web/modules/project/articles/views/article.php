<main class="main">
	<section class="main__section cont">
		<?= Breadcrumbs::get_breadcrumbs($article['id'], 'articles', false, $current_param_cat) ?>
		<article class="article">
			<?php if($article): ?>

				<?= $edit_interface ?>
				<div id="articles_content_<?= $article['id'] ?>"><?=$article['descriptions'][Data::_('lang_id')]['body'] ?></div>
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yasharel10n="ru" data-yasharetype="button" data-yasharequickservices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir" <="" p="">
					<p>&gt;</p>
				</div>
				<?//= Comments::get_block($article['id']) ?>
				
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
		</article>
	</section>
</main>