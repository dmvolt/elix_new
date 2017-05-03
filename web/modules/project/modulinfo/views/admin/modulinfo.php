<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_modulinfo ?> <a href="/admin/modulinfo/add" title="<?= $text_add_new_modulinfo ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

<?php if (isset($contents) AND count($contents) > 0): ?>
	<table>
		<thead>
			<tr>
				<td><strong><?= $text_modulinfo_thead_module ?></strong></td>
				<td class="last"><strong><?= $text_modulinfo_thead_action ?></strong></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($contents as $key => $value): ?>
				<tr>
					<td><?= $value['module'] ?></td>
					<td class="last"><a href="/admin/modulinfo/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/modulinfo/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
				</tr>

			<?php endforeach; ?>
		</tbody>		
	</table>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>