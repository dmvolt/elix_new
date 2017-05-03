<?php if($specials): ?>
	<h2><a href="/doctors"><?= $text_all_specials ?></a></h2>
	<div class="specialists-line">	
		<?php foreach($specials as $special): ?>
			<div class="specialist">
				<a href="<?= Data::_('lang_uri') . '/doctors/' . $special['alias'] ?>"><img src="/files/preview2/<?= $special['thumb'] ?>"></a>
				<p><a href="<?= Data::_('lang_uri') . '/doctors/' . $special['alias'] ?>"><?= $special['descriptions'][Data::_('lang_id')]['title'] ?></a></p>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>