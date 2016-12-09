function ajaxObj( meth, url ) {
	var x = new XMLHttpRequest();
	x.open( meth, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
		return true;	
	}
}
function _(id){
	return document.getElementById(id);
}

function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "departure_point" || elem == "departure_point"){
		rx = /[^0-9,]/gi;
	}
	if(elem == "destination_arrival_time" || elem == "destination_knock_off_time"){
		rx = /[^0-9:]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}