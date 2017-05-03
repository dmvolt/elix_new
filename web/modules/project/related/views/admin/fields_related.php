<div class="form_item">
    <h2 class="title">Офисы (ID перечисленые через запятую)</h2>
	<label>Начните вводить название офиса и выберите из найденых вариантов</label><br>
    <input type="text" id="related" name="related" value="<?= $field ?>" class="text" style="width:650px">
</div>

<script type="text/javascript">
$('#related')
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
			url: '/ajax/autocomplete?module=partners&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			beforeSend: function() {
				$('#related').css({'background':'url(/images/admin/loader.gif)right no-repeat'});
			},
			success: function(json) {
				$('#related').css({'background':'none'});
				response($.map(json, function(item) {
					return { 
				        label: item.name,
						value: item.id
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
          terms.push(ui.item.value);
          // add placeholder to get the comma-and-space at the end
          terms.push('');
          this.value = terms.join(',');
		return false;
	}
});
</script>