function open_bar() {
	$("#menu_bar").animate({marginLeft: "0%"}, 500);
}
function back() {
	window.location.assign("../4.user_interface.html");
}
			
function pages_logout() {
	localStorage.removeItem("phoneNumber");
	localStorage.removeItem("password");
	//var ajax = ajaxObj("POST", "http://www.sqaaps.co.za/php/login.php");
	var ajax = ajaxObj("POST", "../php/login.php");
	ajax.send("logout=" + '');
	window.location.assign("../index.html");
}

function auto_grow(element) {
	element.style.height = "5px";
	element.style.height = (element.scrollHeight) + "px";
}

function _(id) {
	return document.getElementById(id);
}