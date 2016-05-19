<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body, #container { height: 100%; width:100%; margin: 0; padding: 0; background: grey; }
      #map { height: 90%; width: 100%; }
	  #route {width: 100%; background: white;}
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  </head>
  <body>
  <div id="container">
    <div id="map"></div>
	<div id="route"></div>
  </div>
    <script type="text/javascript">
function initMap() {
	directionsDisplay=null;
	var cargado=false;
	//myposition must be global for create routes above.
	centro = new google.maps.LatLng(40.416856, -3.703275);
	
	//map must be global for create routes above.
	map = new google.maps.Map(document.getElementById('map'), {
		center: centro,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	//OJO!!!!!!!!!!!!! ES NECESARIO PONER HTTPS:// PARA PODER ACCEDER A LA UBICACIÓN.
	//Locate current position
	if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
		
		lat= position.coords.latitude,
		lng= position.coords.longitude
		
		pos_act=new google.maps.LatLng(lat,lng);
			
		var marker_pos_actual = new google.maps.Marker({
					position: pos_act,
					map: map,
					title: "Posicion actual",
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						scale: 9,
						strokeColor: '#FFFFFF',
						strokeWeight: 3,
						fillColor: '#00BFFF',
						fillOpacity: 1
					},
					animation: google.maps.Animation.DROP
					
				});
		map.setCenter(pos_act);
		}, function() {
			handleLocationError(true, infoWindow, map.getCenter());
		});
	}

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
	}
	
	initMarkers()
	
}//end function initMap.

function initMarkers(){
	<?php
		$usuario="admin";
		
		require('conecta.php');

		$con=Conectar();
		$sql="SELECT longitud,latitud,nombre,id,cant_bicis FROM data LIMIT 30";

		$res=mysqli_query($con,$sql);
		$flag=false;
		while($registro= mysqli_fetch_array($res))
		{
			if(!$flag){
		?>	
				infowindow=null;
				
		<?php	
				$flag=true;
			}//end if php
		?>
			myposition_<?php echo $registro[3];?> = null;
			myposition_<?php echo $registro[3];?> = new google.maps.LatLng(<?php echo $registro[0]?>,<?php echo $registro[1]?>);
			
			marker_<?php echo $registro[3];?>=null;
			marker_<?php echo $registro[3];?> = new google.maps.Marker({
				position: myposition_<?php echo $registro[3];?>,
				map: map,
				title:"<?php echo $registro[2]?>",
				animation: google.maps.Animation.DROP
			});
			
			google.maps.event.addListener(marker_<?php echo $registro[3];?>, 'click', function(myposition_<?php echo $registro[3];?>){
				if(!infowindow){
					infowindow=new google.maps.InfoWindow();
				}
				var content_marker='<div>'+
									'<p><?php echo $registro[2]?></p>'+
									'<p>Bicicletas disponibles: <?php echo $registro[4]?></p>'+
								'</div>'+
								'<div>'+
									'<input type="button" onclick="javascript:crearRuta(myposition_<?php echo $registro[3];?>)" value="Crear ruta">'+
									'<input type="button" onclick="javascript:reservar(<?php echo $registro[3];?>)" value="Reservar">'+
								'</div>';
				infowindow.setContent(content_marker);
				infowindow.open(map,marker_<?php echo $registro[3];?>);
			});
		<?php
		}//end while php
		?>
	}
	
function crearRuta(m){
	if(directionsDisplay != null) {
		directionsDisplay.setMap(null);
		directionsDisplay.setPanel(null);
		directionsDisplay = null;
	}
	directionsDisplay = new google.maps.DirectionsRenderer();
	directionsService = new google.maps.DirectionsService();
	var request = {
		 origin: pos_act,
		 destination: m,
		 travelMode: google.maps.DirectionsTravelMode.WALKING,
		 unitSystem: google.maps.DirectionsUnitSystem.METRIC,
		 provideRouteAlternatives: true
	 };
	directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setMap(map);
			directionsDisplay.setPanel(route);
			directionsDisplay.setDirections(response);
		} else {
			alert("No existen rutas entre ambos puntos");
		}
	});
}//end function crearRuta

function reservar(id){
	<?php
		//El error esta aqui.
		/*require('conecta.php');*/
		$id=1;
		$sql1="UPDATE data SET cant_bicis=cant_bicis-1 WHERE id=$id";
		$sql2="UPDATE users SET reserva=1 WHERE user=$usuario";
		$respuesta1= mysqli_query($con,$sql1);
		if($respuesta1==null){
			?>
			alert("Reserva hecha correctamente.");
			<?php
		}
		?>
	initMap();
}
		</script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRnFCFj6P12Y5sYbMTA9-3l3j7h1T2wjg&callback=initMap">
    </script>
  </body>
</html>