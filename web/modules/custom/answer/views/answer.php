<div class="content">
<h2>
<?=$answer_message ?>
<?php if(!empty($answer_errors)){ ?>
    
	<?foreach($answer_errors as $item){?>
		</br><?=$item?>
	<?}?>
	
<?}?>
</h2>
<input type="button" onclick="history.back();" value="Вернуться назад" class="bg_green">
</div>