<?php  if($contents['images']): ?>	
	<!--<h2><a href="<?//= Data::_('lang_uri') . '/photos/' . $contents['alias'] ?>"><?//= $contents['descriptions'][Data::_('lang_id')]['title'] ?></a></h2>-->
	<?php foreach($contents['images'] as $image): ?>
		<a href="<?= Im::imagepath('colorbox', $image['file']->filepathname) ?>" class="img-popup img-gal"><img src="<?= Im::imagepath('photos', $image['file']->filepathname) ?>" alt=""></a>
	<?php endforeach; ?> 
<?php endif; ?>