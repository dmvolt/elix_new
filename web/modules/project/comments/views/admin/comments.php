<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
		<label for="filter"><?= $text_filter_on_status ?></label></br>
        <select name="filter" style="width:200px;">
            <option value="all">Все</option>
			<option value="1" <?php if(isset($_GET['filter']) AND $_GET['filter'] == 1){ echo 'selected';}?>>Только активные</option>
			<option value="0" <?php if(isset($_GET['filter']) AND $_GET['filter'] == 0){ echo 'selected';}?>>Только неактивные (новые)</option>		
        </select>
	</div>
	<!--<div class="form_item">
        <label for="module"><?//= $text_filter_on_module ?></label></br>
        <select name="module" style="width:200px;">
			<option value="all">Все</option>
            <option value="blog" <?php //if(isset($_GET['module']) AND $_GET['module'] == 'blog'){ echo 'selected';}?>>Блог</option>
			<option value="articles" <?php //if(isset($_GET['module']) AND $_GET['module'] == 'articles'){ echo 'selected';}?>>Статьи</option>
        </select>
    </div>-->
    <div class="form_item" style="top:40px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>

<div class="clear"></div>
<h2 class="title"><?= $text_comments ?></h2>
<?php if (isset($comments) and count($comments) > 0): ?>
    <form method="post" action="/admin/comments/update" id="admin_comments_form">
        <table>
            <thead>
                <tr>
                    <td><strong><?= $text_comment_date ?></strong></td>
                    <td><strong><?= $text_comment_author ?></strong></td>
                    <td><strong><?= $text_comment_message ?></strong></td>
                    <td class="last"><strong><?= $text_comment_status ?></strong>&nbsp;&nbsp;<a onclick="$('#admin_comments_form').submit();" class="btn_core btn_core_blue btn_core_sm" title="<?= $text_description_comment_save ?>"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_comment_delete ?></strong>&nbsp;&nbsp;<a onclick="$('#admin_comments_form').submit();" class="btn_core btn_core_blue btn_core_sm" title="<?= $text_description_comment_save ?>"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_reply_to_comment ?></strong>&nbsp;&nbsp;<a onclick="$('#admin_comments_form').submit();" class="btn_core btn_core_blue btn_core_sm" title="<?= $text_description_comment_save ?>"><span><?= $text_save ?></span></a></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr <?php if(!$comment['parent_id'] AND $comment['status']){ echo 'class="row_user_active_comment"';}elseif(!$comment['parent_id'] AND !$comment['status']){ echo 'class="row_user_inactive_comment"';}else{ echo 'class="row_user_reply"';} ?>>
                        <td class="first"><?= $comment['date'] ?></td>
                        <td class="first"><?= $comment['author'] ?></td>
                        <td><?= $comment['message'] ?></td>
                        <?php if ($comment['status']): ?>
                            <td class="last"><?= $text_active_comment ?> <input type="checkbox" onclick="checkboxStatus(<?= $comment['id'] ?>);" id="status_<?= $comment['id'] ?>" checked value="1"></td>
                        <?php else: ?>
                            <td class="last"><?= $text_inactive_comment ?> <input type="checkbox" onclick="checkboxStatus(<?= $comment['id'] ?>);" id="status_<?= $comment['id'] ?>" value="1"></td>
                        <?php endif; ?>
                            <input type='hidden' name='status[<?= $comment['id'] ?>]' id="statusfield_<?= $comment['id'] ?>" value=''>
                        <script>
                        $(document).ready(function(){
                            checkboxStatus(<?= $comment['id'] ?>);
                        });
                        </script>
						
						<td class="last"><a onclick="deleteComment(<?= $comment['id'] ?>);"><?= $text_delete_comment ?></a> <input name="delete[<?= $comment['id'] ?>]" type="checkbox" value="1"></td>					
						<td class="last"><a onclick="replyToComment(<?= $comment['id'] ?>);"><img src="/images/admin/comments.png" title="<?= $text_reply_to_comment ?>" /></a></td>
                    </tr>
					<tr class="row_user_reply" id="reply_form_<?= $comment['id'] ?>" style="display:none;">
                        <td></td>
                        <td class="first"><input name="author[<?= $comment['id'] ?>]" type="text" value="<?= $user_name ?>" class="text"></td>
                        <td><textarea name="message[<?= $comment['id'] ?>]" class="text"></textarea></td>                       
						<td><a onclick="$('#admin_comments_form').submit();" class="btn_core btn_core_blue btn_core_sm" title="<?= $text_description_comment_save ?>"><span><?= $text_reply_to_comment ?></span></a></td>                        
						<td></td>					
						<td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>		
        </table>        
		<input name="redirect_uri" type="hidden" value="<?= Request::detect_uri() ?>">
    </form>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>