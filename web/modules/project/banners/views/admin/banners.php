<? if(isset($errors)){?>
<? foreach($errors as $item){?>
<p style="color:red"><?=$item ?></p>
<?}?>
<?}?>
   
<h2 class="title"><?=$text_banners ?> <a href="/admin/banners/add<?= $parameters ?>" title="<?=$text_add_new_banners ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="type">Тип баннера</label></br>
        <select name="type" style="width:200px;">
			<option value=""> -- Все -- </option>
            <?php foreach ($banner_types as $typeId => $typeName): ?>
                <option value="<?= $typeId ?>"<?php if($typeId === Arr::get($_GET, 'type', null)):?> selected<?php endif; ?>><?= $typeName ?></option>
            <?php endforeach; ?>
        </select>
    </div>
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

<?php if (isset($contents) AND count($contents)>0): ?>
<table>
	<thead>
		<tr>
			<td><strong><?=$text_banner_thead_img ?></strong></td>
			<td><strong><?=$text_banner_thead_name ?></strong></td>
			<td><strong><?=$text_banner_thead_status ?></strong></td>
			<td class="last"><strong><?=$text_banner_thead_action ?></strong></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($contents as $key => $value): ?>
			<tr>
				<td class="first">
					<div class="banners_preview">
						<?php if(isset($value['files'][0]['file']->filepathname)): ?>
							<img src="/files/thumbnails/<?=$value['files'][0]['file']->filepathname ?>">
						<?php endif; ?>
					</div>
				</td>	
				
				<td><?=$value['title'] ?></td>
				
				<?php if($value['status']): ?>
					<td><span style="color:green"><?=$text_active ?></span></td>
				<?php else: ?>
					<td><span style="color:red"><?=$text_inactive ?></span></td>
				<?php endif; ?>
				<td class="last"><a href="/admin/banners/edit/<?=$value['id'] ?><?= $parameters ?>" class="edit"><?=$text_edit ?></a>&nbsp;&nbsp;<a href="/admin/banners/delete/<?=$value['id'] ?><?= $parameters ?>" class="delete"><?=$text_delete_img ?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>