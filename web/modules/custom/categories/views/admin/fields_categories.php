<?php if($wrapper):?>
	<div class="form_item">
		<h2 class="title"><?= $group_cat[$dictionary_id]['name'] ?></h2>
		<select name="categoryId1[]" <?= $multiple ?> style="width:200px; height:100px;">
			<?php
			$tree = new Tree();
			$tree->selectOutTree($dictionary_id, 0, 1, $parent = (isset($parent)) ? $parent : 0); //Выводим дерево в элемент выбора 
			?>
		</select>
	</div>
<?php else:?>
	<select name="categoryId1[]" <?= $multiple ?> style="width:200px;">
		<?php
		$tree = new Tree();
		$tree->selectOutTree($dictionary_id, 0, 1, $parent = (isset($parent)) ? $parent : 0); //Выводим дерево в элемент выбора 
		?>
	</select>
<?php endif;?>