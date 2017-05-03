<?php if(count($comments)>0): ?>
	<h3><?= $text_comments ?></h3>
	<?php if((Data::_('logged') AND Data::_('user')->role_id < 2) OR (Data::_('logged') AND Data::_('user')->role_id == Kohana::$config->load('comment_setting.moderator_role_id'))): ?>	
		<form action="/admin/comments/update" method="post" id="admin_comments_form">
			<?php foreach($comments as $comment): ?>
				<div class="comment_block" <?php if($comment['parent_id']) echo 'style="margin-left:35px;"'; ?>> <?php //if($comment['parent_id']) echo '<img class="reply_arrow" src="/images/arrow.png"/>'; ?>
					
					<!--<img class="avatar" src="/images/avatars/<?//= $comment['avatar'] ?>"/>--><span class="date"><?= $comment['date'] ?> </span><span class="author"> <?= $comment['author'] ?></span>
					
					<div class="message">
						<?= $comment['message'] ?>
					</div>
					<div class="clear"></div>
					<br>
					<div class="comment_actions">
						<?php if($comment['status']): ?>
							<?= $text_active_comment ?> <input type="checkbox" onclick="checkboxStatus(<?= $comment['id'] ?>);" id="status_<?= $comment['id'] ?>" checked value="1">
						<?php else: ?>
							<?= $text_inactive_comment ?> <input type="checkbox" onclick="checkboxStatus(<?= $comment['id'] ?>);" id="status_<?= $comment['id'] ?>" value="1">
						<?php endif; ?> 
						<input name="status[<?= $comment['id'] ?>]" type="hidden" id="statusfield_<?= $comment['id'] ?>" value="">
						
						<a onclick="deleteComment(<?= $comment['id'] ?>);"><?= $text_delete_comment ?></a> <input name="delete[<?= $comment['id'] ?>]" type="checkbox" value="1">					
						<a onclick="replyToComment(<?= $comment['id'] ?>);"><img src="/images/admin/comments.png" title="<?= $text_reply_to_comment ?>" /></a>
						<a onclick="$('#admin_comments_form').submit();" class="button small right" title="<?= $text_description_comment_save ?>"><?= $text_save ?></a>
					</div>
					
					<div class="reply_form" id="reply_form_<?= $comment['id'] ?>" style="display:none;">					
						<label for="author"><?= $text_comment_author ?></label><br>
						<input name="author[<?= $comment['id'] ?>]" type="text" value="<?= Data::_('user')->username ?>" class="text"><br>	
						<label for="message"><?= $text_comment_message ?></label><br>	  
						<textarea name="message[<?= $comment['id'] ?>]" class="textarea"></textarea>	
					</div>
				</div> 
				<hr>
				<script>
				$(document).ready(function(){
					checkboxStatus(<?= $comment['id'] ?>);
				});
				</script>
			<?php endforeach; ?>
			<input name="user_id" type="hidden" value="<?= Data::_('user')->id ?>">
			<input name="redirect_uri" type="hidden" value="<?= Request::detect_uri() ?>">
			<input name="content_id" type="hidden" value="<?= $hidden['content_id'] ?>">
			<input name="lang_id" type="hidden" value="<?= Data::_('lang_id') ?>">
			<input name="module" type="hidden" value="<?= $hidden['module'] ?>">
		</form>
	<?php else: ?>
		<?php foreach($comments as $comment): ?>
			<?php if($comment['status']): ?>
				<div class="comment_block" <?php if($comment['parent_id']) echo 'style="margin-left:35px;"'; ?>> <?php //if($comment['parent_id']) echo '<img class="reply_arrow" src="/images/arrow.png"/>'; ?>						
					<!--<img class="avatar" src="/images/avatars/<?//= $comment['avatar'] ?>"/>--><span class="date"><?= $comment['date'] ?> </span><span class="author"> <?= $comment['author'] ?></span>
					<div class="message">
						<?= $comment['message'] ?>
					</div>					
				</div>
			<?php else: ?>
				<div class="comment_block" style="color:#c4c4c4;">
					<div class="message" style="border: dashed #c4c4c4 1px;">
						<?= $text_comment_pre_moderation ?>
					</div>					
				</div>
			<?php endif; ?> 
			<hr>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>

<div class="comment_form">
	<h3><?= $text_add_new_comment ?></h3>
	<form action="" method="post">
		<div class="form-group">
			<label for="author"><?= $text_comment_author ?></label>
			<input name="author" type="text" value="<?=HTML::chars(Arr::get($_POST, 'author')) ?>" class="text<?php if(isset($errors['author'])): ?> error<?php endif; ?>">
			<?php if(isset($errors['author'])): ?><span class="error"><?=$errors['author'] ?></span><?php endif; ?>
		</div>
		<div class="form-group">	
			<label for="message"><?= $text_comment_message ?></label>	  
			<textarea name="message" class="textarea<?php if(isset($errors['message'])): ?> error<?php endif; ?>"><?=HTML::chars(Arr::get($_POST, 'message')) ?></textarea>		  
			<?php if(isset($errors['message'])): ?><span class="error"><?=$errors['message'] ?></span><?php endif; ?>
		</div>
		<div class="form-group">	
			<label><?= $text_entry_captcha ?></label>
			<?= $hidden['captcha_img'] ?>
			<input type="text" name="captcha" value="<?=HTML::chars(Arr::get($_POST, 'captcha')) ?>" class="<?php if(isset($errors['captcha'])): ?>error<?php endif; ?>"/>
			<?php if(isset($errors['captcha'])): ?><span class="error"><?=$errors['captcha'] ?></span><?php endif; ?>
		</div>
		<div class="form-group">
			<input name="send" type="submit" value="<?= $text_save_new_comment ?>" class="button"/>
		</div>
	</form>
</div>