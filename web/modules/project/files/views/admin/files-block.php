<?php if (!empty($filesdata)): ?>
	<?php foreach ($filesdata as $file): ?>
		<div class="form_item_file_photo" id="<?= $file['file']->id ?>">
		
			<div class="form_item" style="width:300px; float:left;">
				<span class="form_item_file_delete" title="Удалить" ONCLICK="deletefile(<?= $file['file']->id ?>); "></span>
				<a href="/files/files/<?= $file['file']->filepathname ?>"><?= $file['file']->filepathname ?></a>
			</div>
			
			<div class="form_item filename">
				<label>Наименование файла</label>
				<?php if(isset($languages) AND count($languages)>1): ?>
					<?php foreach ($languages as $item): ?>
						<?= $item['icon'] ?><br><input type="text" id="name_input_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][title]" value="<?= $file['description'][$item['lang_id']]['title'] ?>" class="text">
					<?php endforeach; ?>
				<?php else: ?>
					<br><input type="text" id="name" name="file_descriptions[<?= $file['file']->id ?>][1][title]" value="<?= $file['description'][1]['title'] ?>" class="text">
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif;?>