<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_edit_cat ?></h2>
<form method="post" action="" id="form1">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">SEO</a></li>
		<?php if(!$cat['parent_id'] AND $dictionary == 2): ?>
			<li><a href="#tabs-4">Адреса и телефоны</a></li>
		<?php endif; ?>
		<li><a href="#tabs-3">Иллюстрации</a></li>
	</ul>
	
	<div id="tabs-1">
        <?php if (isset($group_cat)): ?>
            <div class="form_item">
                <label for="dictionary_id"><?= $text_group_cat ?></label></br>
                <select name="dictionary_id">
                    <?php foreach ($group_cat as $group): ?>
                        <?php if ($group['dictionary_id'] == $dictionary): ?>
                            <option value="<?= $group['dictionary_id'] ?>" selected="selected"><?= $group['name'] ?></option>
                        <?php else: ?>
                            <option value="<?= $group['dictionary_id'] ?>"><?= $group['name'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="form_item">
            <label for="parent_id"><?= $text_parent_cat ?></label></br>
            <select name="parent_id">
                <option value="0"><?= $text_main ?></option>
                <?php $tree = new tree();
                $tree->selectouttree($dictionary, 0, 1, $parent = (isset($parent)) ? $parent : 0); //выводим дерево в элемент выбора 
                ?>
            </select>
        </div>	

        <div class="form_item">	
            <label for="name"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value='<?= $cat['descriptions'][$item['lang_id']]['title'] ?>' class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value='<?= $cat['descriptions'][1]['title'] ?>' class="text">
			<?php endif; ?>
        </div>

        <div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="body" class="lang_img_<?= $item['lang_id']?>"><?= $text_cat_body ?> </label><?= $item['icon']?><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?= $cat['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="body"><?= $text_cat_body ?></label><textarea name="descriptions[1][body]" class="lang_editor"><?= $cat['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
        </div>	

        <div class="form_item">
            <label for="alias"><?= $text_alias ?></label></br>
            <input id="alias" type="text" name="alias" value="<?= $cat['alias'] ?>" class="text"></br>
            <input type="checkbox" id="autoalias"><label for="autoalias"><?= $text_auto_zapolnenie ?></label>
        </div>	

        <div class="form_item">	
            <label for="alias"><?= $text_weight ?></label></br>
            <input type="text" name="weight" value="<?= $cat['weight'] ?>" class="text">
        </div>
	</div>
	
	<div id="tabs-2">
		<?= $seo_form ?>
	</div>
	
	<?php if(!$cat['parent_id'] AND $dictionary == 2): ?>
		<div id="tabs-4">
			<?= $address_form ?>
		</div>
	<?php endif; ?>
	
	<div id="tabs-3">
		<h2 class="title"><?= $text_file_illustration ?></h2>
		<div class="images_content" id="sortable"></div>

		</form>
		
		<?= $files_form ?>
	</div>
</div>
<br>
<div class="form_item">	
	<a onclick="$('#form1').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>	

<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(generatealias);
	$('[id^="name"]').keyup(generatealias);
});
</script>