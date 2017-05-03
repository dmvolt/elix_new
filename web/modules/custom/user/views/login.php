<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Авторизация</title>
  
<LINK rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
<LINK rel="icon" href="/images/favicon.ico" type="image/x-icon" />  
<link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon-precomposed.png" />

<link href="/css/login.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
	$('#formlogin1 input[name=\'login\'], #formlogin1 input[name=\'password\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			$('#formlogin1').submit();
		}
	});			
});
</script>
</head>
<body>

<div id="login_wrapper">
	<h2 class="title">Авторизация</h2>
	<form action="" method="post" id="formlogin1">
		<div class="form_item">
			<label>Логин:</label></br>
			<input type="text" name="login" class="text">
		</div>
		</br>
		<div class="form_item">
			<label>Пароль:</label></br>
			<input type="password" name="password" class="text">
		</div>
	</form>	
	<div class="clear"></div>
	<span class="button-2"><a onclick="$('#formlogin1').submit();"><strong>Войти</strong></a></span>
	<p class="pwrecovery">
	<? if(isset($error)){?>
	<span style="color:red">Логин или пароль введены неверно. </span>
	<?}?>
	<a href="/auth/pwrecovery">Забыли пароль?</a></p>
	
</div> <!-- END login_wrapper -->
  
</body>
</html>