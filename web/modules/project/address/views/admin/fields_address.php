<div class="tab_wrap">
	<h2 class="title"><?= $text_address ?></h2>
	<div class="form_item">			
		<?php if(isset($languages)): ?>
			<?php foreach ($languages as $item): ?>
				<label class="lang_img_<?= $item['lang_id']?>"><?= $text_address_phone ?> </label><?= $item['icon']?><textarea name="address_data[<?= $item['lang_id']?>][text1]" class="textarea_lang_<?= $item['lang_id']?>"><?= $field[$item['lang_id']]['text1'] ?></textarea>
			<?php endforeach; ?>
		<?php else: ?>
			<label><?= $text_address_phone ?></label><textarea name="address_data[1][text1]" class="lang_editor" id="editor3"><?= $field[1]['text1'] ?></textarea>
		<?php endif; ?>
	</div>
	<br>
	<div class="form_item">			
		<?php if(isset($languages)): ?>
			<?php foreach ($languages as $item): ?>
				<label class="lang_img_<?= $item['lang_id']?>"><?= $text_address_address ?> </label><?= $item['icon']?><textarea name="address_data[<?= $item['lang_id']?>][text2]" class="textarea_lang_<?= $item['lang_id']?>"><?= $field[$item['lang_id']]['text2'] ?></textarea>
			<?php endforeach; ?>
		<?php else: ?>
			<label><?= $text_address_address ?></label><textarea name="address_data[1][text2]" class="lang_editor" id="editor4"><?= $field[1]['text2'] ?></textarea>
		<?php endif; ?>
	</div>
</div>