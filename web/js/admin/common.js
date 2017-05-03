$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
	$( "#lang_button" ).buttonset();
});
$(function() {
	$.datepicker.setDefaults(
		{dateFormat:'yy-mm-dd'}
	);
	$("#datepicker").datepicker();
});

function split(val) {
  return val.split(/,\s*/);
}

function extractLast( term ) {
  return split( term ).pop();
} 

function checkboxStatus(id){
	if(document.getElementById('status_' + id).checked){
		$('#statusfield_' + id).attr('value', 1);
	}else{
	   $('#statusfield_' + id).attr('value', 0);
	}
}
function REText(module){	
	if(module == 'banners')	{
		//$('.filename label').html('Ссылка');
		//$('.filedescription').hide();
		$('.filename input').css({'width':'300px', 'margin-bottom':'20px'});
	}	
}
function displayPages(){	
	if(document.getElementById('display_all').checked)
	{
		$('#display_pages_block').hide(100);
	}
	else
	{
		$('#display_pages_block').show(200);
	}		
}
function generatealias()
{
	var name = $('[id^="name"]').val();	
	if(!name){
		var name = $('#name').val();
	}
	if(document.getElementById('autoalias').checked)
	{
		$.ajax({
			type: "POST",
			data: "name=" + name,
			url: "/ajax/generatealias",
			dataType: "json",
			success: function(data)
			{
				if(data.result)
				{
					$("#alias").attr('value', data.result);
				}
			}
		})
	}
}
function generateanons(){
	var name = $('[id^="editor2"]').val();	
	if(!name){
		var name = $('#editor2').val();
	}
	if(document.getElementById('autoteaser').checked)
	{
		$.ajax({
			type: "POST",
			data: "name=" + name,
			url: "/ajax/generateanons",
			dataType: "json",
			success: function(data)
			{
				if(data.result)
				{
					$("#editor1").attr('value', data.result);
				}
			}
		})
	}
}
function goPost(){
	var form_data = $('#newsletter_page').serialize();
	$.ajax({
		type: "POST",
		data: form_data,
		url: "/admin/newsletter/go",
		dataType: "json",
		beforeSend: function() {
			$("#loading").css({'display':'inline'});
		},		
		complete: function() {
			$("#loading").css({'display':'none'});
		},			
		success: function(data)
		{
			if(data.result)
			{
				$("#success").html(data.result);
			}
			else
			{
				$("#success").html('no');
			}
		}
	});
}
function replyToComment(id){
	$('#reply_form_' + id).show(200);
}