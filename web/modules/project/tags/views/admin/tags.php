<? if(isset($errors)){?>
<? foreach($errors as $item){?>
<p style="color:red"><?=$item ?></p>
<?}?>
<?}?>

<div>
    <h2 class="title"><?=$text_add_new_tags ?></h2>
    <form method="post" action="" id="form1">
	
	<?php if(isset($group_tags)): ?>
	<div class="form_item">
        <label for="group_id"><?=$text_group_tags ?></label></br>
		<select name="group_id" style="width:250px">
		<?php foreach($group_tags as $key => $value): ?>
		    
			<option value="<?=$key ?>"><?=$value[1]['name'] ?></option>
		   
		<?php endforeach; ?>
        </select>
	</div>
    <?php endif; ?>

	<div class="form_item">
        <label for="name"><?=$text_tags_name ?></label>
        <?php if(isset($languages)): ?>
			<?php foreach ($languages as $item): ?>
				<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="name[<?= $item['lang_id']?>]" class="text">
			<?php endforeach; ?>
		<?php else: ?>
			<br><input type="text" id="name" name="name[1]" class="text">
		<?php endif; ?>
	</div>	
	
	<div class="form_item" style="top:32px">
        <a onclick="$('#form1').submit();" class="btn_core btn_core_blue btn_core_md"><span><?=$text_create ?></span></a>	
	</div>
    </form>
</div>
<form method="post" action="/admin/weight/update" id="weight_form">       
	<?php foreach($group_tags as $item): ?>
		<h2 class="title"><?=$item[1]['name'] ?></h2>
		<table>
			<thead>
				<tr>
					<td class="first"><strong><?=$text_tags_name ?> </strong></td>
					<td class="last"><strong><?=$text_tags_action ?></strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($contents as $value): ?>
					<?php if($value['group_id'] == $item[1]['group_id']): ?>
			
						<tr>
							<td class="first">
								<?php if(isset($languages)): ?>
									<?php foreach ($languages as $item2): ?>
										<?php if($item2['lang_id'] == $value['lang_id']){echo $item2['icon'];} ?>
									<?php endforeach; ?>
								<?php endif; ?>
								<?= $value['name'] ?>
							</td>
							<td class="last"><a href="/admin/tags/edit/<?=$value['id'] ?>" class="edit"><?=$text_edit ?></a>&nbsp;&nbsp;<a href="/admin/tags/delete/<?=$value['id'] ?>" class="delete"><?=$text_delete_img ?></a></td>
						</tr>
					
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach; ?>
	<input type="hidden" name="module" value="tags">
</form>