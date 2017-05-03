<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_infoblock2 ?> <a href="/admin/infoblock2/add" title="<?= $text_add_new_infoblock2 ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="cat1">Город</label></br>
        <select name="cat1" style="width:200px;">
			<option value=""> -- Все -- </option>
            <?php
            $tree = new Tree();
            foreach ($group_cat as $group):
                ?>
                <?php if ($group['dictionary_id'] == 2): ?>
                    <?php $tree->selectOutTree($group['dictionary_id'], 0, 1, $parent1 = (isset($parent1)) ? $parent1 : ''); //Выводим дерево в элемент выбора ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
	
	<div class="form_item">
        <label for="cat2">Раздел</label></br>
        <select name="cat2" style="width:200px;">
			<option value=""> -- Все -- </option>
            <?php
            $tree = new Tree();
            foreach ($group_cat as $group):
                ?>
                <?php if ($group['dictionary_id'] == 1): ?>
                    <?php $tree->selectOutTree($group['dictionary_id'], 0, 1, $parent2 = (isset($parent2)) ? $parent2 : ''); //Выводим дерево в элемент выбора ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
	
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>
<div class="clear"></div>

<h2 class="title"><?= $cat_name ?></h2>

<?php if (isset($contents) AND count($contents) > 0): ?>
    <form method="post" action="/admin/infoblock2/update" id="infoblock2_form">
        <table>
            <thead>
                <tr>
					<td><strong><?= $text_infoblock2_thead_type ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td><strong><?= $text_infoblock2_thead_name ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td><strong><?= $text_infoblock2_info ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td><strong><?= $text_infoblock2_link1 ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td><strong><?= $text_infoblock2_link2 ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td><strong><?= $text_infoblock2_pos_x ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<td><strong><?= $text_infoblock2_pos_y ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_infoblock2_thead_status ?></strong><br><a onclick="$('#infoblock2_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_infoblock2_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
				<?php foreach ($contents as $key => $value): ?>
					<tr>
						<td><input type="text" name="type[<?= $value['id'] ?>]" class="short" value="<?= $value['type'] ?>"></td>
						<td class="first"><input type="text" name="title[<?= $value['id'] ?>]" class="text" value="<?= $value['title'] ?>"></td>
						<td class="first"><input type="text" name="info[<?= $value['id'] ?>]" class="text" value="<?= $value['info'] ?>"></td>
						<td class="first"><input type="text" name="link1[<?= $value['id'] ?>]" class="text" value="<?= $value['link1'] ?>"></td>
						<td class="first"><input type="text" name="link2[<?= $value['id'] ?>]" class="text" value="<?= $value['link2'] ?>"></td>
						<td class="first"><input type="text" name="pos_x[<?= $value['id'] ?>]" class="short" value="<?= $value['pos_x'] ?>"></td>
						<td class="first"><input type="text" name="pos_y[<?= $value['id'] ?>]" class="short" value="<?= $value['pos_y'] ?>"></td>
						<?php if ($value['status']): ?>
							<td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' checked value='1'></td>
						<?php else: ?>
							<td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' value='1'></td>
						<?php endif; ?>
						<input type='hidden' name='status[<?= $value['id'] ?>]' id="statusfield_<?= $value['id'] ?>" value=''>
						<script>
						$(document).ready(function(){
							checkboxStatus(<?= $value['id'] ?>);
						});
						</script>
						<td class="last"><a href="/admin/infoblock2/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/infoblock2/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
					</tr>
                <?php endforeach; ?>
            </tbody>		
        </table>
    </form>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>