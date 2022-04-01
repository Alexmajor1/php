function main()
{
	addr = new String(window.location);
	arr = addr.split('&');
	var result = arr.length;
	if(result > 1){
		backLink = document.getElementById('back-link');
		if(backLink != null)
			backLink.innerHTML = '<a href="javascript:window.history.back()">back</a>';
	}
}
main();