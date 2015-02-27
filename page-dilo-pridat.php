<?php 
	$ROOT = plugin_dir_path( __FILE__ )."../../plugins/wpcity/";
	include_once $ROOT."controllers/ObjectController.php";
	
	$controller = new ObjectController();

	if (isset($_POST["dilo_submit"])) {
		$objekt = $controller->addPublic();
	} else {
		$objekt = $controller->getInitPublicForm();
	}

	get_header();
?>

<div id="page" class="index podnet pridat-dilo">
<div class="inner">
<div class="padding">

<h2>Přidat dílo</h2>

<?php include_once $ROOT."fw/templates/messages.php"; ?>
    
<p>Děkujeme za váš zájem o projekt Křížky a vetřelci. Za každý nově přidaný bod do mapy budeme rádi. Pro přidání můžete použít 
formulář níže nebo vše poslat na e-mail <a href="mailto:krizkyavetrelci@email.cz">krizkyavetrelci@email.cz</a>. </p>

<p>Budeme rádi za každou novou informaci či fotografii. U fotografií prosím respektujte autorský zákon a přidávejte jen fotografie, které jsou 
vaše vlastní či ke kterým vlastníte autorská práva. Pokud nebude domluveno jinak, budou fotografie na webu k dispozici pod
volnou licencí <a href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0</a>.</p>

<form class="rows" method="post" enctype="multipart/form-data">

<h3>O díle</h3>

<div class="row">
	<label for="nazev">Název díla:</label>
	<input name="nazev" id="nazev" class="regular-text" type="text" value="<?php echo $objekt->nazev ?>" maxlength="250" />
</div>

<div class="row">
	<label for="info">Informace o díle:</label>
	<textarea id="info" name="info"><?php echo $objekt->info ?></textarea>
	<p class="gray">Volitelně vložte libovolné informace o díle. </p>
</div>

<div class="row">
	<label>Fotografie:</label>
	<input type="file" id="photo1" name="photo1" /><br />
	<input type="file" id="photo2" name="photo2" /><br />
	<input type="file" id="photo3" name="photo3" />
	<p class="gray">Volitelně vložte fotografie díla. </p>
</div>

<h3>Umístění</h3>

<p>Klepněte do mapy, kde se dílo nachází.</p>

<div class="row" style="padding-left: 0px">
	<div id="map-canvas" style="height: 500px"></div>
	<?php echo $controller->getGoogleMapPointEditContent($objekt->latitude, $objekt->longitude); ?>
</div>	

<div class="row" style="display:none">
	<label for="latitude">Latitude:</label>
	<input name="latitude" id="latitude" class="regular-text" type="text" value="<?php if ($objekt->latitude != 0) echo $objekt->latitude ?>" maxlength="20" />
</div>
<div class="row" style="display:none">
	<label for="longitude">Longitude:</label>
	<input name="longitude" id="longitude" class="regular-text" type="text" value="<?php if ($objekt->longitude != 0) echo $objekt->longitude ?>" maxlength="20" />
</div>

<?php if (!is_user_logged_in()) { ?> 

<h3>O vás</h3>

<p>Pokud chcete, můžete vyplnit své jméno a být u fotek uvedeni jako autoři.</p>

<div class="row">
	<label for="author">Autor:</label>
	<input name="author" id="author" class="regular-text" type="text" value="<?php echo $objekt->author ?>" maxlength="250" />
</div>

<?php } ?>

<div id="pridat-button-div">
	<input class="button orange" name="dilo_submit" value="Přidat dílo" type="submit">
</div>


</form>
    
    
</div>
</div>
</div>

<?php get_footer(); ?>	
