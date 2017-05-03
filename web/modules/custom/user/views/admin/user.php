<? if (isset($errors)) { ?>
    <? foreach ($errors as $item) { ?>
        <p style="color:red"><?= $item ?></p>
    <? } ?>
<? } ?> 

<div>
    <h2 class="title"><?= $text_users ?> <a href="/admin/user/add" title="<?= $text_add_new_user ?>"><img src="/images/admin/add.png" style="margin-bottom:-10px;"></a></h2>

    <table>
        <thead>
            <tr>
                <td><strong><?= $text_user_thead_name ?></strong></td>
                <td><strong><?= $text_user_thead_role ?></strong></td>
                <td><strong><?= $text_user_thead_email ?></strong></td>
                <td><strong><?= $text_user_thead_status ?></strong></td>
                <td class="last"><strong><?= $text_user_thead_action ?></strong></td>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($contents)): ?>
                <?php foreach ($contents as $key => $value): ?>
                    <?php if ($value['role_id']): ?>
                        <tr>
                            <td class="first"><?= $value['username'] ?></td>

                            <?php $roles = kohana::$config->load('admin/user.roles'); ?>

                            <td><?= $roles[$value['role_id']]['name'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <?php if ($value['status']): ?>
                                <td><span style="color:green"><?= $text_active ?></span></td>
                            <?php else: ?>
                                <td><span style="color:red"><?= $text_inactive ?></span></td>
                            <?php endif; ?>
                            <td class="last"><a href="/admin/user/edit/<?= $value['id'] ?>" class="edit"><?= $text_edit ?></a>&nbsp;&nbsp;<a href="/admin/user/delete/<?= $value['id'] ?>" class="delete"><?= $text_delete_img ?></a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?> 
            <?php endif; ?> 
        </tbody>
    </table>

</div>

<script type="text/javascript">
    function userlist()
    {
        var email = $("#email").val();
        var role_id = $("#role_id").val();

		
        $.ajax({
            type: "POST",
            data: "email =" +  email,
            url: "/ajax/get_userlist",
            dataType: "json",
            success: function(data)
            {
                if(data.result)
                {
                    document.getElementById('alias').value = data.result;
                }
                else
                {
                    document.getElementById('alias').value = 'no-alias';
                }
            }
        })
		
    }
</script>