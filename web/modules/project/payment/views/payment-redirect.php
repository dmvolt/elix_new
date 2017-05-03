<article>
	<h2>Ваш заказ №<?= $payment_form_data['order_id'] ?> успешно создан! Через ..<span id="scd">9</span>.. секунд произойдет автоматическая переадресация на страницу оплаты. Если переадресация не произошла, перейдите по ссылке <a href="#" onclick="$('#payment_redirect_form').submit();">оплатить заказ</a>.</h2>
	<form id="payment_redirect_form" name="ShopForm" method="post" action="<?= $service_url ?>">
		<input name="shopId" value="<?= $payment_form_data['shop_id'] ?>" type="hidden"> <!-- Идентификатор Контрагента, выдается Оператором -->
		<input name="scid" value="<?= $payment_form_data['scid'] ?>" type="hidden"> <!-- Номер витрины Контрагента, выдается Оператором -->
		<input name="sum" value="<?= $payment_form_data['sum'] ?>" type="hidden"> <!-- Стоимость заказа -->
		<input name="customerNumber" value="<?= $payment_form_data['user_email'] ?>" type="hidden"> <!-- Идентификатор плательщика в ИС Контрагента. В качестве идентификатора может использоваться номер договора плательщика, логин плательщика и т. п. Возможна повторная оплата по одному и тому же идентификатору плательщика -->
		  
		<!-- Необязательные поля --> 
		<!--<input name="shopArticleId" value="" type="hidden"> -->
		<input name="paymentType" value="<?= $payment_form_data['payment_type'] ?>" type="hidden"> <!-- Способ оплаты. Например: PC — оплата из кошелька в Яндекс.Деньгах, AC — оплата с произвольной банковской карты -->
		<input name="orderNumber" value="<?= $payment_form_data['order_id'] ?>" type="hidden"> <!-- Уникальный номер заказа в ИС Контрагента -->
		<input name="cps_phone" value="<?= $payment_form_data['user_phone'] ?>" type="hidden"> 
		<input name="cps_email" value="<?= $payment_form_data['user_email'] ?>" type="hidden"> 
		
		<input type="hidden" name="custName" value="<?= $payment_form_data['user_name'] ?>"> <!-- Ф.И.О. заказчика -->
		<input type="hidden" name="custEmail" value="<?= $payment_form_data['user_email'] ?>"> <!-- E-mail заказчика -->
		<input type="hidden" name="custAddr" value="<?= $payment_form_data['user_address'] ?>"> <!-- Адрес доставки -->
		<input type="hidden" name="orderDetails" value="<?= $payment_form_data['formcomment'] ?>"> <!-- Содержание заказа -->
		
		<input type="hidden" name="shopSuccessURL" value="<?= $payment_form_data['success_url'] ?>">
		<input type="hidden" name="shopFailURL" value="<?= $payment_form_data['fail_url'] ?>">
	</form>
</article>
<script type="text/javascript">
$(document).ready(function(){
	var interval = 1;
	var i = 9;
	setInterval( function() { 
		if(i > 0){i = i - interval;}  
		$('#scd').html(i); 
	} , 1000);
	
	window.setTimeout(function(){
		$('#payment_redirect_form').submit();
	}, 9000);
});
</script>