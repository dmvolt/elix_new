<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_add_new_infoblock ?></h2>
<form action="" method="post" name="form1" id="page_add">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">Город и раздел</a></li>
	</ul>
	
	<div id="tabs-1">
		<div class="form_item">
			<label for="title"><?= $text_name ?></label></br>
			<input type="text" name="title" value="<?= $post['title'] ?>" class="text">
		</div>

		<div class="form_item">
			<label for="info"><?= $text_infoblock2_info ?></label></br>
			<input type="text" name="info" value="<?= $post['info'] ?>" class="text">
		</div>
		<br>
		<div class="form_item">
			<label for="link1"><?= $text_infoblock2_link1 ?></label></br>
			<input type="text" name="link1" value="<?= $post['link1'] ?>" class="text">
		</div>
		<div class="form_item">
			<label for="link2"><?= $text_infoblock2_link2 ?></label></br>
			<input type="text" name="link2" value="<?= $post['link2'] ?>" class="text">
		</div>
		<br>
		<div class="form_item">
			<label for="pos_x"><?= $text_infoblock2_pos_x ?></label></br>
			<input type="text" name="pos_x" value="<?= $post['pos_x'] ?>" class="text">
		</div>
		<div class="form_item">
			<label for="pos_y"><?= $text_infoblock2_pos_y ?></label></br>
			<input type="text" name="pos_y" value="<?= $post['pos_y'] ?>" class="text">
		</div>
		<br>
		<div class="form_item">
			<label for="type"><?= $text_infoblock2_type ?></label></br>
			<input type="text" name="type" class="text" value="<?= $post['type'] ?>">
		</div>
		<br>
		<div class="form_item">
			<input type="checkbox" id="status" name="status" checked="checked" value="1">
			<label for="status"><?= $text_infoblock2_status ?></label>
		</div>
	</div>
	
	<div id="tabs-2">
		<?= $categories_form2 ?>
		<?= $categories_form1 ?>
	</div>
</div>
</form>
<div class="form_item" style="top:35px">
	<a onclick="$('#page_add').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>