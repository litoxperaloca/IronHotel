<?php
    //Defino widget de IronPlaceCatalog
    class IronPlaceCatalog_Widget extends WP_Widget {
        

        public function __construct() {
            parent::__construct(
                'ironplacecatalog_widget', 
                'IronHotel: Hotel finder', 
                array('description' => 'With IronHotel plugin, you can search hotels all around the world.')
            );
        }




        public function form($instance) {
            $mapbox_api_key = !empty($instance['mapbox_api_key']) ? $instance['mapbox_api_key'] : '';
            ?>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('mapbox_api_key')); ?>">Mapbox API Key:</label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('mapbox_api_key')); ?>" name="<?php echo esc_attr($this->get_field_name('mapbox_api_key')); ?>" type="text" value="<?php echo esc_attr($mapbox_api_key); ?>">
            </p>
        <?php
        }



        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['mapbox_api_key'] = (!empty($new_instance['mapbox_api_key'])) ? strip_tags($new_instance['mapbox_api_key']) : '';

            return $instance;
        }


        public function widget($args, $instance) {
           echo $args['before_widget'];
            if (!empty($instance['title'])) {
                echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
            }
            // Claves API obtenidas desde el formulario del widget
            //$airlabs_api_key = $instance['airlabs_api_key'];
            //$mapbox_api_key = $instance['mapbox_api_key'];
            $mapbox_api_key = get_option('mapbox_api_key');
			$googlw_place_api_key = get_option('googlw_place_api_key');

            $map_width = '';
            $map_height = '';
			if(wp_is_mobile()){
				$map_width = IronGgetValueFromWpAdminSettings('map_width',300);
				$map_height = IronGgetValueFromWpAdminSettings('map_height',500);
			}else{
				$map_width = IronGgetValueFromWpAdminSettings('map_width',750);
				$map_height = IronGgetValueFromWpAdminSettings('map_height',500);
			}
            $map_zoom = IronGgetValueFromWpAdminSettings('map_zoom',0);
            ?>
		<!-- css con mini ajustes -->
			<?php 
			
			$markerHotel=plugin_dir_path(__FILE__) .'assets/markerHotel.png'; 
			$markerHotelArray=explode('wp-content',$markerHotel);
			$markerHotel='/wp-content'.$markerHotelArray[1];
			
			$markerUser=plugin_dir_path(__FILE__) .'assets/markerUser.png'; 
			$markerUserArray=explode('wp-content',$markerUser);
			$markerUser='/wp-content'.$markerUserArray[1];
			
			?>
		<style>
					#IronHotelWidgetContainer .marker {
					  background-image: url('<?php echo $markerHotel; ?>');
					}
					
					#IronHotelWidgetContainer .markerUser{
					  background-image: url('<?php echo $markerUser; ?>');
					}
		</style>
		<div id="IronHotelWidgetContainer" style='width: <?php echo $map_width; ?>px; height: <?php echo $map_height; ?>px;'>
			<div id="mapOverlay" class="map-overlay"></div> <!-- Overlay -->
			<button id="sidebarToggle">☰</button>
			<div class="sidebar">
							  <div class='heading'>
				<h1>Hotels</h1>
			  </div>
			  <div id='queryForm' class='listings'>
					
				    <form id="overpassForm">
						<h4>Search:</h4>
						<input type="hidden" id="tourism" name="tourism" value="hotel">
						<input type="radio" name="criteria" value="location" id="locationRadio" checked> 
						<label class='inlineInputWithLabel' for="locationRadio">Near my location</label> 
						<br>
						<input type="radio" name="criteria" value="country" id="countryRadio"> 
						<label class='inlineInputWithLabel' for="countryRadio">By country</label> 
						<br/><br/>
						<label id='countrySelectLabel' for="countrySelect">Country:</label>
						<select id="countrySelect" name="country">
							<!-- Las opciones se llenarán con JavaScript -->
						</select>
						<button type="button" id="submitButton">Search</button>
						<div id='queryFormFilters'>
						<label for="name">Name:</label>
						<input type="text" id="name" name="name"><br>

						<label for="operator">Operator:</label>
						<input type="text" id="operator" name="operator"><br>
						
						<label for="city">City:</label>
						<input type="text" id="city" name="city"><br>

						<label for="address">Street:</label>
						<input type="text" id="address" name="address"><br>
						
						<label for="address_num">Street Number:</label>
						<input type="text" id="address_num" name="address_num"><br>

						<label for="opening_hours">Opening Hours (Mo-Fr 08:00-12:00,13:00-17:30):</label>
						<input type="text" id="opening_hours" name="opening_hours"><br>

						<label for="opening_hours_reception">Opening Hours of Reception (Mo-Fr 08:00-12:00,13:00-17:30):</label>
						<input type="text" id="opening_hours_reception" name="opening_hours_reception"><br>

						<label for="website">Website:</label>
						<input type="text" id="website" name="website"><br>
						
						<label for="phone">Phone:</label>
						<input type="text" id="phone" name="phone"><br>

						<label for="stars">Stars:</label>
						<input type="text" id="stars" name="stars"><br>

						<label for="rooms">Rooms:</label>
						<input type="text" id="rooms" name="rooms"><br>

						<label for="beds">Beds:</label>
						<input type="text" id="beds" name="beds"><br>

						<label for="smoking">Smoking:</label>
						<input type="text" id="smoking" name="smoking"><br>

						<label for="wheelchair">Wheelchair (no/yes/number of rooms):</label>
						<input type="text" id="wheelchair" name="wheelchair"><br>

						<label for="internet_access">Internet Access (wlan/no):</label>
						<input type="text" id="internet_access" name="internet_access"><br>

						<label for="swimming_pool">Swimming Pool (yes/no):</label>
						<input type="text" id="swimming_pool" name="swimming_pool"><br>

						<label for="bicycle_rental">Bicycle Rental:</label>
						<input type="text" id="bicycle_rental" name="bicycle_rental"><br>

						<label for="bar">Bar:</label>
						<input type="text" id="bar" name="bar"><br>
						</div>
				</form>
				<button type="button" id="newSearch">New search</button>
				<div id="results"></div>
				<div id='listings' class='listings'></div>
			  </div>
			  
			</div>
			<div class="map-controls-daytime">
			<div id="day" class="map-button">
				<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g>
						<circle cx="19" cy="19.0002" r="18.5" fill="blue"></circle>
						<path d="M19 24.5467C22.0635 24.5467 24.5469 22.0632 24.5469 18.9998C24.5469 15.9363 22.0635 13.4529 19 13.4529C15.9366 13.4529 13.4531 15.9363 13.4531 18.9998C13.4531 22.0632 15.9366 24.5467 19 24.5467Z" fill="yellow" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M19 7.30005V9.6401" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M10.7285 10.7268L12.3819 12.3817" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M7.30078 18.9998H9.64083" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M10.7285 27.2725L12.3834 25.6182" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M19 30.6999V28.3589" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M27.2726 27.2725L25.6172 25.6182" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M30.6994 19.0002H28.3594" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M27.2726 10.7268L25.6172 12.3817" stroke="yellow" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
					</g>
				</svg>
			</div>
			<div id="dusk" class="map-button">
				<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g>
						<circle cx="19" cy="19.0002" r="18.5" fill="darkblue"></circle>
						<path d="M19 24.5467C22.0635 24.5467 24.5469 22.0632 24.5469 18.9998C24.5469 15.9363 22.0635 13.4529 19 13.4529C15.9366 13.4529 13.4531 15.9363 13.4531 18.9998C13.4531 22.0632 15.9366 24.5467 19 24.5467Z" fill="orange" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M19 7.30005V9.6401" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M10.7285 10.7268L12.3819 12.3817" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M7.30078 18.9998H9.64083" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M10.7285 27.2725L12.3834 25.6182" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M19 30.6999V28.3589" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M27.2726 27.2725L25.6172 25.6182" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M30.6994 19.0002H28.3594" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M27.2726 10.7268L25.6172 12.3817" stroke="orange" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
					</g>
				</svg>
			</div>
			<div id="night" class="map-button">
				<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g>
						<circle cx="19" cy="19" r="18.5" fill="black"></circle>
						<path d="M18.53 27.9489C14.9462 28.7919 11.3593 27.5714 9.01172 25.0631C10.617 25.5423 12.3651 25.6235 14.1138 25.2139C19.4467 23.9597 22.7537 18.6189 21.4996 13.2864C21.0884 11.5378 20.2364 10.01 19.0919 8.78589C22.3837 9.77013 25.0744 12.4361 25.9173 16.0214C27.1705 21.3549 23.864 26.6947 18.53 27.9489Z" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" fill="white" stroke-linejoin="round"></path>
					</g>
				</svg>
			</div>
			</div>			
			<div id="mapIronHotel"></div>
		</div>	
			
	
		
		<script>
		//Cargo mapbox apikey desde la conf de admin menu
                mapboxgl.accessToken = '<?php echo $mapbox_api_key; ?>';
				//Creo mapa
				const centerDefault = [-56.183321,  -34.911186];
                const mapIronHotel = new mapboxgl.Map({
                    container: 'mapIronHotel', // container ID
                    //style: 'mapbox://styles/litoxperaloca/clpeazft8006q01pg8fghbgdl', // style URL
                    //center: [-56.183321,  -34.911186], // starting position [lng, lat]
					center: [0,  0],
                    zoom: <?php echo $map_zoom; ?>, // starting zoom
                    projection: 'globe',
                });
				
				let isRotating = true; // Flag to control rotation
				let geolocForSearch=false;
				let userMarker = null;

				const geoloc = new mapboxgl.GeolocateControl({
					positionOptions: {
						enableHighAccuracy: true
					},
					trackUserLocation: false,
					showUserHeading: false,
					showAccuracyCircle: false,
					showUserLocation: false
				});
				mapIronHotel.addControl(geoloc, 'top-right');
				
				mapIronHotel.on('load', () => {
					//geoloc.trigger();

					flyToUserLocation();
				});
				
				let lastGpsData=[];
				
				geoloc.on('error', () => {
					alert("Geolocation access denied. Please enter your location manually.");
					if(isRotating){
						setTimeout(() => {

							isRotating = false; // Stop rotation if geolocation fails
							// Fly to the user's location
							mapIronHotel.flyTo({
								center: centerDefault,
								zoom: 17,
								pitch: 35,
								essential: true
							});
						}, 3000); // 5000 milliseconds delay
					}
				});
				
				geoloc.on('geolocate', (event) => {
					lastGpsData = event.coords;
					if(isRotating){
						setTimeout(() => {
							isRotating = false;

							// Fly to the user's location
							mapIronHotel.flyTo({
								center: [event.coords.longitude, event.coords.latitude],
								zoom: 17,
								pitch: 35,
								essential: true
							});
						}, 3000); // 5000 milliseconds delay
					}else{
						userMarker.remove();
						
						userMarker.setLngLat([event.coords.longitude, event.coords.latitude]);
						  
						userMarker.addTo(mapIronHotel);
						// Fly to the user's location
							mapIronHotel.flyTo({
								center: [event.coords.longitude, event.coords.latitude],
								zoom: 17,
								pitch: 35,
								essential: true
							});
					}
				});
				
				// Function to fly to the user's location with a delay
				function flyToUserLocation() {
	
						
						setTimeout(() => {
							navigator.geolocation.getCurrentPosition(position => {
								lastGpsData=position.coords;
								if(isRotating){
								// Stop the rotation
							
									isRotating = false;
									userMarker=createUserMarker();
								}else{
									userMarker.remove();
								}
								userMarker.setLngLat([position.coords.longitude, position.coords.latitude]);
						  
								userMarker.addTo(mapIronHotel);
								// Fly to the user's location
								mapIronHotel.flyTo({
									center: [position.coords.longitude, position.coords.latitude],
									zoom: 17,
									pitch: 35,
									essential: true
								});
							}, () => {
								alert("Geolocation access denied. Please enter your location manually.");
								if(isRotating){
									isRotating = false; // Stop rotation if geolocation fails
									mapIronHotel.flyTo({
										center: centerDefault,
										zoom: 17,
										pitch: 35,
										essential: true
									});
								}
								
							});
						},3000); // 5000 milliseconds delay
					
					
				}



				// Start the rotation
				rotateCamera(0);

				
				const nav = new mapboxgl.NavigationControl({
					visualizePitch: true
				});
				mapIronHotel.addControl(nav, 'top-right');
				
				/*const directions =  new MapboxDirections({
						accessToken: mapboxgl.accessToken
					});
				mapIronHotel.addControl(directions, 'top-left');*/
				
				
			var geojsonData='';
			let mapMarkers=[];
			let mapPopups=[];

			document.addEventListener('DOMContentLoaded', function() {

					var select = document.getElementById('countrySelect');

					countries.forEach(function(country) {
						var option = document.createElement('option');
						option.value = country[1]; // Código del país
						option.textContent = country[0]; // Nombre del país
						select.appendChild(option);
					});
					
					const toggleButton = document.getElementById('sidebarToggle');
					const sidebar = document.querySelector('.sidebar');
					const overlay = document.getElementById('mapOverlay');

					toggleButton.addEventListener('click', function() {
						toggleButton.classList.toggle('open');
						sidebar.classList.toggle('open');
						overlay.classList.toggle('open');
					});

					// Optional: Hide sidebar when overlay is clicked
					overlay.addEventListener('click', function() {
						toggleButton.classList.remove('open');
						sidebar.classList.remove('open');
						overlay.classList.remove('open');
					});
				});
				
			document.getElementById('locationRadio').addEventListener('click', function() {
				document.getElementById('countrySelectLabel').style.display='none';
				document.getElementById('countrySelect').style.display='none';
			});	
			document.getElementById('countryRadio').addEventListener('click', function() {
				document.getElementById('countrySelectLabel').style.display='block';
				document.getElementById('countrySelect').style.display='block';
			});	
			document.getElementById('day').addEventListener('click', function() {
				mapIronHotel.setConfigProperty('basemap', 'lightPreset', 'day');
			});		
			document.getElementById('dusk').addEventListener('click', function() {
				mapIronHotel.setConfigProperty('basemap', 'lightPreset', 'dusk');
			});		
			document.getElementById('night').addEventListener('click', function() {
				mapIronHotel.setConfigProperty('basemap', 'lightPreset', 'night');
			});	
						document.getElementById('newSearch').addEventListener('click', function() {
							document.getElementById('overpassForm').style.display="block";
							document.getElementById('newSearch').style.display="none";

						});


			
			document.getElementById('submitButton').addEventListener('click', function() {
				let criteria = document.querySelector('input[name="criteria"]:checked');
				var countrySelect = document.getElementById('countrySelect');
				var country = countrySelect.options[countrySelect.selectedIndex].text;
				if(country=="Select country"&&criteria.value=='country'){
					alert('Please select a country or choose to search near your location.');
				}else{
					
				
				document.querySelector('#submitButton').setAttribute('disabled', true);
				var query = '[out:json][timeout:300];nr';

				// Recoge valores de cada campo y agrega a la consulta si no está vacío
				function addQueryCondition(fieldId, tagName) {
					var value = document.getElementById(fieldId).value;
					if (value) query += '["' + tagName + '"="' + value + '"]';
				}

				addQueryCondition('tourism', 'tourism');
			
				if(criteria.value=='location'){
					const bbox = createBoundingBox(lastGpsData,50);
					console.log(bbox);
					query += '('+bbox[0][1]+','+bbox[0][0]+','+bbox[1][1]+','+bbox[1][0]+')';
				}else{

					addQueryCondition('countrySelect', 'addr:country');
					addQueryCondition('city', 'addr:city');
					addQueryCondition('address', 'addr:street');
					addQueryCondition('address_num', 'addr:housenumber');
				}
				addQueryCondition('name', 'name');
				addQueryCondition('operator', 'operator');
				addQueryCondition('opening_hours', 'opening_hours');
				addQueryCondition('opening_hours_reception', 'opening_hours:reception');
				addQueryCondition('website', 'website');
				addQueryCondition('phone', 'phone');
				addQueryCondition('stars', 'stars');
				addQueryCondition('rooms', 'rooms');
				addQueryCondition('beds', 'beds');
				addQueryCondition('smoking', 'smoking');
				addQueryCondition('wheelchair', 'wheelchair');
				addQueryCondition('internet_access', 'internet_access');
				addQueryCondition('swimming_pool', 'swimming_pool');
				addQueryCondition('bicycle_rental', 'service:bicycle:rental');
				addQueryCondition('bar', 'bar');

				query += ';out geom;';
				if(mapIronHotel.getSource('places')){
							  removeMarkers();
				}
				const listings = document.getElementById('listings');
				const loader = document.createElement('div');
				loader.className = 'loader';
				listings.appendChild(loader);
				// Llamada AJAX a la API
				<?php 
				if($googlw_place_api_key){
					?>
			jQuery.ajax({
					url: 'https://ironplatform.com.uy/searchplaces.php?lat='+lastGpsData.latitude+'&lon='+lastGpsData.longitude,
					type: 'GET',
					dataType: 'json',
					success: function(data) {
						//document.getElementById('results').innerHTML = JSON.stringify(data, null, 2);
						geojsonData = data;
					//DATA
						const stores = geojsonData;
						console.log(stores);
						/* Assign a unique ID to each store */
						stores.features.forEach(function (store, i) {
						   store.properties=convertGoogleToOSM(store);

						  store.properties.id = i;
						});
						
						//mapIronHotel.on('load', () => {
						  /* Add the data to your map as a layer */
						  if(mapIronHotel.getSource('places')){
							  //removeMarkers();
							  mapIronHotel.getSource('places').setData(stores);
						  }else{
							mapIronHotel.addSource('places', {
							  type: 'geojson',
							  data: stores
							  
							});
						  }
	
							setResultMessage(stores);
							addHotelLayers(stores);
							//addMarkers(stores);
							buildLocationList(stores);
							setViewDisplayAllFeatures(stores);
						//});	
						
						
						// Remove the loader once the list is built
						loader.remove();
						document.querySelector('#submitButton').removeAttribute('disabled');

					},
					error: function(error) {
						// Remove the loader once the list is built
						loader.remove();
						document.querySelector('#submitButton').removeAttribute('disabled');
						console.error('Error:', error);
					}
				});
				
				

					function convertGoogleToOSM(googlePlace) {
						const osmData = {
							'name': googlePlace.name,
							'addr:street': extractComponent(googlePlace.address_components, 'route'),
							'addr:city': extractComponent(googlePlace.address_components, 'locality'),
							'addr:postcode': extractComponent(googlePlace.address_components, 'postal_code'),
							'addr:country': extractComponent(googlePlace.address_components, 'country'),
							'geometry': {
								'type': 'Point',
								'coordinates': [googlePlace.geometry.location.lng, googlePlace.geometry.location.lat]
							},
							'tourism': googlePlace.types.includes('lodging') ? 'hotel' : undefined
						};

						return osmData;
					}
				
				<?php 
				}else{
				?>
				jQuery.ajax({
					url: 'https://overpass-api.de/api/interpreter',
					type: 'GET',
					data: { data: query },
					dataType: 'json',
					success: function(data) {
						//document.getElementById('results').innerHTML = JSON.stringify(data, null, 2);
						geojsonData = convertToGeoJson(data);
					//DATA
						const stores = geojsonData;
						console.log(stores);
						/* Assign a unique ID to each store */
						stores.features.forEach(function (store, i) {
						  store.properties.id = i;
						});
						
						//mapIronHotel.on('load', () => {
						  /* Add the data to your map as a layer */
						  if(mapIronHotel.getSource('places')){
							  //removeMarkers();
							  mapIronHotel.getSource('places').setData(stores);
						  }else{
							mapIronHotel.addSource('places', {
							  type: 'geojson',
							  data: stores
							  
							});
						  }
	
							setResultMessage(stores);
							addHotelLayers(stores);
							//addMarkers(stores);
							buildLocationList(stores);
							setViewDisplayAllFeatures(stores);
						//});	
						
						
						// Remove the loader once the list is built
						loader.remove();
						document.querySelector('#submitButton').removeAttribute('disabled');

					},
					error: function(error) {
						// Remove the loader once the list is built
						loader.remove();
						document.querySelector('#submitButton').removeAttribute('disabled');
						console.error('Error:', error);
					}
				});
				<?php 
				 }
				?>
				function addHotelLayers(){
					mapIronHotel.loadImage(
                	'https://ironplatform.com.uy/wp-content/uploads/2024/01/markerHotel.png',
	                (error, image) => {
	                	if (error) throw error;
	               		mapIronHotel.addImage('hotel-marker', image);
						 //Añado layer con el icono a la source creada
								
	                            mapIronHotel.addLayer({
		                        'id': 'hotels',
		                        'type': 'symbol',
		                        'source': 'places',
		                        'layout': {
			                        'icon-image': 'hotel-marker',
			                        'icon-size': 1
		                
	                            	}
	                            });

									mapIronHotel.on('click', 'hotels', function(e) {
										var hotel = e.features[0];
										var coordenadas = hotel.geometry.coordinates.slice();
						
										while (Math.abs(e.lngLat.lng - coordenadas[0]) > 180) {
											coordenadas[0] += e.lngLat.lng > coordenadas[0] ? 360 : -360;
										}
											createPopUp(hotel);
										});

                    });
				}
				
				function convertToGeoJson(data) {
					var geojson = {
						"type": "FeatureCollection",
						"features": []
					};

					data.elements.forEach(function(node) {
						if (node.type === "node") {
							var feature = {
								"type": "Feature",
								"geometry": {
									"type": "Point",
									"coordinates": [node.lon, node.lat]
								},
								"properties": node.tags
							};
							geojson.features.push(feature);
						}
					});

					return geojson;
				}
				
			}
			});
		
		
				function setResultMessage(stores){
					var html='<p><b>';					
					if(!stores||stores.features.length==0){
						html+="0"; 
					}else{
						document.getElementById('overpassForm').style.display="none";
						document.getElementById('newSearch').style.display="block";
						html+=stores.features.length; 
					}
					html+='</b>';
					let criteria = document.querySelector('input[name="criteria"]:checked');
					if(criteria.value=='location'){
						html+=' results <b>near your location:</b>';
					}else{
						var countrySelect = document.getElementById('countrySelect');
						var country = countrySelect.options[countrySelect.selectedIndex].text;
						html+=' results located in <b>'+country+':</b>';
					}
					html+='</p>';
					document.getElementById('results').innerHTML=html;
				}
				
				
				function removeMarkers() {
					mapMarkers.forEach(function(marker) {
						marker.remove();
					});
					mapPopups.forEach(function(popup) {
						popup.remove();
					});
					mapMarkers.length = 0;
					mapPopups.length = 0;
					document.getElementById('listings').innerHTML='';
				}
				
				function addMarkers(stores) {
					  /* For each feature in the GeoJSON object above: */
					  for (const marker of stores.features) {
						/* Create a div element for the marker. */
						const el = document.createElement('div');
						/* Assign a unique `id` to the marker. */
						el.id = `marker-${marker.properties.id}`;
						/* Assign the `marker` class to each marker for styling. */
						el.className = 'marker';

						/**
						 * Create a marker using the div element
						 * defined above and add it to the map.
						 **/
						var placeMarker =new mapboxgl.Marker(el, { offset: [0, -23] });
						 placeMarker.setLngLat(marker.geometry.coordinates);
						  
						placeMarker.addTo(mapIronHotel);
						mapMarkers.push(placeMarker);  
						 el.addEventListener('click', (e) => {
							  /* Fly to the point */
							  flyToStore(marker);
							  /* Close all other popups and display popup for clicked store */
							  createPopUp(marker);
							  /* Highlight listing in sidebar */
							  const activeItem = document.getElementsByClassName('active');
							  e.stopPropagation();
							  if (activeItem[0]) {
								activeItem[0].classList.remove('active');
							  }
							  const listing = document.getElementById(`listing-${marker.properties.id}`);
							  listing.classList.add('active');
							}); 
					  }
					}
				
				
				function buildLocationList(stores) {
						const listings = document.getElementById('listings');
						listings.innerHTML = ''; // Clear previous listings

						// Group hotels by city and sort the cities
						const groupedByCity = groupByCity(stores.features);
						const sortedCities = Object.keys(groupedByCity).sort();

						sortedCities.forEach(city => {
							const cityDiv = document.createElement('div');
							cityDiv.className = 'city';

							// Create a header for each city
							const cityHeader = document.createElement('button');
							cityHeader.className = 'accordion';
							cityHeader.textContent = city;
							cityDiv.appendChild(cityHeader);

							// Create a container for hotel listings in the city
							const hotelsList = document.createElement('div');
							hotelsList.className = 'panel';

							groupedByCity[city].forEach(store => {
								const listing = document.createElement('div');
								listing.className = 'item';
								listing.id = `listing-${store.properties.id}`;

								const link = document.createElement('a');
								link.className = 'title';
								link.id = `link-${store.properties.id}`;
								link.textContent = store.properties.name;
								link.addEventListener('click', function () {
									sidebarToggleAndFlyTo(store, listing);
								});

								listing.appendChild(link);
								hotelsList.appendChild(listing);
							});

							cityDiv.appendChild(hotelsList);
							listings.appendChild(cityDiv);
						});

						addAccordionFunctionality();
						
					}

					function sidebarToggleAndFlyTo(store, listing) {
						const sidebar = document.querySelector('.sidebar');
						if (sidebar.classList.contains('open')) {
							const toggleButton = document.getElementById('sidebarToggle');
							const overlay = document.getElementById('mapOverlay');
							toggleButton.classList.toggle('open');
							sidebar.classList.toggle('open');
							overlay.classList.toggle('open');
						}
						flyToStore(store);
						createPopUp(store);

						const activeItem = document.querySelector('.item.active');
						if (activeItem) {
							activeItem.classList.remove('active');
						}
						listing.classList.add('active');
					}

					function addAccordionFunctionality() {
						const acc = document.getElementsByClassName("accordion");
						for (let i = 0; i < acc.length; i++) {
							acc[i].addEventListener("click", function() {
								this.classList.toggle("active");
								const panel = this.nextElementSibling;
								if(this.classList.contains("active")){
									panel.style.display="block";
									panel.style.maxHeight = null;

								} else {
									panel.style.display="none";
									panel.style.maxHeight = panel.scrollHeight + "px";


								}
							});
						}
					}

					function groupByCity(features) {
						return features.reduce((group, feature) => {
							const city = feature.properties['addr:city'];
							group[city] = group[city] || [];
							group[city].push(feature);
							return group;
						}, {});
					}

				
				function flyToStore(currentFeature) {
				  mapIronHotel.flyTo({
					center: currentFeature.geometry.coordinates,
					zoom: 17,
					pitch: 35,
					essential: true // this animation is considered essential with respect to prefers-reduced-motion

				  });
				}

				
				
				function createPopUp(currentFeature) {
					
					const popUps = document.getElementsByClassName('mapboxgl-popup');
					// Check if there is already a popup on the map and if so, remove it
					if (popUps[0]) popUps[0].remove();

					const popup = new mapboxgl.Popup({ focusAfterOpen: false, closeOnClick: true });
					popup.setLngLat(currentFeature.geometry.coordinates);

					// Constructing the new HTML content
					var html = '<div class="popup-container">';
					 html+= '<h3>'+currentFeature.properties.name+'</h3>';
					// Stars - replace with icon/image as needed
					if(currentFeature.properties.stars) {
						html += '<p><strong>Stars:</strong> <span class="stars">';
						for(var i = 0; i < currentFeature.properties.stars; i++) {
							html += '★';
						}
						for(var i = currentFeature.properties.stars; i < 5; i++) {
							html += '☆';
						}
						html += '</span></p>';
					}
					// Adding specific properties in a formatted way
					if(currentFeature.properties['addr:street'] && currentFeature.properties['addr:housenumber'] && currentFeature.properties['addr:city']) {
						html += '<p><strong>Address:</strong> ' + currentFeature.properties['addr:housenumber'] + ' ' + currentFeature.properties['addr:street'] + ', '  + currentFeature.properties['addr:city'] + ', '  + currentFeature.properties['addr:country'] + '</p>';
					}

					if(currentFeature.properties.phone) {
						html += '<p><strong>Phone:</strong> ' + currentFeature.properties.phone + '</p>';
					}

					if(currentFeature.properties.opening_hours) {
						html += '<p><strong>Opening Hours:</strong> ' + currentFeature.properties.opening_hours + '</p>';
					}
					
					if(currentFeature.properties.website) {
						html += '<a href="' + currentFeature.properties.website + '" target="_blank">Visit Website</a>';
					}

					if(currentFeature.properties.rooms) {
						html += '<p><strong>Rooms:</strong> ' + currentFeature.properties.rooms + '</p>';
					}

					
					   if(currentFeature.properties['beds']) {
							html += '<p><strong>Beds:</strong> ' + currentFeature.properties['beds'] + '</p>';
						}

						if(currentFeature.properties['smoking']) {
							html += '<p><strong>Smoking:</strong> ' + (currentFeature.properties['smoking'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

						if(currentFeature.properties['internet_access']) {
							html += '<p><strong>Internet Access:</strong> ' + (currentFeature.properties['internet_access'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

						if(currentFeature.properties['swimming_pool']) {
							html += '<p><strong>Swimming Pool:</strong> ' + (currentFeature.properties['swimming_pool'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

						if(currentFeature.properties['service:bicycle:rental']) {
							html += '<p><strong>Bicycle Rental:</strong> ' + (currentFeature.properties['service:bicycle:rental'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

						if(currentFeature.properties['bar']) {
							html += '<p><strong>Bar:</strong> ' + (currentFeature.properties['bar'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

						if(currentFeature.properties['wheelchair']) {
							html += '<p><strong>Wheelchair Access:</strong> ' + (currentFeature.properties['wheelchair'] === 'yes' ? 'Yes' : 'No') + '</p>';
						}

					html += '</div>';

					popup.setHTML(html);
					popup.addTo(mapIronHotel);
					mapPopups.push(popup);
				}

				
				function setViewDisplayAllFeatures(stores){
					// Suponiendo que 'map' es tu objeto Mapbox GL JS y 'data' es tu conjunto de datos GeoJSON
					if (stores.features.length > 0) {
						// Calcula los límites para todas las características
						const bounds = new mapboxgl.LngLatBounds();

						stores.features.forEach(feature => {
							if (feature.geometry.type === 'Point') {
								bounds.extend(feature.geometry.coordinates);
							} else {
								// Para características no puntuales, como polígonos o líneas
								feature.geometry.coordinates.forEach(segment => {
									segment.forEach(coord => bounds.extend(coord));
								});
							}
						});

						// Ajusta la cámara para que todos los límites estén visibles
						mapIronHotel.fitBounds(bounds, {
							padding: 50, // Puedes ajustar el relleno según sea necesario
							maxZoom: 13, // Establece un zoom máximo si es necesario
							duration: 2000 // Duración de la animación en milisegundos
						});
					}
					
				}
				
				function createBoundingBox(center, distance) {
					const earthRadius = 6371; // radius of the earth in kilometers

					const lat = center.latitude;
					const lng = center.longitude;

					const maxLat = lat + rad2deg(distance / earthRadius);
					const minLat = lat - rad2deg(distance / earthRadius);

					// Compensate for degrees longitude getting smaller with increasing latitude
					const maxLng = lng + rad2deg(distance / earthRadius / Math.cos(deg2rad(lat)));
					const minLng = lng - rad2deg(distance / earthRadius / Math.cos(deg2rad(lat)));

					return [[minLng, minLat], [maxLng, maxLat]];
				}

				function rad2deg(angle) {
					return angle * 57.29577951308232; // angle / Math.PI * 180
				}

				function deg2rad(angle) {
					return angle * 0.017453292519943295; // angle * Math.PI / 180
				}
				

				// Function to rotate the camera around the world
				function rotateCamera(timestamp) {
					if (isRotating) {
						// Calculate the camera's next longitude and latitude
						const lng = (timestamp / 25) % 360 - 180;
						const lat = 0; // Keep the latitude constant

						// Update the map's center to create a rotation effect
						mapIronHotel.setCenter([lng, lat]);

						// Request the next frame of the rotation
						requestAnimationFrame(rotateCamera);
					}
				}
				
				function createUserMarker(){
					const el = document.createElement('div');
						/* Assign a unique `id` to the marker. */
						el.id = `marker-user`;
						/* Assign the `marker` class to each marker for styling. */
						el.className = 'markerUser';

						/**
						 * Create a marker using the div element
						 * defined above and add it to the map.
						 **/
						var marker = new mapboxgl.Marker(el, { offset: [0, -25] });
						return marker;
					
				}


            </script>
            <?php

            echo $args['after_widget'];
        }
    }
    //Fin clase widget
	
	 //registro mi widget
    add_action('widgets_init', function() {
        register_widget('IronPlaceCatalog_Widget');
    });
	
	
?>