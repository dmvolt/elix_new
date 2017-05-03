<div>
    <h2 class="title"><?=$text_modul_email ?></h2>
	<table>
	<thead>
	<tr>
		<td><strong><?=$text_email_thead_id ?></strong></td>
		<td><strong><?=$text_email_thead_title ?></strong></td>
		<td><strong><?=$text_email_thead_action ?></strong></td>
	</tr>
	</thead>
	<tbody>
	<?php if (isset($contents)): ?>
	    <?php foreach ($contents as $key => $value): ?>
		    <tr>
			    <td class="first"><?=$value['id'] ?></td>
			    <td class="first"><?=$value['title'] ?></td>
				<td class="last"><a href="/admin/email/edit/<?=$value['id'] ?>" class="edit"><?=$text_edit ?></a></td>
			</tr>
		<?php endforeach; ?> 
    <?php endif; ?> 
	</tbody>
	</table>
</div>