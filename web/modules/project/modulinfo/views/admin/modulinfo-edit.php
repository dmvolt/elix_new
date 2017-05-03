<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_edit_content ?> - <?= $content['module'] ?></h2>
<form action="" method="post" name="form1" id="page_edit">
	
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">SEO</a></li>
		<li><a href="#tabs-4">Регион</a></li>
		<li><a href="#tabs-3">Иллюстрации и файлы</a></li>
	</ul>
	
	<div id="tabs-1">
		<div class="form_item_textarea">			
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_body ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="body"><?= $text_body ?></label><textarea name="descriptions[1][body]" class="lang_editor" id="editor2"><?= $content['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
		</div>
	</div>
	
	<div id="tabs-2">
		<?= $seo_form ?>
	</div>
	
	<div id="tabs-4">
		<?= $categories_form ?>
	</div>
	
	<div id="tabs-3">
			<h2 class="title"><?= $text_file_illustration ?></h2>
			<div class="images_content" id="sortable"></div>
		</form>
		
		<!--<h2 class="title"><?//= $text_file_files ?></h2>
		<div class="files_content"></div>-->
		
		<?= $files_form ?>
	</div>
</div>
<div class="form_item" style="top:35px">
	<a onclick="$('#page_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>