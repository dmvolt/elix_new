<?php if($languages): ?>
	<section id="block-locale-0" class="block block-locale clearfix">
	<ul>
	<?php foreach ($languages as $lang_ident => $item): ?>
		<li class=""><a class="lang" href="<?= Request::detect_uri_with_langpart($lang_ident) ?>" <?php if(Data::_('lang_id') == $item['lang_id']) echo 'class="active"'; ?> title="<?= $item['name']?>"><?= $item['icon']?></a></li>
	<?php endforeach; ?>
	</ul>
	</section>
<?php endif; ?>