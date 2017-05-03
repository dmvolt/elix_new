<div class="pages center">
    <h2 class="title"><?= $page_title ?></h2>
    <div class="block">
        <?php if (isset($errors)) { ?>
            <p>
                <? foreach ($errors as $item) { ?>
                    <?= $item ?></br>
                <? } ?>
            </p>
        <? } ?>

        <form action="" method="post">
            <div class="form_item center" style="width:430px;">
                <input type="text" name="login" id="reg_username" class="form-text-big" placeholder="Придумайте себе логин (необязательно)"><img src="/images/admin/ok.png" id="trueimg1" style="display:none"><img src="/images/admin/error.png" id="falseimg1" style="display:none">
            </div>
            <div class="form_item center" style="width:430px;">
                <input type="text" name="email" id="reg_email" class="form-text-big" placeholder="Адрес вашей электронной почты"><img src="/images/admin/ok.png" id="trueimg2" style="display:none"><img src="/images/admin/error.png" id="falseimg2" style="display:none">
            </div>
            </br>

            <div class="form_item center" style="width:430px;">
                <p class="title">Личные данные</p><label>(можете заполнить эти поля позже в своем личном кабинете)</label>
                <input type="text" id="reg_name" name="name" class="form-text-big" placeholder="<?= $text_market_checkout_name ?>">
            </div>

            <div class="form_item center" style="width:430px;">
                <input type="text" id="reg_lastname" name="lastname" class="form-text-big" placeholder="<?= $text_market_checkout_lastname ?>">
            </div>
            </br>

            <div class="form_item center" style="width:430px;">
                <p class="title">Адресные данные</p><label>(можете заполнить эти поля позже в своем личном кабинете)</label>
                <input type="text" id="reg_city" name="city" class="form-text-big" placeholder="<?= $text_market_checkout_city ?>">
            </div>

            <div class="form_item center" style="width:430px;">
                <input type="text" id="reg_postcode" name="postcode" class="form-text-big" placeholder="<?= $text_market_checkout_postcode ?>">
            </div>

            <div class="form_item center" style="width:430px;">
                <input type="text" id="reg_address" name="address" class="form-text-big" placeholder="<?= $text_market_checkout_address ?>">
            </div>

            <div class="form_item center">
                <input type="checkbox" checked="checked" name="newsletter" value="1">
                <label for="newsletter"><?= $text_market_checkout_newsletter ?></label>
            </div>
            <input type="submit" value="Вперед" name="btnsubmit"  class="form_submit_md center">
        </form>
    </div>
</div>				
<script type="text/javascript">
    $(document).ready(function(){
        $("#reg_username").blur(vlogin);
        $("#reg_email").blur(vemail);
    });
</script>

<script type="text/javascript">	
    function vlogin()
    {
        var username = $("#reg_username").val();
	
        $.ajax({
            type: "POST",
            data: "username=" + username,
            url: "/ajax/loginunique",
            dataType: "json",
            success: function(data)
            {
                if(data.result)
                {
                    $("#trueimg1").css('display','inline');
                    $("#falseimg1").css('display','none');
                }
                else
                {
                    $("#falseimg1").css('display','inline');
                    $("#trueimg1").css('display','none');
                }
            }
        })
    }
</script>

<script type="text/javascript">	
    function vemail()
    {
        var email = $("#reg_email").val();
	
        $.ajax({
            type: "POST",
            data: "email=" + email,
            url: "/ajax/emailunique",
            dataType: "json",
            success: function(data)
            {
                if(data.result)
                {
                    $("#trueimg2").css('display','inline');
                    $("#falseimg2").css('display','none');
                }
                else
                {
                    $("#falseimg2").css('display','inline');
                    $("#trueimg2").css('display','none');
                }
            }
        })
    }
</script>
