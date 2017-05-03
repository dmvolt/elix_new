<!-- Clips Modal HTML -->
<div id="clipsmodal" style="display: none;">
	<section>
		<ul class="redactor_clips_box">
			<li>
				<a href="#" class="redactor_clip_link">Блок с эфектом "Аккордион"</a>
				<div class="redactor_clip" style="display: none;">
					<div class="accordion">
						<h2>First</h2>
						<p>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.ntium nisi quae ab ex asperiores suscipit labore mollitia quos voluptate. Voluptate, unde inventore architecto ad vero repudiandae illum officia eaque ipsam accusantium.</p>
						<h2>First</h2>
						<p>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.ntium nisi quae ab ex asperiores suscipit labore mollitia quos voluptate. Voluptate, unde inventore architecto ad vero repudiandae illum officia eaque ipsam accusantium.</p>
						<h2>First</h2>
						<p>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.ntium nisi quae ab ex asperiores suscipit labore mollitia quos voluptate. Voluptate, unde inventore architecto ad vero repudiandae illum officia eaque ipsam accusantium.</p>
						<h2>First</h2>
						<p>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.ntium nisi quae ab ex asperiores suscipit labore mollitia quos voluptate. Voluptate, unde inventore architecto ad vero repudiandae illum officia eaque ipsam accusantium.</p>
					</div>
				</div>
			</li>
		</ul>
	</section>
</div>
<script type="text/javascript">
function clickToEdit(module, Id, field, air)
{
	$('.accordion').accordion('destroy');
	
	$('#' + module + '_' + field + '_' + Id).redactor({
		focus: true,
		allowedTags: [
						'a', 
						'p', 
						'strong', 
						'hr', 
						'br', 
						'mark', 
						'blockquote', 
						'span', 
						'li', 
						'ul', 
						'ol', 
						'img', 
						'table', 
						'tr', 
						'td', 
						'iframe',
						'b', 
						'em',
						'i',
						'h1', 
						'h2', 
						'h3', 
						'h4', 
						'h5', 
						'h6', 
						'div'
					],
		lang: 'ru',
		convertDivs: false,
		paragraphy: false,
		plugins: ['fontcolor', 'fontfamily', 'fontsize', 'clips'],
		observeLinks: true,
		convertVideoLinks: true,
		convertImageLinks: true,
		air: air,
		imageUpload: '/liteedit/load_image_in_text',
		fileUpload: '/liteedit/load_file_in_text'
	});
	$('#save_' + module + '_' + Id + '_' + field).show();
}

function clickToSave(module, Id, langId, field)
{
	// save content if you need
	var html = $('#' + module + '_' + field + '_' + Id).redactor('get');
	
	$.ajax({
		type: 'POST',
		data: 'module=' + module + '&id=' + Id + '&lang_id=' + langId + '&field=' + field + '&html=' + html,
		url: '/liteedit/editfield',
		dataType: 'json',
		beforeSend: function() {
			$('#save_' + module + '_' + Id + '_' + field).hide();
			$('#loading_' + module + '_' + Id + '_' + field).show();
		},		
		complete: function() {
			$('#loading_' + module + '_' + Id + '_' + field).hide();
		},			
		success: function(data)
		{
			if(data.result)
			{
				$('#success_' + module + '_' + Id + '_' + field).show();
				$('#success_' + module + '_' + Id + '_' + field).html(data.result);
				// destroy editor
				$('#' + module + '_' + field + '_' + Id).redactor('destroy');
				
				$('.accordion').accordion({
					heightStyle: "content"
				});
				
				window.setTimeout(function(){ $('#success_' + module + '_' + Id + '_' + field).hide(200) }, 3000);			
			}
			else
			{
				$('#success_' + module + '_' + Id + '_' + field).show();
				$('#success_' + module + '_' + Id + '_' + field).html('не получилось, попробуйте еще раз.');
				window.setTimeout(function(){ $('#success_' + module + '_' + Id + '_' + field).hide(200) }, 3000);	
				$('#save_' + module + '_' + Id + '_' + field).show();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
}
</script>