<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_edit_content ?> - <?= $content['descriptions'][1]['title'] ?></h2>
<form action="" method="post" name="form1" id="page_edit">
	
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">SEO</a></li>
		<li><a href="#tabs-4">Город и раздел</a></li>
		<li><a href="#tabs-3">Иллюстрации и файлы</a></li>
	</ul>
	
	<div id="tabs-1">
		<div class="form_item">
			<label for="title"><?= $text_name ?></label><?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($content['descriptions'][$item['lang_id']]['title']) ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= htmlspecialchars($content['descriptions'][1]['title']) ?>" class="text">
			<?php endif; ?>
		</div>
		
		<div class="form_item">
			<label for="email"><?= $text_email ?></label></br>
			<input type="text" name="email" class="text" value="<?= $content['email'] ?>">
		</div>
		<div class="form_item">
			<label for="phone"><?= $text_phone ?></label></br>
			<input type="text" name="phone" class="text" value="<?= $content['phone'] ?>">
		</div>
		
		<div class="form_item">
			<label for="link"><?= $text_link ?></label></br>
			<input type="text" name="link" class="text" value="<?= $content['link'] ?>">
		</div>
		
		<div class="form_item_textarea">
			<label for="map"><?= $text_map ?></label><textarea name="map" style="width:400px; height:150px; display:block" class="text"><?= $content['map'] ?></textarea>
		</div>
		
		<div class="form_item">
			<label for="map_x"><?= $text_map_x ?></label></br>
			<input type="text" name="map_x" class="text" value="<?= $content['map_x'] ?>">
		</div>
		
		<div class="form_item">
			<label for="map_y"><?= $text_map_y ?></label></br>
			<input type="text" name="map_y" class="text" value="<?= $content['map_y'] ?>">
		</div>
		
		<div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="teaser" class="lang_img_<?= $item['lang_id']?>">Адрес </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][teaser]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['teaser'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="teaser">Адрес</label><textarea name="descriptions[1][teaser]" class="lang_editor" id="editor2"><?= $content['descriptions'][1]['teaser'] ?></textarea>
			<?php endif; ?>
		</div>
		
		<div class="form_item_textarea">			
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_body ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $content['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="body"><?= $text_body ?></label><textarea name="descriptions[1][body]" class="lang_editor" id="editor1"><?= $content['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
		</div>
		
		<div class="form_item">
			<label for="alias"><?= $text_alias ?></label></br>
			<input id="alias" type="text" name="alias" value="<?= $content['alias'] ?>" class="text"></br>
			<input type="checkbox" id="autoalias"><label for="autoalias"><?= $text_auto_zapolnenie ?></label>
		</div>
		<div class="form_item">
			<label for="weight"><?= $text_weight ?></label></br>
			<input type="text" name="weight" value="<?= $content['weight'] ?>" class="text" value="0">
		</div>
		<div class="form_item" style="top:35px">
			<?php if ($content['status']): ?>
				<input type="checkbox" id="status" name="status" checked="checked" value="1">
			<?php else: ?>
				<input type="checkbox" id="status" name="status" value="1">
			<?php endif; ?>
			<label for="status"><?= $text_partners_status ?></label>
		</div>
	</div>
	
	<div id="tabs-2">
		<?= $seo_form ?>
	</div>
	
	<div id="tabs-4">
		<?= $categories_form2 ?>
		<?= $categories_form1 ?>
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
<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(generatealias);
	$('[id^="name"]').keyup(generatealias);
});
</script>