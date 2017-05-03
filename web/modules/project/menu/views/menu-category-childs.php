<?php if (count($menu) > 0): ?>
	<?php foreach ($menu as $key => $item): ?>
		<div class="m-menu">
			<div class="m-menu__button"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></div>
		
			<?php if ($item['childs']): ?>
				<div class="m-menu__list">
					<ul class="m-menu__ul">
						<?php foreach ($item['childs'] as $item2): ?>
							<li class="m-menu__li">
								<a href="<?= Data::_('lang_uri') ?><?= $item2['url'] ?>" class="<?php if ($item2['url'] == $url OR Data::_('lang_uri').$item2['url'] == $url): ?>active<?php endif; ?>">
									<?= $item2['descriptions'][Data::_('lang_id')]['title'] ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>