<div id="reg-inline">
    <h2>Регистрация</h2>
    <form action="/auth/reg" method="post">            
        <input type="text" name="login" id="reg_username" class="text" placeholder="Логин (необязательно)"><img src="/images/admin/ok.png" id="trueimg1" style="display:none"><img src="/images/admin/error.png" id="falseimg1" style="display:none">            
        <input type="text" name="email" id="reg_email" class="text" placeholder="E-mail"><img src="/images/admin/ok.png" id="trueimg2" style="display:none"><img src="/images/admin/error.png" id="falseimg2" style="display:none">           
        <h2>Личные данные</h2>
        <input type="text" id="reg_name" name="name" class="text" placeholder="Имя">           
        <input type="text" id="reg_lastname" name="lastname" class="text" placeholder="Фамилия">           
        <h2>Адресные данные</h2>
        <input type="text" id="reg_city" name="city" class="text" placeholder="Город">            
        <input type="text" id="reg_postcode" name="postcode" class="text" placeholder="Почтовый индекс">           
        <input type="text" id="reg_address" name="address" class="text" placeholder="Адрес">  
        <br><br>
        <input type="checkbox" checked="checked" name="newsletter" value="1">
        <label for="newsletter">Хочу получать новости<br> о проходящих акциях на E-mail</label> 
        <br><br>
        <input type="submit" value="Вперед" name="btnsubmit">
    </form>
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
