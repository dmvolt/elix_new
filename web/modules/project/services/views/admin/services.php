<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>
<h2 class="title"><?= $text_services ?> <a href="/admin/services/add<?= $parameters ?>" title="<?= $text_add_new_services ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
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
                    <td><strong><?= $text_services_thead_name ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td><strong><?= $text_services_thead_alias ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_services_thead_status ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong><br><a onclick="$('#multiaction_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_services_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $key => $value): ?>
                    <tr>
                        <td class="first">
						<?php if(isset($languages)): ?>
							<?php foreach ($languages as $item): ?>
								<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value['service']['id'] ?>][<?= $item['lang_id']?>][title]" value='<?= $value['service']['descriptions'][$item['lang_id']]['title'] ?>' class="text"><?= $item['icon']?>
							<?php endforeach; ?>
						<?php else: ?>
							<input type="text" name="descriptions[<?= $value['service']['id'] ?>][1][title]" value='<?= $value['service']['descriptions'][1]['title'] ?>' class="text">
						<?php endif; ?>
						</td>
                        <td><input type="text" name="alias[<?= $value['service']['id'] ?>]" class="text" value="<?= $value['service']['alias'] ?>"></td>
                        <?php if ($value['service']['status']): ?>
                            <td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['service']['id'] ?>);" id='status_<?= $value['service']['id'] ?>' checked value='1'></td>
                        <?php else: ?>
                            <td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['service']['id'] ?>);" id='status_<?= $value['service']['id'] ?>' value='1'></td>
                        <?php endif; ?>
                        <input type='hidden' name='status[<?= $value['service']['id'] ?>]' id="statusfield_<?= $value['service']['id'] ?>" value=''>
                        <script>
                        $(document).ready(function(){
                            checkboxStatus(<?= $value['service']['id'] ?>);
                        });
                        </script>
                        <td class="last"><input type="text" name="weight[<?= $value['service']['id'] ?>]" class="text short" value="<?= $value['service']['weight'] ?>"></td>
                        <td class="last"><a href="/admin/services/edit/<?= $value['service']['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/services/delete/<?= $value['service']['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>
					
					<?php if ($value['children']): ?>
						<?php foreach ($value['children'] as $value2): ?>
							<tr>
								<td class="first">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php if(isset($languages)): ?>
									<?php foreach ($languages as $item): ?>
										<input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $value2['id'] ?>][<?= $item['lang_id']?>][title]" value='<?= $value2['descriptions'][$item['lang_id']]['title'] ?>' class="text"><?= $item['icon']?>
									<?php endforeach; ?>
								<?php else: ?>
									<input type="text" name="descriptions[<?= $value2['id'] ?>][1][title]" value='<?= $value2['descriptions'][1]['title'] ?>' class="text">
								<?php endif; ?>
								</td>
								<td><input type="text" name="alias[<?= $value2['id'] ?>]" class="text" value="<?= $value2['alias'] ?>"></td>
								<?php if ($value2['status']): ?>
									<td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value2['id'] ?>);" id='status_<?= $value2['id'] ?>' checked value='1'></td>
								<?php else: ?>
									<td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value2['id'] ?>);" id='status_<?= $value2['id'] ?>' value='1'></td>
								<?php endif; ?>
								<input type='hidden' name='status[<?= $value2['id'] ?>]' id="statusfield_<?= $value2['id'] ?>" value=''>
								<script>
								$(document).ready(function(){
									checkboxStatus(<?= $value2['id'] ?>);
								});
								</script>
								<td class="last"><input type="text" name="weight[<?= $value2['id'] ?>]" class="text short" value="<?= $value2['weight'] ?>"></td>
								<td class="last"><a href="/admin/services/edit/<?= $value2['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/services/delete/<?= $value2['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
                <?php endforeach; ?>
            </tbody>		
        </table>
		<input type="hidden" name="parameters" value="<?= $parameters ?>" />
        <input type="hidden" name="module" value="services" />
    </form>
<?= $pagination2 ?>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>