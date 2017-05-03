<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_add_new_infoblock ?></h2>
<form action="" method="post" name="form1" id="page_add">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-3">Город</a></li>
		<li><a href="#tabs-2">Иллюстрации</a></li>
	</ul>
	
	<div id="tabs-1">
		<div class="form_item">
			<label for="title"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= $post['descriptions'][$item['lang_id']]['title'] ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= $post['descriptions'][1]['title'] ?>" class="text">
			<?php endif; ?>
		</div>
		
		<div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="teaser" class="lang_img_<?= $item['lang_id']?>"><?= $text_teaser ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][teaser]" class="textarea_lang_<?= $item['lang_id']?>"><?= $post['descriptions'][$item['lang_id']]['teaser'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="teaser"><?= $text_teaser ?></label><textarea name="descriptions[1][teaser]" class="lang_editor" id="editor1"><?= $post['descriptions'][1]['teaser'] ?></textarea>
			<?php endif; ?>
		</div>
		
		<div class="form_item">
			<label for="url">ID блока</label></br>
			<input type="text" name="url" class="text" value="">
		</div>
		<br>
		
		<div class="form_item">
			<label for="type">Тип блока</label></br>
			<input type="text" name="type" value="3" class="text"></br>
			<label>2 - блок на главной слева</br>3 - блок на странице</label>
		</div>
		<br>
		<br>
		<br>
		
		<div class="form_item">
			<label for="date">Ссылка</label></br>
			<input type="text" name="date" value="" class="text">
		</div>
		<br>
		
		<div class="form_item">
			<label for="weight"><?= $text_weight ?></label></br>
			<input type="text" name="weight" class="text" value="0">
		</div>
		<br>
		<div class="form_item">
			<input type="checkbox" id="status" name="status" checked="checked" value="1"><label for="status"><?= $text_infoblock_status ?></label>
		</div>
	</div>
	
	<div id="tabs-3">
		<?= $categories_form ?>
	</div>
	
	<div id="tabs-2">
			<h2 class="title"><?= $text_file_illustration ?></h2>
			<div class="images_content" id="sortable"></div>
		</form>
		
		<!--<h2 class="title"><?//= $text_file_files ?></h2>
		<div class="files_content"></div>-->
		
		<?= $files_form ?>
	</div>
</div>
<div class="form_item" style="top:35px">
	<a onclick="$('#page_add').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>