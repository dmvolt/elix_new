<?php if (!empty($filesdata)): ?>
	<?php if ($module == 'banners'): ?>
		<span class="description">Для изменения сортировки перетащите блок в нужное место. Изменения сохраняются автоматически.</span>
		<?php foreach ($filesdata as $file): ?>
			<div class="form_item_file_photo" id="<?= $file['file']->id ?>">
			<span class="form_item_file_delete" title="Удалить" ONCLICK="deletefile(<?= $file['file']->id ?>);"></span>
			
				<div class="form_item" style="width:250px; float:left;">
					<img src="/files/thumbnails/<?= $file['file']->filepathname ?>" />
				</div>
			
				<div class="form_item filename">
					<label>Наименование </label>
					<?php if(isset($languages) AND count($languages)>1): ?>
						<?php foreach ($languages as $item): ?>
							<?= $item['icon'] ?><br><input type="text" id="name_input_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][title]" value="<?= $file['description'][$item['lang_id']]['title'] ?>" class="text">
						<?php endforeach; ?>
					<?php else: ?>
						<br><input type="text" id="name" name="file_descriptions[<?= $file['file']->id ?>][1][title]" value="<?= $file['description'][1]['title'] ?>" class="text">
					<?php endif; ?>
				</div>
			
				<div class="form_item filedescription">
					<?php if(isset($languages) AND count($languages)>1): ?>
						<?php foreach ($languages as $item): ?>
							<label class="lang_img_<?= $item['lang_id'] ?>">Описание </label><?= $item['icon'] ?><br class="lang_img_<?= $item['lang_id'] ?>"><textarea class="file_textarea_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][description]" style="width:500px; height:40px;"><?= $file['description'][$item['lang_id']]['description'] ?></textarea>
						<?php endforeach; ?>
					<?php else: ?>
						<label>Описание </label><br><textarea name="file_descriptions[<?= $file['file']->id ?>][1][description]" style="width:500px; height:40px;"><?= $file['description'][1]['description'] ?></textarea>
					<?php endif; ?>
				</div>
			
				<div class="form_item filelink">
					<label>Ссылка </label>
					<?php if(isset($languages) AND count($languages)>1): ?>
						<?php foreach ($languages as $item): ?>
							<?= $item['icon'] ?><br><input type="text" id="link_input_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][link]" value="<?= $file['description'][$item['lang_id']]['link'] ?>" class="text" style="width:500px;">
						<?php endforeach; ?>
					<?php else: ?>
						<br><input type="text" id="link" name="file_descriptions[<?= $file['file']->id ?>][1][link]" value="<?= $file['description'][1]['link'] ?>" class="text" style="width:500px;">
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php elseif ($module == 'actions' OR $module == 'reviews' OR $module == 'categories' OR $module == 'news' OR $module == 'autos' OR $module == 'infoblock'): ?>
		<span class="description">Для изменения сортировки перетащите блок в нужное место. Изменения сохраняются автоматически.</span>
		<?php foreach ($filesdata as $file): ?>
			<div class="form_item_file_photo" id="<?= $file['file']->id ?>" style="min-height:100px;">
			<span class="form_item_file_delete" title="Удалить" ONCLICK="deletefile(<?= $file['file']->id ?>);"></span>
			
				<div class="form_item" style="width:250px; float:left;">
					<img src="/files/thumbnails/<?= $file['file']->filepathname ?>" />
				</div>
			
				<div class="form_item filename">
					<label>Title </label>
					<?php if(isset($languages) AND count($languages)>1): ?>
						<?php foreach ($languages as $item): ?>
							<?= $item['icon'] ?><br><input type="text" id="name_input_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][title]" value="<?= $file['description'][$item['lang_id']]['title'] ?>" class="text">
						<?php endforeach; ?>
					<?php else: ?>
						<br><input type="text" id="name" name="file_descriptions[<?= $file['file']->id ?>][1][title]" value="<?= $file['description'][1]['title'] ?>" class="text">
					<?php endif; ?>
				</div>
			
				<div class="form_item filelink">
					<label>Alt </label>
					<?php if(isset($languages) AND count($languages)>1): ?>
						<?php foreach ($languages as $item): ?>
							<?= $item['icon'] ?><br><input type="text" id="link_input_lang_<?= $item['lang_id'] ?>" name="file_descriptions[<?= $file['file']->id ?>][<?= $item['lang_id'] ?>][link]" value="<?= $file['description'][$item['lang_id']]['link'] ?>" class="text" style="width:300px;">
						<?php endforeach; ?>
					<?php else: ?>
						<br><input type="text" id="link" name="file_descriptions[<?= $file['file']->id ?>][1][link]" value="<?= $file['description'][1]['link'] ?>" class="text" style="width:300px;">
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<span class="description">Для изменения сортировки перетащите картинку в нужное место. Изменения сохраняются автоматически.</span>	
		<?php foreach ($filesdata as $file): ?>
			<div class="form_item_file" id="<?= $file['file']->id ?>">
				<span class="form_item_file_delete" title="Удалить" ONCLICK="deletefile(<?= $file['file']->id ?>); "></span>
				<img src="/files/thumbnails/<?= $file['file']->filepathname ?>" />
			</div>
		<?php endforeach; ?>
	<?php endif;?> 
<?php endif;?>