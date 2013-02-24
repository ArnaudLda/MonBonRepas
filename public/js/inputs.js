window.onload = function() {
	var form = document.getElementById('form');
    var button = document.getElementById('button');
	
	button.onclick = function() {
		var input = document.createElement("input");
		input.type = "mail";
		input.name = nb;
		input.placeholder = "Invité "+nb;
		
		form.appendChild(input);
		nb++;
	}
}