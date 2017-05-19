<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $item): ?>
		<li class="mobile-menu__item<?php if ($item['url'] == $url): ?> active<?php endif; ?>"><a href="<?= Data::_('lang_uri') ?><?= $item['url'] ?>" class="mobile-menu__link<?php if ($item['children']): ?> js-toggle-button<?php endif; ?>" <?php if ($item['children']): ?> data-target="#sublist-<?= $item['id'] ?>"<?php endif; ?>><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
			<?php if ($item['children']): ?>
				<ul id="sublist-<?= $item['id'] ?>" class="mobile-menu__sub-list js-toggle">
					<?php foreach ($item['children'] as $value): ?>
						<li class="mobile-menu__sub-item">
							<a href="<?= Data::_('lang_uri') ?><?= $value['url'] ?>" class="mobile-menu__link"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
<?php endif; ?>