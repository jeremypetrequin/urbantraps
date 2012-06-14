function confirmation(url, msg) {
	res = confirm(msg);
	if(res) document.location.href = url;
}
