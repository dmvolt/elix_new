<?php if (count($menu) > 0): ?>
	<nav class="menu pos-sticky">
		<div class="menu__header"><a href="/services">Услуги</a></div>
		<ul id="js-lava"  class="menu__list">
			<?php foreach ($menu as $item): ?>
				<li class="menu__item<?php if ($item['url'] == $url): ?> active<?php endif; ?><?php if ($item['children']): ?> nav__item--nested<?php endif; ?>"><a href="<?= Data::_('lang_uri') ?><?= $item['url'] ?>" class="menu__link"><img src="<?= PARENT_FULLURL ?>/images/elix.svg" alt="" class="icon icon--big js-svg"> <?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
				
					<!--<?php //if ($item['children']): ?>
						<ul class="nav__sub">
							<?php //foreach ($item['children'] as $value): ?>
								<li class="nav__sub-item">
									<a href="<?//= Data::_('lang_uri') ?><?//= $value['url'] ?>" class="nav__sub-link"><?//= $value['descriptions'][Data::_('lang_id')]['title'] ?></a>
								</li>
							<?php //endforeach; ?>
						</ul>
					<?php //endif; ?>-->
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif; ?>