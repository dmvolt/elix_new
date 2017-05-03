<?php

defined('SYSPATH') or die('No direct script access.');

$lang_array = array(
    'text_comments' => 'Комментарии',
    'text_add_new_comment' => 'Добавить комментарий',
    'text_comment_date' => 'Дата:',
    'text_comment_author' => 'Автор:',
	'text_comment_message' => 'Текст сообщения:',
    'text_reply_to_comment' => 'Ответить',
    'text_delete_comment' => '<img src="/images/admin/delete.png" title="Удалить комментарий" />',
    'text_save_new_comment' => 'Отправить',
	'text_active_comment' => '<img src="/images/admin/accept.png" title="Комментарий включен" />',
	'text_inactive_comment' => '<img src="/images/admin/lock.png" title="Комментарий отключен (ожидает премодерации)" />',
	'text_description_comment_save' => 'Это действие приведет к сохранению всех данных и ответов.',
	'text_comment_pre_moderation' => 'Извините, комментарий ожидает модерации.',
);

View::set_global($lang_array);