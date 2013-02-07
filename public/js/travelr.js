$(function(){
	$.getJSON(location.href)
	.success(function(response){
		slide(response.pictures);
		drawMap(response.coords); 
	})
	$('.main .map, .map .close').bind('click',toggleMap);
	
});

function slide(data) {
	$.supersized({
		slide_interval : 2000,	
		transition : 1, 			
		transition_speed :1000,
		horizontal_center : 1,
		image_path : 'public/images/',
		slides : data
	});
}





function toggleMap(){
	$('div.map').toggleClass('on');
	return false;
}



function drawMap(coords){
	
	var LatLng=new google.maps.LatLng(coords.lat,coords.lng);
	
	var mapOptions = {
    zoom: 9,
    mapTypeControl: false,
    streetViewControl: false,
    zoomControl:false,
    scaleControl: false,
    center: LatLng,
		styles:[{"stylers": [{ "saturation": -100 }]}],
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
	
	var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
  var image='public/css/img/marker.png';
  var marker = new google.maps.Marker({
          position: LatLng,
          map: map,
          icon:image
      });
}

