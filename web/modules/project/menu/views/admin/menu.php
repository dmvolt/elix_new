<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<? if (isset($mess)) { ?>
    <h2 class="title"><?= $mess ?></h2>
<? } ?>

<div>
    <h2 class="title"><?= $text_add_new_menu ?></h2>
    <form method="post" action="" id="form_add_menu">

        <?php if (isset($group_menu)): ?>
            <div class="form_item">
                <label for="dictionary_id"><?= $text_group_menu ?></label><br>
                <select name="dictionary_id">
                    <?php foreach ($group_menu as $group): ?>
                        <option value="<?= $group['dictionary_id'] ?>"><?= $group['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="form_item">
            <label for="parent_id"><?= $text_parent_menu ?></label></br>
            <select name="parent_id">
                <option value="0"> --------- </option>
                <?php
                $tree = new Tree();
                foreach ($group_menu as $group):
                    ?>
                    <?php $tree->selectOutMenuTree($group['dictionary_id'], 0, 1); //Выводим дерево в элемент выбора ?>
                <?php endforeach; ?>
            </select>
        </div>	
        <div class="form_item">
            <label for="name"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value="<?= $post['descriptions'][$item['lang_id']]['title'] ?>" class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value="<?= $post['descriptions'][1]['title'] ?>" class="text">
			<?php endif; ?>
        </div>	
        <div class="form_item">
            <label for="url"><?= $text_menu_url ?></label><br>
            <input id="alias" type="text" name="url" class="text" value="<?= $post['url'] ?>">
        </div>	
        <div class="form_item">
            <label for="weight"><?= $text_weight ?></label><br>
            <input type="text" name="weight" class="short" value="0">
        </div>

        <div class="form_item" style="top:32px;">
            <a onclick="$('#form_add_menu').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_create ?></span></a>
        </div>

    </form>

</div>

<div>
	<?php foreach ($group_menu as $key => $group): ?>
		<?php if ($group['isgroup']): ?>
			<h2 class="title"><?= $group['name'] ?></h2>
			<form method="post" action="/admin/multiaction/update" id="multiaction_form_<?= $key ?>">
				<table>
					<thead>
						<tr>
							<!--<td><strong><?//= $text_menu_thead_icon ?></strong></td>-->
							<td><strong><?= $text_menu_thead_name ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
							<td><strong><?= $text_menu_thead_alias ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
							<td class="last"><strong><?= $text_status ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
							<td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
							<td class="last"><strong><?= $text_menu_thead_action ?></strong></td>
						</tr>
					</thead>
					<tbody>
						<?php $tree->tableOutMenuTree($group['dictionary_id'], 0, 1); //Выводим дерево в таблицу   ?>
					</tbody>
				</table>
				<input type="hidden" name="module" value="menu">
			</form>
		<?php endif; ?>
	<?php endforeach; ?>
</div>