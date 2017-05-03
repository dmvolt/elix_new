<?php if($contents): ?>
	<div class="main_col__cert">
		<h2><a href="/sertifications">Подарочный сертификат</a></h2>
		<?php foreach($contents as $value): ?>
			<a href="/sertifications"><img src="<?= Im::imagepath('preview3', $value['thumb']) ?>" alt=""></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>