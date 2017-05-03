<?php if($infoblocks AND count($infoblocks)>0): ?>
	<!--<div class="narrow clearfix">-->
		<?php foreach($infoblocks as $key => $block): ?>
			<?= $block['edit_interface'] ?>
			<div id="infoblock_teaser_<?= $block['id'] ?>"><?= $block['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
		<?php endforeach; ?>
	<!--</div>-->
<?php endif; ?>