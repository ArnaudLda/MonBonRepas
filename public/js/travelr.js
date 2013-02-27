var map;
var image='/GitHub/MonBonRepas/public/css/img/marker.png';

$(function(){
	if(document.getElementById('map_canvas'))
	{
		if(navigator.geolocation) 
		{
		  navigator.geolocation.getCurrentPosition(drawMap,
													geoError,
													{enableHighAccuracy:true});
		}
		// Si le navigateur n'accepte pas la geoloc
		else {handleNoGeolocation(false);}
	}
	else if(document.getElementById('lieu_repas'))
	{
		if(navigator.geolocation) 
		{
		  navigator.geolocation.getCurrentPosition(drawMap2,
													geoError,
													{enableHighAccuracy:true});
		}
		// Si le navigateur n'accepte pas la geoloc
		else {handleNoGeolocation(false);}
	}
});

function drawMap(position){
	
	var travelrStyle = [{featureType: "all"}];
	var travelrType = new google.maps.StyledMapType(travelrStyle,{name: "travelr"});
	
	var LatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	$('#lat').val(LatLng.hb);
	$('#lng').val(LatLng.ib);
	
	var lieu = new google.maps.Geocoder();
	var GeoReverse=lieu.geocode({'latLng': LatLng}, function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) 
			{
				if (results[1]) 
				{
					$('#position').val(results[1].formatted_address);
				}
			}
		});
	var mapOptions = {
    zoom: 11,
    mapTypeControl: false,
    streetViewControl: false,
    zoomControl:false,
    scaleControl: false,
	scrollwheel:false,
    center: LatLng,
    mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'travelr']}
  };
	
  map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
  map.mapTypes.set('travelr', travelrType);
  map.setMapTypeId('travelr');
	var markerLatLng=LatLng;
    var marker = new google.maps.Marker({
          position: markerLatLng,
          map: map,
          icon:image,
		  draggable:true
      });
	google.maps.event.addListener(marker,'dragend', function(){
		$('#lat').val(this.getPosition().lat()); 
		$('#lng').val(this.getPosition().lng()); 
		var LatLng = new google.maps.LatLng($('#lat').val(),$('#lng').val());
		var lieu = new google.maps.Geocoder();
		var GeoReverse=lieu.geocode({'latLng': LatLng}, function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) 
			{
				if (results[1]) 
				{
				  $('#position').val(results[1].formatted_address);
				}
			}
		});
	});
	geoCoding(marker);												
}
function drawMap2(){
	
	var travelrStyle = [{featureType: "all"}];
	var travelrType = new google.maps.StyledMapType(travelrStyle,{name: "travelr"});
	
	var LatLng = new google.maps.LatLng($('#lat').val(), $('#lng').val());
	
	var mapOptions = {
    zoom: 11,
    mapTypeControl: false,
    streetViewControl: false,
    zoomControl:false,
    scaleControl: false,
	scrollwheel:false,
    center: LatLng,
    mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'travelr']}
  };
	
  map = new google.maps.Map(document.getElementById('lieu_repas'),mapOptions);
  map.mapTypes.set('travelr', travelrType);
  map.setMapTypeId('travelr');
	var markerLatLng=LatLng;
    var marker = new google.maps.Marker({
          position: markerLatLng,
          map: map,
          icon:image
      });											
}
function geoCoding(marker) {
	$('#search-position').bind('click',function(e){
		var address = $('#position');
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({"address":address.val()}, function(data,status){
			if(status=='OK'){
				marker.setMap(null);
				map.setCenter(data[0].geometry.location);
				marker = new google.maps.Marker({position: data[0].geometry.location,map: map,icon:image,draggable:true});
				$('#lat').val(data[0].geometry.location.lat());
				$('#lng').val(data[0].geometry.location.lng());
				google.maps.event.addListener(marker,'dragend', function(){
				  $('#lat').val(this.getPosition().lat()); 
				$('#lng').val(this.getPosition().lng()); 
				});
			}
		});
	
		return false;
			});
	
};
    function geoError() {MAP.handleNoGeolocation(true);}
    function handleNoGeolocation(errorFlag) 
	{
        if (errorFlag) {var content = 'Error: The Geolocation service failed.';} 
		else {var content = 'Error: Your browser doesn\'t support geolocation.';}
        var options = 
		{
          map: MAP.map,
          position: new google.maps.LatLng(60, 105),
          content: content
        };
        var infowindow = new google.maps.InfoWindow(options);
        MAP.map.setCenter(options.position);
    }