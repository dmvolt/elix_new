<form id="fileupload" enctype="multipart/form-data">
	<div class="form_item_textarea">
		<input type="file" id="file" name="files[]" multiple >
		<a onclick="$('#fileupload').submit();" id="sub" class="btn_core btn_core_green btn_core_md" style="margin-right:25px; margin-bottom:15px;"><span><?= $text_file_upload ?></span></a>
		<a onclick="$('#fileupload').each(function(){this.reset();});" id="res" class="btn_core btn_core_green btn_core_md" style="margin-right:25px; margin-bottom:15px;"><span><?= $text_file_noupload ?></span></a>
		<input type="hidden" name="id" id="id" value="<?= $id ?>">
		<input type="hidden" name="module" id="module" value="<?= $module ?>">
	</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	getimages("<?= $module ?>");
	getfiles("<?= $module ?>");
	
	$("#sortable").sortable(
	{
		beforeStop: function(event, ui) { 
			savenewsort("<?= $module ?>");
		},
		cursor: 'crosshair',
		tolerance: 'pointer'		
	});
	
	var formData = $('#fileupload').serialize();
	var options = {
		type: "POST",
		data: formData,
		url: "/ajaxfiles/loadfiles",
		dataType: "json",
		iframe: true,
		beforeSend: function() {
			$('#res').after('<div class="wait"></div>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(data)
		{
			if(data.result)
			{
				getimages("<?= $module ?>");
				getfiles("<?= $module ?>");
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	}; 
	// bind 'fileupload' and provide a simple callback function 
	$('#fileupload').ajaxForm(options);
});
function getfiles(module)
{
	var formData = $('#fileupload').serialize();
	$.ajax({
		type: "POST",
		data: formData,
		url: "/ajaxfiles/getfiles",
		dataType: "json",
		success: function(data)
		{
			if(data)
			{
				$('.files_content').html(data);
			}
			else
			{
				$('.files_content').html('нет загруженных файлов');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}
function getimages(module)
{
	var formData = $('#fileupload').serialize();
	$.ajax({
		type: "POST",
		data: formData,
		url: "/ajaxfiles/getimages",
		dataType: "json",
		success: function(data)
		{
			if(data)
			{
				$('.images_content').html(data);
				//REText(module);
				checkLanguage(1);
			}
			else
			{
				$('.images_content').html('нет загруженных изображений');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}
function deletefile(id, module)
{
	var id = id;
	$.ajax({
		type: "POST",
		data: "id=" + id + "&content_id=" + $('#id').attr('value') + "&module=" + $('#module').attr('value'),
		url: "/ajaxfiles/deletefile",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				getfiles(module);
				getimages(module);
			}
		}
	})
}
function savenewsort(module)
{
	var newsortstring = $('#sortable').sortable('toArray');
	$.ajax({
		type: "POST",
		data: "newsortstring=" + newsortstring,
		url: "/ajaxfiles/savenewsort",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				//getfiles(module);
			}
		}
	})
}
</script>