<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_actions ?> <a href="/admin/actions/add<?= $parameters ?>" title="<?= $text_add_new_actions ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
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
			<?php if ($select_services): ?>
				<?php foreach ($select_services as $value):?>
					<option value="<?= $value['service']['id'] ?>"<?php if ($value['service']['id'] == Arr::get($_GET, 'cat2', null)): ?> selected<?php endif; ?>><?= $value['service']['descriptions'][1]['title'] ?></option>
					<?php if ($value['children']): ?>
						<?php foreach ($value['children'] as $value2):?>
							<option value="<?= $value2['service']['id'] ?>"<?php if ($value2['service']['id'] == Arr::get($_GET, 'cat2', null)): ?> selected<?php endif; ?>> - <?= $value2['service']['descriptions'][1]['title'] ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
        </select>
    </div>
	
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>
<div class="clear"></div>

<h2 class="title"><?= $cat_name ?></h2>

<?php if (isset($contents) AND count($contents) > 0): ?>
<?= $pagination ?>
    <form method="post" action="/admin/multiaction/update" id="multiaction_form">
        <table>
            <thead>
                <tr>
                    <td><strong><?= $text_actions_thead_name ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_actions_thead_status ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_actions_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $key => $value): ?>
                    <tr>
                        <td class="first">
						<?php if(isset($languages)): ?>
							<?php foreach ($languages as $item): ?>
								<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value['id'] ?>][<?= $item['lang_id']?>][title]" value='<?= $value['descriptions'][$item['lang_id']]['title'] ?>' class="text"><?= $item['icon']?>
							<?php endforeach; ?>
						<?php else: ?>
							<input type="text" name="descriptions[<?= $value['id'] ?>][1][title]" value='<?= $value['descriptions'][1]['title'] ?>' class="text">
						<?php endif; ?>
						</td>
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
                        <td class="last"><a href="/admin/actions/edit/<?= $value['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/actions/delete/<?= $value['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>		
        </table>
		<input type="hidden" name="parameters" value="<?= $parameters ?>" />
        <input type="hidden" name="module" value="actions" />
    </form>
<?= $pagination2 ?>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>