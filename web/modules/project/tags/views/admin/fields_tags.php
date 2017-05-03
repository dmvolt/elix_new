<div class="form_item">
	<a href="/admin/tags" target="_blank" class="right margin_right25">Все теги</a>
    <h2 class="title"><?= $group['name'] ?></h2>
	<label>Начните вводить название тега и выберите из найденых вариантов</label><br>
	<?php if(isset($languages)): ?>
		<?php foreach ($languages as $item): ?>
			<?= $item['icon']?><br><input type="text" id="tags_<?= $group['group_id'] ?>_input_lang_<?= $item['lang_id'] ?>" name="tags[<?= $group['group_id'] ?>][<?= $item['lang_id'] ?>]" value="<?= $field[$item['lang_id']] ?>" class="text" style="width:650px">
		
			<script type="text/javascript">
			$('#tags_<?= $group['group_id'] ?>_input_lang_<?= $item['lang_id'] ?>')
			// don't navigate away from the field on tab when selecting an item
			.bind('keydown', function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data('ui-autocomplete').menu.active ) {
			  event.preventDefault();
			}
			})
			.autocomplete({
				delay: 0,
				autoFocus: true,
				minLength: 1,
				source: function(request, response) {
					$.ajax({
						url: '/ajax/autocomplete?module=tags&group_id=<?= $group['group_id'] ?>&lang_id=<?= $item['lang_id'] ?>&filter_name=' + encodeURIComponent(request.term),
						dataType: 'json',
						beforeSend: function() {
							$('#tags_<?= $group['group_id'] ?>_input_lang_<?= $item['lang_id'] ?>').css({'background':'url(/images/admin/loader.gif)right no-repeat'});
						},
						success: function(json) {
							$('#tags_<?= $group['group_id'] ?>_input_lang_<?= $item['lang_id'] ?>').css({'background':'none'});
							response($.map(json, function(item) {
								return { 
									label: item.name,
									value: item.name
								}
							}));
						}
					});
				},
				focus: function() {
				  // prevent value inserted on focus
				  return false;
				},
				select: function(event, ui) {
					var terms = split( this.value ); //$('input[name=\'related\']').val(ui.item.value);
					terms.pop();
					  // add the selected item
					  terms.push( ui.item.value );
					  // add placeholder to get the comma-and-space at the end
					  terms.push('');
					  this.value = terms.join(', ');
					return false;
				}
			});
			</script>	
		<?php endforeach; ?>
	<?php else: ?>
		<input type="text" id="tags_<?= $group['group_id'] ?>" name="tags[<?= $group['group_id'] ?>][1]" value="<?= $field[1] ?>" class="text" style="width:650px">
		
		<script type="text/javascript">
			$('#tags_<?= $group['group_id'] ?>')
			// don't navigate away from the field on tab when selecting an item
			.bind('keydown', function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data('ui-autocomplete').menu.active ) {
			  event.preventDefault();
			}
			})
			.autocomplete({
				delay: 0,
				autoFocus: true,
				minLength: 1,
				source: function(request, response) {
					$.ajax({
						url: '/ajax/autocomplete?module=tags&group_id=<?= $group['group_id'] ?>&filter_name=' + encodeURIComponent(request.term),
						dataType: 'json',
						beforeSend: function() {
							$('#tags_<?= $group['group_id'] ?>').css({'background':'url(/images/admin/loader.gif)right no-repeat'});
						},
						success: function(json) {		
							$('#tags_<?= $group['group_id'] ?>').css({'background':'none'});
							response($.map(json, function(item) {
								return { 
									label: item.name,
									value: item.name
								}
							}));
						}
					});
				},
				focus: function() {
				  // prevent value inserted on focus
				  return false;
				},
				select: function(event, ui) {
					var terms = split( this.value );
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push('');
					this.value = terms.join(', ');
					return false;
				}
			});
		</script>
		
	<?php endif; ?>
</div>
