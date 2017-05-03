<?php if($last_news): ?>
	<div class="news-wrapper clearfix">
		<div class="wide">
			<div class="h2"><a href="/news">Новости</a></div>
			<ul id="news-carousel">
				<?php foreach($last_news as $item): ?>
					<li>
						<div class="box short">
							<div class="box-content">
								<a class="box-header" href="<?= Data::_('lang_uri') . '/news/' . $item['alias'] ?>"><?= $item['descriptions'][Data::_('lang_id')]['title'] ?></a>
								<div class="date"><?= $item['date'] ?></div>
								<?= $item['descriptions'][Data::_('lang_id')]['teaser'] ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<a class="prev" href="#"></a>
			<a class="next" href="#"></a>
		</div>
	</div>
<?php endif; ?>