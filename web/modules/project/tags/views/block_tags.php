<?php if(count($content)>0): ?>
	<div class="tags">
		<h2>Теги статьи:</h2>
		<?php foreach ($content as $key => $item): ?>
			<a href="/articles?tag=<?= $item['alias'] ?>"><?= $item['name'] ?></a><?php if($key < (count($content)-1)): ?>, <?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>