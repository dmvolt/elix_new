<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_comments' => 'Comments',
    'text_add_new_comment' => 'Add new comment',
    'text_comment_date' => 'Date:',
    'text_comment_author' => 'Author:',
	'text_comment_message' => 'Message:',
	'text_comment_status' => 'Status',
	'text_comment_delete' => 'Delete',
    'text_reply_to_comment' => 'Reply',
    'text_save_new_comment' => 'Go',
	'text_delete_comment' => '<img src="/images/admin/delete.png" title="Delete comment" />',
	'text_active_comment' => '<img src="/images/admin/accept.png" title="Active comment" />',
	'text_inactive_comment' => '<img src="/images/admin/lock.png" title="Inactive comment" />',
	'text_description_comment_save' => 'This action will store all the data and replies.',
	'text_filter_on_status' => 'Фильтр по статусу:',
	'text_filter_on_module' => 'Фильтр по типу материала:',
);

View::set_global($lang_array);