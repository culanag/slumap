function storeDataInLS(fileName, localID) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", fileName, true);
	xhttp.setRequestHeader("Content-type", "application/json");
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		     var res = this.responseText;
		     var string = JSON.stringify(res);
		     localStorage.setItem(localID, string);
		}
	};
	xhttp.send();
}

if(localStorage.getItem("pois") == undefined)
	storeDataInLS("poi-v6.json", "pois");

// eval is used because parsed item coming from LS is still a string
var mapObjectsJSON = localStorage.getItem("Map");
var mapObj = JSON.parse(mapObjectsJSON);

var poisObjectsJSON = localStorage.getItem("pois");
var poisObj = JSON.parse(poisObjectsJSON);
eval("var poisdata = " + poisObj);

function loadPOIS(array) {
	var select = document.getElementById("poiselect");
	for (var c = 0; c < array.length; c++) {
		var option = document.createElement("OPTION");
		var text = document.createTextNode(array[c].building + " - " + array[c].pointname);

		option.appendChild(text);
		option.value = array[c].pointname;
		select.appendChild(option);
	}
}