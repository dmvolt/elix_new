<? if(isset($errors)){?>
<? foreach($errors as $item){?>
<p style="color:red"><?=$item?></p>
<?}?>
<?}?>

<div style="padding-top:50px;">
	<h2 class="title"><?=$text_edit_tags ?> - <?=$content['name']?></h2>
	<form action="" method="post" name="form1" id="form1">
	
	<div class="form_item">
	<label for="group_id"><?=$text_group_tags ?></label></br>
		<select name="group_id" style="width:250px">
		<?php foreach($group_tags as $key => $value): ?>
		    <?php if($key == $content['group_id']): ?>
                <option value="<?=$key ?>" selected="selected"><?=$value[1]['name'] ?></option>
		    <?php else: ?>
			    <option value="<?=$key ?>"><?=$value[1]['name'] ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
        </select>
	</div>
	
	<div class="form_item">
        <label for="name"><?=$text_tags_name ?></label>
		<?php if(isset($languages)): ?>
			<?php foreach ($languages as $item2): ?>
				<?php if($item2['lang_id'] == $content['lang_id']){ ?>
					<?= $item2['icon'] ?>
					<br><input type="text" id="name" name="name[<?= $item2['lang_id'] ?>]" value="<?= $content['name'] ?>" class="text">
				<?php } ?>
			<?php endforeach; ?>
		<?php else: ?>
			<br><input type="text" id="name" name="name[1]" value="<?=$content['name'] ?>" class="text">
		<?php endif; ?>
	</div>
	
	<div class="form_item">
        <label for="alias"><?=$text_tags_alias ?></label><br>
		<input type="text" name="alias" value="<?= $content['alias'] ?>" class="text">	
	</div>

	</form>

	<a onclick="$('#form1').submit();" class="btn_core btn_core_blue btn_core_md"><span><?=$text_save ?></span></a>	
</div>