//

function doSubmit(f,a) {
	// alert(a);
	f.action = a;
	f.submit();
}

function highlightcontent(id) {
	var f = document.getElementById(id); 
	f.select(); 
	f.focus(); 
} 

function copycontent(id) { 
	highlightcontent(id); 
	var f = document.getElementById(id);
	if (f.createTextRange()) {
		textRange = f.createTextRange(); 
		textRange.execCommand("RemoveFormat"); 
		textRange.execCommand("Copy"); 
		alert("Contents highlighted and copied to clipboard!"); 
	}
} 
