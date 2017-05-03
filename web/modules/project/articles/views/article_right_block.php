<?php if($contents): ?>
	<div class="main_col__news-all">
		<h2><a href="/articles">Статьи</a></h2>
		<?php foreach($contents as $value): ?>
			<div class="main_col__news">
				<?php if($value['thumb']): ?>
					<img src="<?= Im::imagepath('preview4', $value['thumb']) ?>" alt="" class="main_col__news__bgi"> <!-- 180 X 250 -->
				<?php endif; ?>
				<div class="main_col__news__content">
					<h3><a href="<?= Data::_('lang_uri') . '/articles/' . $value['alias'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['title'] ?></a></h3>
					<?= $value['edit_interface'] ?>
					<div id="articles_content_<?= $value['id'] ?>"><?= $value['descriptions'][Data::_('lang_id')]['teaser'] ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>