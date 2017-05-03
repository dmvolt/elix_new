<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div>
    <h2 class="title"><?= $text_edit_menu ?></h2>
    <form method="post" action="" id="form1">

        <?php if (isset($group_menu)): ?>
            <div class="form_item">
                <label for="dictionary_id"><?= $text_group_menu ?></label><br>
                <select name="dictionary_id">
                    <?php foreach ($group_menu as $group): ?>
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
            <label for="parent_id"><?= $text_parent_menu ?></label></br>
            <select name="parent_id">
                <option value="0"> -------- </option>
                <?php $tree = new Tree();
                $tree->selectOutMenuTree($dictionary, 0, 1, $parent = (isset($parent)) ? $parent : 0); //Выводим дерево в элемент выбора 
                ?>
            </select>
        </div>	
        <br>
        <br>
        <div class="form_item">	
            <label for="name"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value='<?= $menu['descriptions'][$item['lang_id']]['title'] ?>' class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value='<?= $menu['descriptions'][1]['title'] ?>' class="text">
			<?php endif; ?>
        </div>

        <div class="form_item">
            <label for="url"><?= $text_menu_url ?></label></br>
            <input type="text" name="url" value="<?= $menu['url'] ?>" class="text">
        </div>	

        <div class="form_item">	
            <label for="weight"><?= $text_weight ?></label></br>
            <input type="text" name="weight" value="<?= $menu['weight'] ?>" class="text">
        </div>
        <br>
        <br>
        <div class="form_item">	
            <label for="status"><?= $text_menu_status ?></label>
            <?php if($menu['status']): ?>
                <input type="checkbox" name="status" checked value="1">
            <?php else: ?>
                <input type="checkbox" name="status" value="1">
            <?php endif; ?>
        </div>

    </form>

    <div class="form_item" style="top:25px">	
        <a onclick="$('#form1').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>	

</div>