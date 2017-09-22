//AIzaSyAoq7nxm2GEs-WIpmU9EmhqsEQ0JtF2Ius
			var churchMap;
			var partyMap;
			google.maps.visualRefresh = true;
			var geocoder = new google.maps.Geocoder();
			var browserSupportFlag =  new Boolean();
			var directionsService = new google.maps.DirectionsService();
			var infoWindows = new Array();
			var markers = new Array();
			var mapMarker = new Array();
			/* ------- OBJECTS ----------*/

			//PLACES
			function place(name,address,lat,lng) {
				this.name=name;
				this.address=address;
				this.lat=lat;
				this.lng=lng;
			}

			//MAPS
			function mapObj(id, options) {
				this.canvas = document.getElementById(id);
				this.options= { // DEFAULTS
					zoom: 15,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
						position: google.maps.ControlPosition.TOP_RIGHT
					},
					streetViewControl: false,
//					scaleControl: true,
					panControl: true,
					panControlOptions: {
						position: google.maps.ControlPosition.RIGHT_TOP
					},
					zoomControl: true,
					zoomControlOptions: {
						position: google.maps.ControlPosition.RIGHT_TOP
					}
				};
				for(i in options)
					this.options[i] = options[i];

				this.map = new google.maps.Map(this.canvas,this.options);
				this.dirDisplay=new google.maps.DirectionsRenderer({
					suppressMarkers: true
				});
				this.dirDisplay.setMap(this.map);
				//panMap(this.map)
			}

			function marker(place,map){
				var thisPos = infoWindows.length;
				this.marker = new google.maps.Marker({
					position: place.pos,
					map: map.map,
					title: place.name+" - "+place.address,
					markerId: thisPos
				});
				var infoContent = "<strong class=\"title\">"+place.name+"</strong>";
				if (place.address) infoContent += "<i>"+place.address+"</i>";
				this.info = new google.maps.InfoWindow({
					content: infoContent
				});
				markers.push(this.marker);
				infoWindows.push(this.info);

				google.maps.event.addListener(this.marker, 'click', function() {
					infoWindows[thisPos].open(map.map,markers[thisPos]);
				});
			}

			var church = new place();
				church.name 	= "Parroquia Asunción de la Santísima Virgen";
				church.address	= "Santa Fe 2982";
				church.pos		= new google.maps.LatLng(-38.010446,-57.553060);

			var party = new place();
				party.name 	= "El Recreo";
				party.address	= "Ruta 226, KM 4";
				party.pos		= new google.maps.LatLng(-37.946531,-57.649169);

			var myPos = new place();
				myPos.name 	= "Estás acá";

			var oldPos;

			function initialize() {
				if($('#map-church').length > 0){
					churchMap = new mapObj('map-church',{
						zoom: 16,
						center: church.pos
					});
					//var marker01 = new marker(myPos,churchMap);
					var marker02 = new marker(church,churchMap);
					var marker03 = new marker(party,churchMap);
				}
				if($('#map-party').length > 0){
					partyMap	= new mapObj('map-party',{
						zoom: 13,
						center: party.pos
					});
					//var marker04 = new marker(myPos,partyMap);
					var marker05 = new marker(church,partyMap);
					var marker06 = new marker(party,partyMap);
				}
				/*
				// Try HTML5 geolocation
				if(navigator.geolocation) {
					var distanceService = new google.maps.DistanceMatrixService();

					function getMyPos (){
						navigator.geolocation.getCurrentPosition(function(position) {
							oldPos = myPos.pos;
							myPos.pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
							geocoder.geocode({'latLng': myPos.pos}, function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									if (results[1]) {
										myPos.address = results[1].formatted_address;
									}
								}
								if(oldPos != undefined) { // aca chequeo si la nueva posicion alcanza como para redibujar o no el mapa
									distanceService.getDistanceMatrix({
										origins: [oldPos],
										destinations: [myPos.pos],
										travelMode: google.maps.TravelMode.DRIVING,
										unitSystem: google.maps.UnitSystem.METRIC,
										avoidHighways: false,
										avoidTolls: false
									},function(response, status){
										var distance = response.rows[0].elements[0].distance.value;
										if(distance > 50){
											showMarkers(true);
										} else {
											return false;
										}
									});
								} else {
									showMarkers(true);
								}
							});
						}, function() {
							handleNoGeolocation(true);
							showMarkers(false);
						});
					}
					getMyPos();
					window.setInterval(getMyPos,5000);



				} else {
					// Browser doesn't support Geolocation
					handleNoGeolocation(false);
					showMarkers(false);
				}

*/
				showMarkers(false);	//esto borrarlo cuando reacctive el GPS

			}

			function showMarkers(geoVal) {

				for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(null);   			// LO BORRE PARA QUE ANDE SIN GPS MOMENTANEAMENTE
				}

				if (geoVal==true) {
					if(churchMap != undefined) {
						calcRoute(myPos, church, churchMap);
					}
					if(partyMap != undefined) {
						calcRoute(myPos, party, partyMap);
					}
				}
				else {
					if(churchMap != undefined) {
						calcRoute(church, null, churchMap);
					}
					if(partyMap != undefined) {
						calcRoute(church, party, partyMap); //CALCULO LA RUTA DE LA IGLESAIA A LA FIESTA
						//calcRoute(church, null, partyMap); //CALCULO LA RUTA DE LA IGLESAIA A LA FIESTA
					}
				}
				for (var j in markers) { // ACA ABRO LAS VENTANAS DE LOS MARCADORES AUTOMATICAMENTE
					infoWindows[j].open(markers[j].map,markers[j]);
				}

			}
			function calcRoute(start, end, mapObj) {
				if(start != null) var markerStart = new marker(start,mapObj);
				if(end != null) var markerEnd  = new marker(end,mapObj);

				if((start != null) && (end != null)) {
					var request = {
						origin: start.pos,
						destination:end.pos,
						travelMode: google.maps.TravelMode.DRIVING
					};
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							mapObj.dirDisplay.setDirections(response);
							restricMap(mapObj.map,response.routes[0]);
						}
					});
				} else {

					restricMap(mapObj.map,null);

				}
			}
			function restricMap(map,route){

				if (route != null) {
					var strictBounds = route.bounds;

					var maxX = strictBounds.getNorthEast().lng(),
						maxY = strictBounds.getNorthEast().lat(),
						minX = strictBounds.getSouthWest().lng(),
						minY = strictBounds.getSouthWest().lat();
					var restrictCoords = [
						new google.maps.LatLng(maxY, minX),
						new google.maps.LatLng(maxY, maxX),

						new google.maps.LatLng(minY, maxX),
						new google.maps.LatLng(minY, minX),

						new google.maps.LatLng(maxY, minX),
					];
					map.fitBounds(route.bounds);	//ACOMODO EL ZOOM DEL MAPA PARA QUE SE VEA TODO EL RECORRIDO
				}
				google.maps.event.addListenerOnce(map, 'idle', function() {
					panMap(map);
				});
				map.setOptions({				//SETEO EL ZOOM ACTUAL (QUE ENCAJA TODO EL RECORRIDO) COMO EL ZOOM MÍNIMO.
					minZoom: map.getZoom()
				});
			}

			function handleNoGeolocation(errorFlag) {
				if (errorFlag) {
					var content = 'Error: The Geolocation service failed.';
				} else {
					var content = 'Error: Your browser doesn\'t support geolocation.';
				}
			};
			function panMap(map){
				var panVal = $('#'+map.getDiv().getAttribute('id')).prev().width();
					panVal = panVal/2;
				map.panBy(-panVal,0);
			}
			google.maps.event.addDomListener(window, 'load', initialize);

			/*------------------------------------------------------------------------------------------*/
			/*											COUNTER											*/
			/*------------------------------------------------------------------------------------------*/
			$(function(){

				var container = $('#note'),
						   ts = new Date(2014, 5, 20,10,30,0);

				if((new Date()) > ts){
					// The new year is here! Count towards something else.
					// Notice the *1000 at the end - time must be in milliseconds
					ts = (new Date()).getTime() + 10*24*60*60*1000;
				}

				$('#countdown').countdown({
					timestamp   : ts,
					callback    : function(days, hours, minutes, seconds){

						var content = "<h3>Ya faltan </h3><div>";

						content += "<span><strong>" + days + "</strong> día" + ( days==1 ? '':'s' ) + "</span>";
						content += "<span><strong>" + hours + "</strong>  hora" + ( hours==1 ? '':'s' ) + "</span>";
						content += "<span><strong>" + minutes + "</strong>  minuto" + ( minutes==1 ? '':'s' ) + "</span>";
						content += "<span><strong>" + seconds + "</strong>  segundo" + ( seconds==1 ? '':'s' ) + "</span></div>";
						container.html(content);
					}
				});
			});
