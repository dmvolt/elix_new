<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<h2 class="title"><?= $text_news ?> <a href="/admin/news/add<?= $parameters ?>" title="<?= $text_add_new_news ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>
<form action="" method="get" name="form" id="form" style="float:left;">
    <div class="form_item">
        <label for="cat"><?= $text_cat_news ?></label></br>
        <select name="cat" style="width:200px;">
            <?php
            $tree = new Tree();
            foreach ($group_cat as $group):
                ?>
                <?php if ($group['dictionary_id'] == 1): ?>
                    <?php $tree->selectOutTree($group['dictionary_id'], 0, 1, $parent = (isset($parent)) ? $parent : ''); //Выводим дерево в элемент выбора ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form_item" style="top:32px">
        <a onclick="$('#form').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
    </div>
</form>
<div class="clear"></div>

<?= Modulinfo::get_admin_block('news', $parent = (isset($parent)) ? $parent : false) ?>

<h2 class="title"><?= $cat_name ?></h2>
<?php if (isset($contents) and count($contents) > 0): ?>
    <form method="post" action="/admin/weight/update" id="weight_form">
        <table>
            <thead>
                <tr>
                    <td><strong><?= $text_news_thead_date ?></strong></td>
                    <td><strong><?= $text_news_thead_name ?></strong></td>
                    <td><strong><?= $text_news_thead_alias ?></strong></td>
                    <td class="last"><strong><?= $text_news_thead_status ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_thead_weight ?></strong>&nbsp;&nbsp;<a onclick="$('#weight_form').submit();" class="btn_core btn_core_blue btn_core_sm"><span><?= $text_save ?></span></a></td>
                    <td class="last"><strong><?= $text_news_thead_action ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contents as $key => $value): ?>
                    <tr>
                        <td class="first"><?= $value['date'] ?></td>
                        <td class="first"><?= $value['descriptions'][1]['title'] ?></td>
                        <td><?= $value['alias'] ?></td>
                        <?php if ($value['status']): ?>
                            <td class="last"><span style="color:green"><?= $text_active ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' checked value='1'></td>
                        <?php else: ?>
                            <td class="last"><span style="color:red"><?= $text_inactive ?></span><input type='checkbox' onclick="checkboxStatus(<?= $value['id'] ?>);" id='status_<?= $value['id'] ?>' value='1'></td>
                        <?php endif; ?>
                            <input type='hidden' name='status[<?= $value['id'] ?>]' id="statusfield_<?= $value['id'] ?>" value=''>
                        <script>
                        $(document).ready(function(){
                            checkboxStatus(<?= $value['id'] ?>);
                        });
                        </script>
                        <td class="last"><input type="text" name="weight[<?= $value['id'] ?>]" class="text short" value="<?= $value['weight'] ?>"></td>
                        <td class="last"><a href="/admin/news/edit/<?= $value['id'] ?><?= $parameters ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/news/delete/<?= $value['id'] ?><?= $parameters ?>" class="delete"><?= $text_delete_img ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>		
        </table>
        <input type="hidden" name="module" value="news" />
    </form>
<?php else: ?>
    <h2 class="title">Нет ни одного материала</h2>
<?php endif; ?>