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
	if(elem == "email"){
		rx = /[' "]/gi;
	} 
	tf.value = tf.value.replace(rx, "");
}

function emptyElement(x){
	_(x).innerHTML = "";
}