<div>
    <h2 class="title"><?= $text_delete_qwest ?><?= $menu['descriptions'][1]['title'] ?>?</h2>
    <form method="post" action="" id="con_delete">
        <input type="hidden" name="delete" value="1"/>
        <? if (isset($children)) { ?>
            <p>Данный элемент меню содержит вложеные элементы:
                <? foreach ($children as $item) { ?>
                    <span style="color:green">&nbsp;&nbsp;<?= $item['descriptions'][1]['title'] ?></span>
                <? } ?></p>
            <p>которые при удалении:</p>
            <input type="radio" name="remove" value="1" checked="checked" /><label> - переместятся на уровень выше</label></br>
            <input type="radio" name="remove" value="0" /><label> - будут удалены вместе с родительским элементом</label></br></br>
            <input type="hidden" name="catid" value="<?= $item['id'] ?>">
        <? } ?>

        <div class="form_item" style="top:40px;">
            <a onclick="$('#con_delete').submit();" class="btn_core btn_core_blue btn_core_md" style="margin-right:25px;"><span><?= $text_delete ?></span></a>
        </div>
        <div class="form_item" style="top:40px;">
            <a onclick="history.back();" class="btn_core btn_core_green btn_core_md" style="margin-right:25px;"><span><?= $text_nodelete ?></span></a>
        </div>
    </form>
</div>