<main class="main">
	<section class="main__section cont">
		<?= Breadcrumbs::get_breadcrumbs($actions['id'], 'actions', false, $current_param_cat) ?>
		<article class="article">
			<?php if($actions): ?>

				<?= $edit_interface ?>
				<div id="actions_content_<?= $actions['id'] ?>"><?=$actions['descriptions'][Data::_('lang_id')]['body'] ?></div>
				
			<?php else: ?>
				<h2><?= $text_page_not_found ?></h2>
			<?php endif; ?>
		</article>
	</section>
</main>