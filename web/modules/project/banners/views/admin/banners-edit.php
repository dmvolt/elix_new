<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="padding-top:50px;">
    <h2 class="title"><?= $text_edit_content ?> - <?= $content['title'] ?></h2>
    <form action="" method="post" name="form1" id="banners_edit">

        <div class="form_item">
            <label for="title"><?= $text_name ?></label></br>
            <input type="text" name="title" value="<?= $content['title'] ?>" class="text">
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
			<label for="status"><?= $text_banners_status ?></label>
            <?php if ($content['status']): ?>
                <input type="checkbox" name="status" checked="checked" value="1">
            <?php else: ?>
                <input type="checkbox" name="status" value="1">
            <?php endif; ?>
        </div>

        <h2 class="title"><?= $text_banners_files ?></h2>
        <div class="images_content" id="sortable"></div>
    </form>
	<?= $files_form ?>

    <div class="form_item">
        <a onclick="$('#banners_edit').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
    </div>
</div>