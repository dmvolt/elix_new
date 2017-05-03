<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_partners ?> <a href="/admin/partners/add" title="<?= $text_add_new_partners ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

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
    <form method="post" action="/admin/multiaction/update" id="multiaction_form">
        <table>
            <thead>
                <tr>
					<!--<td><input type='checkbox' onclick="$('input[name*=\'multidelete\']').prop('checked', this.checked);"><strong><?//= $text_thead_select_all ?></strong><br><a onclick="multiDelete();" class="btn_core btn_core_blue btn_core_sm"><span><?//= $text_delete ?></span></a></td>-->
                    <td><strong><?= $text_partners_thead_name ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
					<!--<td><strong><?//= $text_partners_thead_link ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?//= $text_save ?></span></a></td>
                    <td><strong><?//= $text_partners_thead_map_x ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?//= $text_save ?></span></a></td>
					<td><strong><?//= $text_partners_thead_map_y ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?//= $text_save ?></span></a></td>-->
                    <td class="last"><strong><?= $text_partners_thead_status ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_partners_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $key => $value): ?>
                    <tr>
						<!--<td class="first"><input type="checkbox" name="multidelete[]" value="<?//= $value['id'] ?>"></td>-->
                        <td class="first">
						<?php if(isset($languages)): ?>
							<?php foreach ($languages as $item): ?>
								<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value['id'] ?>][<?= $item['lang_id']?>][title]" value="<?= htmlspecialchars($value['descriptions'][$item['lang_id']]['title']) ?>" class="text"><?= $item['icon']?>
							<?php endforeach; ?>
						<?php else: ?>
							<input type="text" name="descriptions[<?= $value['id'] ?>][1][title]" value="<?= htmlspecialchars($value['descriptions'][1]['title']) ?>" class="text">
						<?php endif; ?>
						</td>
						<!--<td><input type="text" name="link[<?//= $value['id'] ?>]" class="text" value="<?//= $value['link'] ?>"></td>
                        <td><input type="text" name="map_x[<?//= $value['id'] ?>]" class="short" value="<?//= $value['map_x'] ?>"></td>
						<td><input type="text" name="map_y[<?//= $value['id'] ?>]" class="short" value="<?//= $value['map_y'] ?>"></td>-->
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
                        <td class="last"><input type="text" name="weight[<?= $value['id'] ?>]" class="text short" value="<?= $value['weight'] ?>"></td>
                        <td class="last"><a href="/admin/partners/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/partners/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>		
        </table>
        <input type="hidden" name="module" value="partners" />
    </form>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>