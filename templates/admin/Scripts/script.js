function test()
{
	var result = Array.from(new URLSearchParams(location.href)).length;
	if(result > 1){
		backLink = document.getElementById('back-link');
		if(backLink != null)
			backLink.innerHTML = '<a href="javascript:window.history.back()">back</a>';
	}
}
test();