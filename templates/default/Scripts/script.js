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

function main()
{
	if(err = getCookie('error')){
		stat = document.getElementById('StatusText');
		stat.innerHTML =  err.replaceAll('+', ' ');
	}
	
	var result = Array.from(new URLSearchParams(location.href)).length;
	if(result > 1){
		backLink = document.getElementById('back-link');
		if(backLink != null)
			backLink.innerHTML = '<a href="javascript:window.history.back()">back</a>';
	}
	
	var langs = document.getElementById('lng');
	
	for(let i = 0; i < langs.children.length; i++){
		langs[i].addEventListener('click', function(e){
			console.log(e.target.value);
			document.location.href = '&lang='+e.target.value;
		});
	}
}

main();