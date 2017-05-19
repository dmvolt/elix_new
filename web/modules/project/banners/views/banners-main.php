<?php if(!empty($banners_data)): ?>	
	<?php foreach($banners_data[0]['files'] as $file): ?>	
		
		<?php if(!empty($file['description'][Data::_('lang_id')]['link'])): ?>
			<div class="pic">
				<a href="<?= $file['description'][Data::_('lang_id')]['link'] ?>"><img src="<?= Im::imagepath('3000x400', $file['file']->filepathname) ?>" class="pic__img"></a>
			</div>
		<?php else: ?>
			<div class="pic">
				<img src="<?= Im::imagepath('3000x400', $file['file']->filepathname) ?>" alt="" title="" class="pic__img">
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>