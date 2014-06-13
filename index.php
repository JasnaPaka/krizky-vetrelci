<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta name="description" content="Křížky a vetřelci, přehled drobných památek na území města Plzně." />
  	<meta name="keywords" content="plzeň,sakrální památky, normalizace, sorela, sochy, kříže, kapličky" />
  	<meta name="author" content="Pavel Cvrček | jasnapaka@jasnapaka.com" />
	
	<title>Křížky a vetřelci</title>
	
	<link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" title="Základní styl" />
	
	<script type="text/javascript" 
    	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAC9G-I3g4tWPbXK-v_Ws_1_dY4V8w6Eew&amp;sensor=false">
    </script>
    
    <script type="text/javascript">
		var map;
        
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
		            var infowindow = new google.maps.InfoWindow({
		      			content: bodyVMape[i][0]
		  			});
	              	infowindow.open(map, marker);
	            }
	        })(marker, i));
	        
	        markers.push(marker);
	  	}
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
	<div id="legenda">
		<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" id="logo" alt="" />
		
		<p style="color: red">Pracovní verze</p>
		
		<p><strong>Křížky a vetřelci</strong> mapují drobné památky na území města Plzně.</p>
		
		<p>Chybí v mapě objekt? Chcete se zapojit? <a href="mailto:krizkyavetrelci@email.cz">Napište nám</a>!</p>
	
		<div style="margin-bottom: 8px;"><strong>Legenda</strong></div>
		<?php echo kv_MapaLegenda() ?>
		
		<p><strong>Počet objektů</strong>: <?php echo kv_ObjektPocet() ?> </p>
		
		<p id="facebook"><a href="https://www.facebook.com/groups/krizkyavetrelci/" title="Sledujte nás na Facebooku">
			<img src="<?php bloginfo('template_directory'); ?>/images/facebook-32.png" alt="" /></a></p>
	</div>
	<div id="map-canvas"></div>
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-51854113-1', 'jasnapaka.com');
	  ga('send', 'pageview');
	
	</script>
</body>
</html>