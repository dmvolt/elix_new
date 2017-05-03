<?php if(count($breadcrumbs)>0): 
    $count = count($breadcrumbs)-1; ?>
    <div class="bread">
	    <?php foreach($breadcrumbs as $key => $item): ?>
			<?php if($key != $count): ?>
			    <a <?=$item['href'] ?> class="bread__link"><?=$item['name'] ?></a>
			<?php elseif($key == $count): ?>
			    <h1 class="bread__header"><?=$item['name'] ?></h1>
			<?php endif; ?>
	    <?php endforeach; ?>
	</div>
<?php endif; ?>