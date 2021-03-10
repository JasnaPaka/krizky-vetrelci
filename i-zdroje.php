<?php if (count($zdroje) > 0) { ?>

	<div id="zdroje">
		<hr />
		<h3>Literatura a prameny</h3>
		<p><ul>
			<?php
			foreach ($zdroje as $zdroj) {
				printf("<li>");
				if (strlen($zdroj->typ) > 0 && strlen($zdroj->nazev) < 2) {
					$sc = $controller->getSourceType($zdroj->typ);
					printf('<a href="%s">%s</a>', strlen($zdroj->url) > 2 ? $zdroj->url : sprintf($sc->getUrl(), $zdroj->identifikator),
						sprintf($sc->getDescription(), $controller->getSourceName()));
				} else if (strlen($zdroj->url) > 0) {
					print('<a href="'.$zdroj->url.'">'.$zdroj->nazev.'</a>');
				} else {
					printf($zdroj->nazev);
				}

				if (strlen($zdroj->typ) > 0 && $controller->getIsKniha($zdroj->typ)) {
					printf(' ISBN: '.$zdroj->identifikator.'. Zjistit dostupnost v: <a 
                            href="http://aleph.svkpk.cz/F/?func=find-d&find_code=ISN&request='.str_replace("-","",$zdroj->identifikator).'">
                            Studijní a vědecká knihovna Plzeňskeho kraje</a>');
				}

				printf("</li>");
			}
			?>
		</ul>
		</p>
	</div>

<?php } ?>