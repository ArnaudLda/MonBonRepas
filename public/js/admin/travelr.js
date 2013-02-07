var map;
var image='/travelr-g2/public/css/img/marker.png';

$(function(){
	drawMap();
	$('#search-position').bind('click',function(e){
			geoCoding();
			return false;
	});
});
function drawMap(){
	
	var travelrStyle = [{featureType: "all",stylers: [{ saturation: -100 }]}];
  var travelrType = new google.maps.StyledMapType(travelrStyle,{name: "travelr"});
	var LatLng=new google.maps.LatLng($('#lat').val(),$('#lng').val());
	
	
	
	var mapOptions = {
    zoom: 9,
    mapTypeControl: false,
    streetViewControl: false,
    zoomControl:false,
    scaleControl: false,
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
	});
}

function geoCoding() {
	var address = $('#position');
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({"address":address.val()}, function(data,status){
		if(status=='OK'){
			map.setCenter(data[0].geometry.location);
			var newmarker = new google.maps.Marker({position: data[0].geometry.location,map: map,icon:image,draggable:true});
			$('#lat').val(data[0].geometry.location.lat());
			$('#lng').val(data[0].geometry.location.lng());
			google.maps.event.addListener(newmarker,'dragend', function(){
			  $('#lat').val(this.getPosition().lat()); 
		  	$('#lng').val(this.getPosition().lng()); 
			});
		}
	});
	
};
