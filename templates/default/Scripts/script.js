function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function test()
{
	if(err = getCookie('error')){
		stat = document.getElementById('StatusLabel');
		stat.innerHTML =  err;
	}
	var result = Array.from(new URLSearchParams(location.href)).length;
	if(result > 1){
		backLink = document.getElementById('back-link');
		if(backLink != null)
			backLink.innerHTML = '<a href="javascript:window.history.back()">back</a>';
	}
}
test();