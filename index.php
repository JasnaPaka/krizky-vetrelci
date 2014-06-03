<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	
	<title>Křížky a vetřelci</title>
	
	<link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" title="Základní styl" />
	
	<script type="text/javascript" 
    	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAC9G-I3g4tWPbXK-v_Ws_1_dY4V8w6Eew&sensor=false">
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
			    title: bodyVMape[i][0]
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
	<div id="legenda" style="float: right">
		<strong>Legenda</strong>
		<?php echo kv_MapaLegenda() ?>
	</div>
	<div id="map-canvas"></div>
</body>
</html>