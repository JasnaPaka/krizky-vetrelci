 <?php
	$identifier = $controller->getIdentifier();
	if ($identifier != -1) {
 ?>

	<div id="trvaly-odkaz" class="detail-blok">
		<hr />
		<h3>Trvalý odkaz</h3>
		<p><a href="<?php bloginfo('url'); ?>/katalog/polozka/<?php print $identifier ?>/">
			<?php bloginfo('url'); ?>/katalog/polozka/<?php print $identifier ?>/</a>
		(identifikátor: <?php print $identifier ?>)
		</p>
	</div>

 <?php } ?>