<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $item): ?>
		<a href="<?= Data::_('lang_uri') ?><?= $item['url'] ?>" class="header__nav-mobile__link <?php if ($item['url'] == $url OR Data::_('lang_uri').$item['url'] == $url): ?>active<?php endif; ?>">
			<?= $item['descriptions'][Data::_('lang_id')]['title'] ?>
		</a>
		<?php if ($item['childs']): ?>
			<div class="header__nav-mobile__submenu">
				<?php foreach ($item['childs'] as $item2): ?>
					<?php if ($item2['status']): ?>
						<a href="<?= Data::_('lang_uri') ?><?= $item2['url'] ?>" class="header__nav-mobile__link <?php if ($item2['url'] == $url OR Data::_('lang_uri').$item2['url'] == $url): ?>active<?php endif; ?>">
							<?= $item2['descriptions'][Data::_('lang_id')]['title'] ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>