<?php if($sertifications): ?>
	<div class="front-cert-new">
		<a href="/sertifications" class="cert-main-new">Подарочный сертификат</a>
		<?php foreach($sertifications as $article): ?>
			<a href="/sertifications"><img src="/files/preview/<?= $article['thumb'] ?>" alt="" class="sertifications-front-img"></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>