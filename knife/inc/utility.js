function toggleDisplay(obj_id){
	if (document.getElementById){
		var obj = document.getElementById(obj_id);
		if (obj.style.display == '' || obj.style.display == 'none'){
			var state = 'block';
			} 
		else {
			var state = 'none';
			}
		obj.style.display = state;
		}
}