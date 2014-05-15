(function($){
	var map;
	var centre = new google.maps.LatLng(21.204847387161795, 79.1172028578171);

	var MY_MAPTYPE_ID = 'Outline';

	function initialise() {

	  var featureOpts = [
		{
		  stylers: [
			{ hue: '#00278A' },
			{ visibility: 'simplified' },
			{ gamma: 0.5 },
			{ weight: 0.9 }
		  ]
		},
		{
		  elementType: 'labels',
		  stylers: [
			{ visibility: 'off' }
		  ]
		},
		{
		  featureType: 'water',
		  stylers: [
			{ color: '#00278A' }
		  ]
		}
	  ];

	  var mapOptions = {
		zoom: 4,
		center: centre,
		mapTypeControlOptions: {
		  mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
		},
		mapTypeId: MY_MAPTYPE_ID
	  };

	  map = new google.maps.Map(document.getElementById('mapLocation'),
		  mapOptions);

	  var styledMapOptions = {
		name: 'Outline'
	  };

	  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

	  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
	  sy_add_marker(map,1,12.980418292307993,80.25978098281712,'test');
  
	}

	function sy_add_marker( map,marker_order, marker_lat, marker_lng, marker_description){
		var marker_id = 'sy_marker_' + marker_order;
		var image = {
			url: "../images/plant-white.png",
			// This marker is 20 pixels wide by 32 pixels tall.
			size: new google.maps.Size(30,34),
			// The origin for this image is 0,0.
			origin: new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			//anchor: new google.maps.Point(0, 32)
		  };
		var myLatLng = new google.maps.LatLng(marker_lat, marker_lng);
		var marker = new google.maps.Marker({
			id : marker_id,
			position: myLatLng,
			map: map,
			icon: image,
			title: 'Test'
		});

	}
	google.maps.event.addDomListener(window, 'load', initialise);
})(jQuery)