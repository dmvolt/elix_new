<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="padding-top:50px;">
    <h2 class="title"><?= $text_add_new_user2 ?></h2>
    <form action="" method="post" name="form" id="user_add">
        <div class="form_item">
            <label for="username"><?= $text_login ?></label></br>
            <input type="text" id="username" name="username" class="text">
        </div>
		
		<div class="form_item">
            <label for="pass">Пароль</label></br>
            <input type="text" name="pass" class="text">
        </div>

        <div class="form_item">
            <label for="email"><?= $text_email ?></label></br>
            <input id="email" type="text" name="email" class="text"></br>
        </div>

        <div class="form_item">
            <label for="role_id"><?= $text_role ?></label></br>
            <select name="role_id">
                <?php foreach ($roles as $role): ?>

                    <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>

                <?php endforeach; ?>
            </select>
        </div>

        <div class="form_item">
            <label for="active"><?= $text_user_status ?></label></br>
            <select name="status">
                <option value="1">-<?= $text_active ?>-</option>
                <option value="0">-<?= $text_inactive ?>-</option>
            </select>
        </div>
        <div class="form_item" style="top:32px;">
            <a onclick="$('#user_add').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
        </div>
    </form>
</div>