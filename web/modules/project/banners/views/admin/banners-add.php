<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="padding-top:50px;">
    <h2 class="title"><?= $text_add_new_banners ?></h2>
    <form action="" method="post" name="form1" id="banners_add">

        <div class="form_item">
            <label for="title"><?= $text_name ?></label></br>
            <input type="text" name="title" class="text">
        </div>

		<div class="form_item">
			<label for="categoryId1">Город</label></br>
			<?= $categories_form2 ?>
		</div>
		
		<div class="form_item">
			<label for="categoryId1">Раздел</label></br>
			<?= $categories_form1 ?>
		</div>
		
		<div class="form_item">
            <label for="status"><?= $text_banners_status ?></label><input type="checkbox" name="status" checked="checked" value="1">
        </div>
		
        <h2 class="title"><?= $text_banners_files ?></h2>
        <div class="images_content" id="sortable"></div>

    </form>
	
	<?= $files_form ?>
        
    <div class="form_item">
        <a onclick="$('#banners_add').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>
</div>