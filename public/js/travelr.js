$(function(){
	if(datas){
		slide(datas);
	}
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

