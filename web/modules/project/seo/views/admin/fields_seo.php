<h2 class="title"><?= $text_seo ?></h2>

<div class="form_item">
	<label><?= $text_seo_title ?></label>
	<?php if(isset($languages)): ?>
		<?php foreach ($languages as $item): ?>
			<?= $item['icon']?><br><input type="text" id="metatitle_input_lang_<?= $item['lang_id']?>" name="seo_data[<?= $item['lang_id']?>][title]" value='<?= $field[$item['lang_id']]['title'] ?>' class="text" style="width:400px;">
		<?php endforeach; ?>
	<?php else: ?>
		<br><input type="text" name="seo_data[1][title]" value="<?= $field[1]['title'] ?>" class="text" style="width:400px;">
	<?php endif; ?>
</div>
<br>
<div class="form_item">			
	<?php if(isset($languages)): ?>
		<?php foreach ($languages as $item): ?>
			<label class="lang_img_<?= $item['lang_id']?>"><?= $text_seo_keywords ?> </label><?= $item['icon']?><textarea name="seo_data[<?= $item['lang_id']?>][meta_k]" class="seo_textarea_lang_<?= $item['lang_id']?> text" style="width:400px; height:150px; display:block"><?= $field[$item['lang_id']]['meta_k'] ?></textarea>
		<?php endforeach; ?>
	<?php else: ?>
		<label><?= $text_seo_keywords ?></label><textarea name="seo_data[1][meta_k]" style="width:400px; height:150px; display:block" class="text"><?= $field[1]['meta_k'] ?></textarea>
	<?php endif; ?>
</div>

<div class="form_item">			
	<?php if(isset($languages)): ?>
		<?php foreach ($languages as $item): ?>
			<label class="lang_img_<?= $item['lang_id']?>"><?= $text_seo_description ?> </label><?= $item['icon']?><textarea name="seo_data[<?= $item['lang_id']?>][meta_d]" class="seo_textarea_lang_<?= $item['lang_id']?> text" style="width:400px; height:150px; display:block"><?= $field[$item['lang_id']]['meta_d'] ?></textarea>
		<?php endforeach; ?>
	<?php else: ?>
		<label><?= $text_seo_description ?></label><textarea name="seo_data[1][meta_d]" style="width:400px; height:150px; display:block" class="text"><?= $field[1]['meta_d'] ?></textarea>
	<?php endif; ?>
</div>
