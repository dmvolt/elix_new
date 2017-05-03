<?= Breadcrumbs::get_breadcrumbs($article['id'], 'partners') ?>
<?php if($article): ?>
<article>	
	<?//= $article['map'] ?>
	<div class="address"><?= $article['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
	<?= $edit_interface ?>
	<div id="pages_content_<?= $article['id'] ?>" class="text"><?=$article['descriptions'][Data::_('lang_id')]['body'] ?></div>
	<?php if($article['images']): ?>
		<div id="slideshow">
			<div id="slidesContainer">
				<?php foreach($article['images'] as $file): ?>
					<div class="slide">
						<a href="/files/colorbox/<?= $file['file']->filepathname ?>" title="<?=$article['descriptions'][Data::_('lang_id')]['title'] ?>" class="colorbox" rel="gallery1"><img src="/files/preview/<?= $file['file']->filepathname ?>" alt="<?=$article['descriptions'][Data::_('lang_id')]['title'] ?>" title="<?=$article['descriptions'][Data::_('lang_id')]['title'] ?>"  class="" /></a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$(".colorbox").colorbox({rel:'gallery1'});	
		});
		</script>
	<?php endif; ?>
</article>		
<?php else: ?> 
<article>   
	<p class="answer"><?= $text_page_not_found ?></p> 
</article>	
<?php endif; ?>