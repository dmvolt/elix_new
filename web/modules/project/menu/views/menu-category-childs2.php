<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $key => $item): ?>
		
			<?php if ($item['childs'] AND $current_param_menu == $item['url']): ?>
				<?php foreach ($item['childs'] as $item2): ?>
					<li class="nav__li">
						<a href="<?= Data::_('lang_uri') ?><?= $item2['url'] ?>" class="nav__a <?php if ($item2['url'] == $url OR Data::_('lang_uri').$item2['url'] == $url): ?>active<?php endif; ?>">
							<?= $item2['descriptions'][Data::_('lang_id')]['title'] ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		
	<?php endforeach; ?>
<?php endif; ?>