<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<? if (isset($mess)) { ?>
    <h2 class="title"><?= $mess ?></h2>
<? } ?>

<div>
    <h2 class="title"><?= $text_add_new_cat ?></h2>
    <form method="post" action="" id="form_add_cat">
        <?php if (isset($group_cat)): ?>
            <div class="form_item">
                <label for="dictionary_id"><?= $text_group_cat ?></label></br>
                <select name="dictionary_id" style="width:200px;">
                    <?php foreach ($group_cat as $group): ?>
                        <option value="<?= $group['dictionary_id'] ?>"><?= $group['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="form_item">
            <label for="parent_id"><?= $text_parent_cat ?></label></br>
            <select name="parent_id" style="width:200px;">
                <option value="0"><?= $text_main ?></option>
                <?php
                $tree = new Tree();
                foreach ($group_cat as $group):
                    ?>
                    <?php $tree->selectOutTree($group['dictionary_id'], 0, 1); //Выводим дерево в элемент выбора ?>
                <?php endforeach; ?>
            </select>
        </div>	
        <div class="form_item">
            <label for="name"><?= $text_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][title]" value='<?= $post['descriptions'][$item['lang_id']]['title'] ?>' class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][title]" value='<?= $post['descriptions'][1]['title'] ?>' class="text">
			<?php endif; ?>
        </div>	
        <div class="form_item">
            <label for="alias"><?= $text_alias ?></label></br>
            <input id="alias" type="text" name="alias" class="text" value="<?= $post['alias'] ?>"></br>
            <input type="checkbox" id="autoalias" checked="checked"><label for="autoalias"><?= $text_auto_zapolnenie ?></label>
        </div>	
        <div class="form_item">
            <label for="weight"><?= $text_weight ?></label></br>
            <input type="text" name="weight" class="short" value="0">
        </div>

        <div class="form_item" style="top:32px;">
            <a onclick="$('#form_add_cat').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_create ?></span></a>
        </div>
    </form>
</div>

<div>
    <?php foreach ($group_cat as $key => $group): ?>
    <?php if ($group['isgroup']): ?>
            <h2 class="title"><?= $group['name'] ?></h2>
            <form method="post" action="/admin/multiaction/update" id="multiaction_form_<?= $key ?>">
                <table>
                    <thead>
                        <tr>
                            <!--<td><strong>id</strong></td>-->
                            <td><strong><?= $text_cat_thead_name ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                            <td><strong><?= $text_cat_thead_alias ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                            <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#multiaction_form_<?= $key ?>').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                            <td class="last"><strong><?= $text_cat_thead_action ?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tree->tableOutTree($group['dictionary_id'], 0, 1); //Выводим дерево в таблицу   ?>
                    </tbody>
                </table>
                <input type="hidden" name="module" value="categories">
            </form>
        <?php endif; ?>
<?php endforeach; ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(generatealias);
	$('[id^="name"]').keyup(generatealias);
});
</script>