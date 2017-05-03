<div style="padding-top:50px;">
	<h2 class="title"><?=$text_edit_modul_email ?><?=$content['title']?></h2>
	<form action="" method="post" name="form1" id="form1">
	<div class="form_item">
        <label for="title"><?=$text_name ?></label></br>
        <input type="text" id="name" name="title" value="<?=$content['title']?>" class="text" style="width:400px">
	</div>
            <br>
	<div class="form_item margin_right25">
	<label for="body"><?=$text_modul_email_body ?></label></br>	
	<textarea name="body" id="body"><?=$content['body']?></textarea>
        </div>
	
	<?php if (isset($email_tokens)): ?>
	<div class="form_item">
	<h2 class="title">Переменные, доступные для использования в шаблоне</h2>
	    <?php foreach ($email_tokens as $key => $description): ?>
		<p><span>[<?=$key ?>]</span> - <?=$description ?></p>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	
	
	</form>
<div class="form_item" style="top:35px;">	
    <a onclick="$('#form1').submit();" class="btn_core btn_core_blue btn_core_lg"><span><?=$text_save ?></span></a>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){     
        CKEDITOR.replace('body',       
        {
            height : 500,
            width : 600,
            toolbar : 'Full',
            contentsCss : CKEDITOR.basePath + 'newsletter_contents.css'
        });  
    });
</script>