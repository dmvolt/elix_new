<?php if(!empty($banners_data)): ?>	
	<?php foreach($banners_data[0]['files'] as $file): ?>	
		
		<?php if(!empty($file['description'][Data::_('lang_id')]['link'])): ?>
			<a href="<?= $file['description'][Data::_('lang_id')]['link'] ?>" class="info__block">
				<!-- block pic start -->
				<div class="pic">
					<img src="<?= Im::imagepath('600x150', $file['file']->filepathname) ?>" alt="" title="<?= $file['description'][Data::_('lang_id')]['title'] ?>" class="pic__img">
				</div>
				<!-- block pic end -->
			</a>
		<?php else: ?>
			<a href="#" class="info__block">
				<!-- block pic start -->
				<div class="pic">
					<img src="<?= Im::imagepath('600x150', $file['file']->filepathname) ?>" alt="" title="" class="pic__img">
				</div>
				<!-- block pic end -->
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>