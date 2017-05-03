<?php if($id): ?>
	<?= Tags::get_block($id, 1) ?>
	<?= Related::get_related($id) ?>
<?php endif; ?>
