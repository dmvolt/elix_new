<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_siteinfo ?></h2>
<form action="" method="post" name="form" id="edit_siteinfo">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Основная информация</a></li>
		<li><a href="#tabs-2">SEO</a></li>
	</ul>
	
	<div id="tabs-1">
        <div class="form_item">
            <label for="site_name"><?= $text_siteinfo_name ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="name_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][site_name]" value='<?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['site_name'] ?>' class="text">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="name" name="descriptions[1][site_name]" value='<?= $content['descriptions'][1]['site_name'] ?>' class="text">
			<?php endif; ?>
        </div>

        <div class="form_item">
            <label for="site_slogan"><?= $text_siteinfo_slogan ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="slogan_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][site_slogan]" value='<?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['site_slogan'] ?>' class="text"  style="width:400px">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="slogan" name="descriptions[1][site_slogan]" value='<?= $content['descriptions'][1]['site_slogan'] ?>' class="text" style="width:400px">
			<?php endif; ?>
        </div>
        </br>
        <div class="form_item">
            <input type="text" name="site_email" value='<?= $content['email'] ?>' class="text"><label for="site_email"><?= $text_siteinfo_email ?></label>
        </div>
        </br>	
        <div class="form_tell">
            <input type="text" name="site_tell" value='<?= $content['tell'] ?>' class="text"><label for="site_tell"><?= $text_siteinfo_tell ?></label>
        </div>
		
		<div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="site_address" class="lang_img_<?= $item['lang_id']?>"><?= $text_siteinfo_address ?> </label><?= $item['icon']?><br class="lang_img_<?= $item['lang_id']?>"><textarea name="descriptions[<?= $item['lang_id']?>][teaser]" class="textarea_lang_<?= $item['lang_id']?>"><?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['teaser'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="site_address"><?= $text_siteinfo_address ?></label><br><textarea name="descriptions[1][teaser]" class="lang_editor"><?= $content['descriptions'][1]['teaser'] ?></textarea>
			<?php endif; ?>
        </div>

        <div class="form_item_textarea">
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<label for="site_description" class="lang_img_<?= $item['lang_id']?>"><?= $text_siteinfo_description ?> </label><?= $item['icon']?><br class="lang_img_<?= $item['lang_id']?>"><textarea name="descriptions[<?= $item['lang_id']?>][body]" class="textarea_lang_<?= $item['lang_id']?>"><?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['body'] ?></textarea>
				<?php endforeach; ?>
			<?php else: ?>
				<label for="site_description"><?= $text_siteinfo_description ?></label><br><textarea name="descriptions[1][body]" class="lang_editor" id="body"><?= $content['descriptions'][1]['body'] ?></textarea>
			<?php endif; ?>
        </div>
		
		<div class="form_item">
            <label for="site_licence"><?= $text_siteinfo_licence ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="licence_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][site_licence]" value='<?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['site_licence'] ?>' class="text"  style="width:400px">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="licence" name="descriptions[1][site_licence]" value='<?= $content['descriptions'][1]['site_licence'] ?>' class="text" style="width:400px">
			<?php endif; ?>
        </div>

        <div class="form_item">
            <label for="site_copyright"><?= $text_siteinfo_copyright ?></label>
			<?php if(isset($languages)): ?>
				<?php foreach ($languages as $item): ?>
					<?= $item['icon']?><br><input type="text" id="copyright_input_lang_<?= $item['lang_id']?>" name="descriptions[<?= $item['lang_id']?>][site_copyright]" value='<?php if(isset($content['descriptions'][$item['lang_id']])) echo $content['descriptions'][$item['lang_id']]['site_copyright'] ?>' class="text"  style="width:400px">
				<?php endforeach; ?>
			<?php else: ?>
				<br><input type="text" id="copyright" name="descriptions[1][site_copyright]" value='<?= $content['descriptions'][1]['site_copyright'] ?>' class="text" style="width:400px">
			<?php endif; ?>
        </div>
	</div>
	
	<div id="tabs-2">
		<?= $seo_form ?>
	</div>
</div>
</form>
<br>
<div class="form_item">
	<a onclick="$('#edit_siteinfo').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?= $text_save ?></span></a>
</div>