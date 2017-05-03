<!-- Форма логина -->
<div class="login_block">
	<?php if(!Data::_('logged')): ?>
		<!--<form action="/auth" method="post">
			<input name="login" type="text" class="text">  <!--placeholder="<?//= $text_login_field ?>-->
			
		<!--<input name="password" type="password" class="text"> <!--placeholder="<?//= $text_password_field ?>"-->
		<!--<input type="submit" value="<?//= $text_login ?>" class="button"><br>
			<a href="/auth/reg"><?//= $text_reg ?></a> <a href="/auth/pwrecovery"><?//= $text_pass_recovery ?></a>
			
		</form>-->
	<?php else: ?>
		<span class="welcome"><?= $text_login_welcome ?><em><?= Data::_('user')->username ?></em></span>
		<a href="/admin" target="_blank">В админку</a>&nbsp;
		<a href="/auth/logout"><?= $text_logout ?></a>
	<?php endif; ?>	
</div>