<!DOCTYPE html>
<html lang="<?= Data::_('lang_ident') ?>">
    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <?php foreach ($styles as $style): ?>
            <link href="<?= URL::base() ?>css/<?= $style ?>.css" rel="stylesheet" type="text/css" />
        <?php endforeach; ?>
		
        <?php foreach ($scripts as $script): ?>
            <script type="text/javascript" src="<?= URL::base() ?>js/<?= $script ?>.js" ></script>
        <?php endforeach; ?>
    </head>
    <body dir="<?= Data::_('lang_dir') ?>">
        <div id="header-wrap">
            <?= $logo ?>
            <h2 class="slogan"><?= $slogan ?> Вы вошли как <?= $role_name ?>.</h2>
        </div>
        <!-- start top -->
        <div id="top-wrap">
            <div class="content">
                <div id="menu-wrap">
                    <div id="main_menu">
                        <ul class="menu">
                            <?php foreach ($menu as $item): ?>
                                <li class="<?php if (Request::current()->controller() == $item['controller']): ?>selected<?php endif; ?>"><a href="<?= $item['href'] ?>" target="<?= $item['target'] ?>"><?= $item['name'] ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li class="menu_right"><a href="/auth/logout"><?= $text_logout ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end top-wrap -->
        <div id="wrapper">
            <div id="main">
				<?php if(isset($languages)): ?>
					<div id="lang_button" style="float:right;">
					<?php foreach ($languages as $lang_ident => $item): ?>
						<input type="radio" id="lang_button_<?= $item['lang_id']?>" onclick="checkLanguage(this.value, '<?= $lang_ident ?>', '<?= $item['dir']?>');" name="lang_button" <?php if($item['lang_id'] == 1){echo 'checked="checked"';} ?> value="<?= $item['lang_id']?>" /><label for="lang_button_<?= $item['lang_id']?>"><?= $item['icon']?> <?= $item['name']?></label>
					<?php endforeach; ?>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
                <?= $content ?>
            </div>
        </div> <!-- END wrapper -->
        <!-- start footer-c-wrap -->
        <div id="footer-c-wrap">
            <div class="content">
                <p><?= $copyright ?>&nbsp;&nbsp;<?php print date('Y') . 'г.' ?></p>
            </div>
        </div>
        <!-- end footer-c-wrap -->
    </body>
<script type="text/javascript">
$(document).ready(function(){
	checkLanguage(1);
});
function checkLanguage(langId, langIdent, langDir)
{
	$('html').attr('lang', langIdent);	
	$('html').attr('dir', langDir);
	//$('.lang_editor').redactor('destroy'); // закомментировать если язык один!
	for(i=1;i<=5;i++) {		
		if (i==langId) {
		
			$('[id$="_input_lang_' + i + '"]').attr('type', 'text');
			$('[id$="_input_lang_' + i + '"]').prev('br').css({'display':'block'});
			$('.lang_img_' + i).css({'display':'inline'});
		
			$('.textarea_lang_' + i + ', .seo_textarea_lang_' + i + ', .file_textarea_lang_' + i).css({'position':'static', 'visibility':'visible'});
			$('.textarea_lang_' + i).addClass('lang_editor');
			
		} else {
		
			$('[id$="_input_lang_' + i + '"]').attr('type', 'hidden');
			$('[id$="_input_lang_' + i + '"]').prev('br').css({'display':'none'});
			$('.lang_img_' + i).css({'display':'none'});
		
			$('.textarea_lang_' + i + ', .seo_textarea_lang_' + i + ', .file_textarea_lang_' + i).css({'position':'absolute', 'top':'-10000px', 'left':'-10000px', 'visibility':'hidden'});
			$('.textarea_lang_' + i).removeClass('lang_editor');		
		}
	}
	$('.lang_editor').redactor({
		lang: 'ru',
		plugins: ['fontcolor', 'fontfamily', 'fontsize', 'fullscreen'],
		deniedTags: ['html', 'head', 'link', 'body', 'meta', 'applet'],
		observeLinks: true,
		convertVideoLinks: true,
		convertImageLinks: true,
		replaceDivs: false,
		cleanSpaces: false,
		paragraphize: false,
		imageUpload: '/liteedit/load_image_in_text',
		fileUpload: '/liteedit/load_file_in_text'
	});
	
	$('.editor').redactor({
		lang: 'ru',
		plugins: ['fontcolor', 'fontfamily', 'fontsize', 'fullscreen'],
		deniedTags: ['html', 'head', 'link', 'body', 'meta', 'applet'],
		observeLinks: true,
		convertVideoLinks: true,
		convertImageLinks: true,
		replaceDivs: false,
		cleanSpaces: false,
		paragraphize: false,
		imageUpload: '/liteedit/load_image_in_text',
		fileUpload: '/liteedit/load_file_in_text'
	});
}
</script>
</html>