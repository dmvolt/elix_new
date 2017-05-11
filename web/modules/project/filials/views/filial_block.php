<div id="popup-city" class="city-popup mfp-with-anim mfp-hide text-center">
	<h2>Выбор города</h2>
	<?php foreach($redirect_data as $key => $item): ?>
		<h3><a href="/filials/index?filial=<?= $key ?>" <?php if($filial == $key): ?>class="active"<?php endif; ?>><?= $item['name'] ?></a></h3>
	<?php endforeach; ?>
</div>