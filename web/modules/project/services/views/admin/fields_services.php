<?php if($wrapper):?>
	<div class="form_item">
		<h2 class="title">Раздел</h2>
		<select name="serviceId1[]" <?= $multiple ?> style="width:200px; height:100px;">
			<option value=""> -- нет -- </option>
			<?php if ($select_services): ?>
				<?php foreach ($select_services as $value):?>
					
					<?php if (is_array($parent)): ?>
						<option value="<?= $value['service']['id'] ?>"<?php if (isset($parent[$value['service']['id']])): ?> selected<?php endif; ?>><?= $value['service']['descriptions'][1]['title'] ?></option>
					<?php else: ?>
						<option value="<?= $value['service']['id'] ?>"<?php if ($value['service']['id'] == $parent): ?> selected<?php endif; ?>><?= $value['service']['descriptions'][1]['title'] ?></option>
					<?php endif; ?>
					
					
					<?php if ($value['children']): ?>
						<?php foreach ($value['children'] as $value2):?>
						
							<?php if (is_array($parent)): ?>
								<option value="<?= $value2['service']['id'] ?>"<?php if (isset($parent[$value2['service']['id']])): ?> selected<?php endif; ?>> - <?= $value2['service']['descriptions'][1]['title'] ?></option>
							<?php else: ?>
								<option value="<?= $value2['service']['id'] ?>"<?php if ($value2['service']['id'] == $parent): ?> selected<?php endif; ?>> - <?= $value2['service']['descriptions'][1]['title'] ?></option>
							<?php endif; ?>
					
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
	</div>
<?php else:?>
	<select name="serviceId1[]" <?= $multiple ?> style="width:200px;">
		<option value=""> -- нет -- </option>
		<?php if ($select_services): ?>
			<?php foreach ($select_services as $value):?>
				
				<?php if (is_array($parent)): ?>
					<option value="<?= $value['service']['id'] ?>"<?php if (isset($parent[$value['service']['id']])): ?> selected<?php endif; ?>><?= $value['service']['descriptions'][1]['title'] ?></option>
				<?php else: ?>
					<option value="<?= $value['service']['id'] ?>"<?php if ($value['service']['id'] == $parent): ?> selected<?php endif; ?>><?= $value['service']['descriptions'][1]['title'] ?></option>
				<?php endif; ?>
				
				
				<?php if ($value['children']): ?>
					<?php foreach ($value['children'] as $value2):?>
					
						<?php if (is_array($parent)): ?>
							<option value="<?= $value2['service']['id'] ?>"<?php if (isset($parent[$value2['service']['id']])): ?> selected<?php endif; ?>> - <?= $value2['service']['descriptions'][1]['title'] ?></option>
						<?php else: ?>
							<option value="<?= $value2['service']['id'] ?>"<?php if ($value2['service']['id'] == $parent): ?> selected<?php endif; ?>> - <?= $value2['service']['descriptions'][1]['title'] ?></option>
						<?php endif; ?>
				
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
<?php endif;?>