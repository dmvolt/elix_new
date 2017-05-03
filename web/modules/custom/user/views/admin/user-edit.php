<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?>

<div style="position:relative; padding-top:50px;">
    <h2 class="title"><?= $text_edit_user ?><?= $userdata[0]->username ?></h2>
    <form action="" method="post" name="form" id="user_edit">
        <div class="form_item">
            <label for="username"><?= $text_login ?></label></br>
            <input type="text" id="username" name="username" value="<?= $userdata[0]->username ?>" class="text">
        </div>

        <div class="form_item">
            <label for="email"><?= $text_email ?></label></br>
            <input id="email" type="text" name="email" value="<?= $userdata[0]->email ?>" class="text"></br>
        </div>

        <div class="form_item">
            <label for="role_id"><?= $text_role ?></label></br>
            <select name="role_id">
                <?php foreach ($roles as $role): ?>

                    <?php if ($userdata[0]->role_id == $role['id']): ?>
                        <option value="<?= $role['id'] ?>" selected="selected"><?= $role['name'] ?></option>
                    <?php else: ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                    <?php endif; ?>

                <?php endforeach; ?>
            </select>
        </div>
       
        <div class="form_item">
            <label for="active"><?= $text_user_status ?></label></br>
            <select name="status">
                <?php if ($userdata[0]->status == 1): ?>
                    <option value="1" selected="selected">-<?= $text_active ?>-</option>
                    <option value="0">-<?= $text_inactive ?>-</option>
                <?php else: ?>
                    <option value="1">-<?= $text_active ?>-</option>
                    <option value="0" selected="selected">-<?= $text_inactive ?>-</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form_item" style="top:32px;">
            <a onclick="$('#user_edit').submit();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
        </div>
    </form>

    <a ONCLICK="openPasswordinfo();" class="btn_core btn_core_blue btn_core_sm" style="top:40px;"><span>Изменить пароль</span></a>

    <div id="password_in">
        <img src="/images/admin/delete.png" ONCLICK="closePasswordinfo();" title="Закрыть" style="float:right; margin-right:0px; cursor:pointer" />
        <p><input type="checkbox" id="showpassbtn" ONCLICK="showPass();"><label for="showpassbtn"> Не прятать пароль за звездочки</label></p>
        <div class="form_item">
            <label for="oldpass">Старый пароль:</label></br>
            <input type="password" name="oldpass" id="oldpass" class="text">
            <span style="display: none" id="oldpassok"><img src="/images/admin/ok.png" title="Старый пароль введен правильно" alt="Старый пароль введен правильно"></span>
            <span style="display: none" id="oldpasserror"><img src="/images/admin/error.png" title="Ошибка в старом пароле" alt="Ошибка в старом пароле"></span>
        </div>
        <div class="form_item">
            <label for="newpass1">Новый пароль:</label></br>
            <input type="password" name="newpass1" id="newpass1" class="text">
        </div>
        <div class="form_item">
            <label for="newpass2">Повторите новый пароль:</label></br>
            <input type="password" name="newpass2" id="newpass2" class="text">
            <span style="display: none" id="newpassmatchesok"><img src="/images/admin/ok.png" title="Пароли совпадают" alt="Пароли совпадают"></span>
            <span style="display: none" id="newpassmatcheserror"><img src="/images/admin/error.png" title="Пароли несовпадают" alt="Пароли несовпадают"></span>
        </div>

        <input type="hidden" name="user_id" id="user_id" value="<?= $userdata[0]->id ?>">

        <div class="form_item" style="top:32px;">
            <a onclick="saveNewPass();" class="btn_core btn_core_blue btn_core_md"><span><?= $text_save ?></span></a>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#oldpass").blur(checkOldPass);
        $("#newpass2").keyup(matchesPass);
    });

    function openPasswordinfo()
    {
        $("#password_in").css({display: "block"});
        return false;
    }

    function closePasswordinfo()
    {
        $("#password_in").css({display: "none"});
        return false;
    }



    function checkOldPass()
    {
        $.ajax({
            type: "POST",
            data: $('#user_id, #oldpass'),
            url: "/ajax/checkOldPass",
            dataType: "json",
            success: function(data)
            {
                if(data.result)
                {
                    $("#oldpassok").css('display','inline');
                    $("#oldpasserror").css('display','none');
                }
                else
                {
                    $("#oldpasserror").css('display','inline');
                    $("#oldpassok").css('display','none');
                }
            }
        })
    }

    function showPass()
    {
        var elementType = $("#oldpass").attr('type');

        if(elementType == "password")
        {
            document.getElementById('oldpass').type = 'text';
            document.getElementById('newpass1').type = 'text';
            document.getElementById('newpass2').type = 'text';
        }
        else
        {
            document.getElementById('oldpass').type = 'password';
            document.getElementById('newpass1').type = 'password';
            document.getElementById('newpass2').type = 'password';
        }
    }

    function matchesPass()
    {
        if($("#newpass1").val() == $("#newpass2").val())
        {
            $("#newpassmatchesok").css('display','inline');
            $("#newpassmatcheserror").css('display','none');
        }
        else
        {
            $("#newpassmatcheserror").css('display','inline');
            $("#newpassmatchesok").css('display','none');
        }
    }

    function saveNewPass()
    {
        $.ajax({
            type: "POST",
            data: $('#user_id, #newpass1, #newpass2, #oldpass'),
            url: "/ajax/savenewpass",
            dataType: "json",
            success: function(data)
            {
                if(data.result)
                {
                    location.replace('/admin/user/edit/<?= $userdata[0]->id ?>');
                }
            }
        })
    }
</script>