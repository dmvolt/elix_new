<?php if(count($breadcrumbs)>0): 
    $count = count($breadcrumbs)-1; ?>
    <div class="bread">
	    <?php foreach($breadcrumbs as $key => $item): ?>
			<?php if($key != $count): ?>
			    <a <?=$item['href'] ?> class="bread__link"><?=$item['name'] ?></a>
			<?php elseif($key == $count): ?>
			    <span class="bread__text"><?=$item['name'] ?></span>
			<?php endif; ?>
	    <?php endforeach; ?>
	</div>
<?php endif; ?>