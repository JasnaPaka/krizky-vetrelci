<div class="topMenu">
		<div>
			<h1>Kategorie</h1>
			<h2><?php printf('<a href="/katalog/kategorie/%s/" title="Přehled všech děl v kategorii">%s</a>', 
						$kategorie->id, $kategorie->nazev); ?></h2> 
			<div class="space"></div>
			<h1>Přezdívka</h1>
			<h2>
				<?php
					if (strlen($objekt->prezdivka) > 2) {
						printf($objekt->prezdivka);	
					} else {
						printf('<em class="neevidovano">(není uvedena)</em>');
					}
				?>
			</h2>
		</div>
		<div>
			<h1>Autor</h1>
			<h2>
				<?php
					$isFirst = true;
					foreach ($autori as $autor) {
						if (!$isFirst) {
							printf(", ");	
						}
						printf('<a href="/katalog/autor/%s/" title="Informace o autorovi">%s</a>', 
							$autor->id, trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za));
						
						$isFirst = false;	
					}
					
					if (count($autori) == 0) {
						printf('<em class="neevidovano">(nejsou uvedeni)</em>');	
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>Přístupnost</h1>
			<h2>
				<?php
					if (strlen($objekt->pristupnost) > 2) {
						printf($objekt->pristupnost);	
					} else {
						printf('<em class="neevidovano">(není uvedena)</em>');	
					}
				?>
			</h2>
		</div>
		<div>
			<h1>Rok vzniku</h1>
			<h2>
				<?php
					if (strlen($objekt->rok_vzniku) > 2) {
						printf($objekt->rok_vzniku);	
					} else {
						printf('<em class="neevidovano">(není uveden)</em>');
					}
				?>
			</h2>
			<div class="space"></div>
			<h1>GPS</h1>
			<h2><?php printf(round($objekt->latitude, 6).",".round($objekt->longitude, 6)) ?></h2>
		</div>
		<div>
			<h1>Materiál</h1>
			<h2>
				<?php
					if (strlen($objekt->material) > 2) {
						printf($objekt->material);	
					} else {
						printf('<em class="neevidovano">(není uveden)</em>');	
					}
				?>			
			</h2>
			<div class="space"></div>
			<h1>Památková ochrana</h1>
			<h2>
				<?php
					if (strlen($objekt->pamatkova_ochrana) > 2) {
						printf('<a href="http://monumnet.npu.cz/pamfond/list.php?CiRejst='.$objekt->pamatkova_ochrana.'">'.$objekt->pamatkova_ochrana.'</a>');	
					} else {
						printf("ne");	
					}
				?>			
			</h2>
		</div>
	</div>