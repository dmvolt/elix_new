<?php if($tags): ?>
	<div class="front-tags">
		<canvas width="400" height="300" id="myCanvas">
			<ul>
				<?php foreach($tags as $item): ?>
					<li><a href="/articles?tag=<?= $item['alias'] ?>"><?= $item['name'] ?></a></li>
				<?php endforeach; ?>
			</ul>
		</canvas>
	</div>
<?php endif; ?>
