<?php if(count($content)>0): ?>
	<?php foreach($content as $value): ?>
	<div class="feedback">
		<div class="feedback-signature"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?>, <?= $value['date'] ?></div>
		<div class="feedback-content"><?= $value['descriptions'][Data::_('lang_id')]['body'] ?></div>
	</div>
	<?php endforeach; ?>
	<a href="/reviews" class="more">Остальные отзывы</a>
<?php endif; ?>