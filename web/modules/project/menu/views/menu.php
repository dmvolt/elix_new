<?php if (count($menu) > 0): ?>
	<ul class="categories">
		<?php foreach ($menu as $item): ?>
			<li class="category"><a href="<?= Data::_('lang_uri') ?><?= $item['url'] ?>" <?php if ($item['url'] == $url): ?>class="active"<?php endif; ?>><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
				<?php if ($item['children']): ?>
					<ul class="sub-menu" style="display: none;">
						<?php foreach ($item['children'] as $value): ?>
							<li><a href="<?= Data::_('lang_uri') ?><?= $value['url'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>