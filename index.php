<?php get_header(); ?>

<?php if (is_home()) { ?>

<script type="text/javascript" 
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAC9G-I3g4tWPbXK-v_Ws_1_dY4V8w6Eew&amp;sensor=false">
</script>

<script type="text/javascript">
	var map;
	var infowindow;
    
    var mapOptions = {
      center: new google.maps.LatLng(49.748398, 13.377652),
      zoom: 13
    };
	
    var bodyVMape = [
    	<?php echo kv_MapaData() ?>
    ];
    
    var markers = [];

	function kv_zmenaViditelnostiSkupiny(id) {
		var checked = document.getElementById("kv_category" + id).checked;
		
		for (i=0; i<markers.length; i++) {
			if (markers[i].category == id) {
				if (checked) {
					markers[i].setMap(map);
				} else {
					markers[i].setMap(null);
				}
			}
		}
	}

  function initialize() {
  	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  	
  	var styles = [ { featureType: "poi", stylers: [ { visibility: "off" } ] } ];
  	map.setOptions({styles: styles});
  
    for (i = 0; i < bodyVMape.length; i++) {

		var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(bodyVMape[i][1], bodyVMape[i][2]),
		    map: map,
		    icon: bodyVMape[i][4],
		    title: bodyVMape[i][5]
		});
		marker.category = bodyVMape[i][3];
		
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            	if (infowindow) {
            		infowindow.close();
            	}
            
	            infowindow = new google.maps.InfoWindow({
	      			content: bodyVMape[i][0]
	  			});
              	infowindow.open(map, marker);
            }
        })(marker, i));
        
        // Pokud nemá být objekt vidět, skryjeme jej.
        if (bodyVMape[i][6] == 0) {
        	marker.setMap(null);
        }
        
        markers.push(marker);
  	}
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="legenda">
	<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" id="logo" alt="" />
	
	<div id="legenda-content">
		<p><strong>Křížky a vetřelci</strong> mapují drobné památky na území města Plzně.</p>
		
		<p>Chybí v mapě objekt? Chcete se zapojit? <a href="mailto:krizkyavetrelci@email.cz">Napište nám</a>!</p>
	
		<div style="margin-bottom: 8px;"><strong>Legenda</strong></div>
		<?php echo kv_MapaLegenda() ?>
		
		<p><strong>Počet objektů</strong>: <?php echo kv_ObjektPocet() ?> </p>
		
		<p id="facebook"><a href="https://www.facebook.com/groups/krizkyavetrelci/" title="Sledujte nás na Facebooku">
			<img src="<?php bloginfo('template_directory'); ?>/images/facebook-32.png" alt="" /></a></p>
			
		<h3>Podpora</h3>
		
		<p>Projekt Křížky a vetřelci je jedním z vítězných projektů programu 
			<a href="http://www.verejnyprostorvplzni.cz/pestuj-prostor">Pěstuj prostor</a> v rámci 
			<a href="http://www.plzen2015.cz/">Plzeň 2015</a> &ndash; Evropské hlavní město kultury.
		</p>
		
		<p><a href="http://www.plzen2015.cz/" title="Plzeň 2015 - Evropské hlavní město kultury">
			<img src="<?php bloginfo('template_directory'); ?>/images/p-plzen2015.png" alt="" /></a>
		</p>
	</div>	
</div>
<div id="map-canvas"></div>
	
<?php } else { ?>	

<div id="content">

<?php		
	while ( have_posts() ) : the_post();
		the_title('<h1>', '</h1>');	
		the_content();
	endwhile;
?>

</div>	
	
<?php } ?>
	
<?php get_footer(); ?>