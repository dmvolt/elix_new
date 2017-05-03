<div>
    <h2 class="title"><?=$text_delete_qwest ?><?=$content['title'] ?>?</h2>
    <form method="post" action="" id="con_delete">
        <input type="hidden" name="delete" value="1"/>
        <div class="form_item" style="top:40px;">
			<a onclick="$('#con_delete').submit();" class="btn_core btn_core_blue btn_core_md" style="margin-right:25px;"><span><?=$text_delete ?></span></a>
		</div>
		<div class="form_item" style="top:40px;">
			<a onclick="history.back();" class="btn_core btn_core_green btn_core_md" style="margin-right:25px;"><span><?=$text_nodelete ?></span></a>
		</div>
    </form>
</div>