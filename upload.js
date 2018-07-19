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

function loadPOI() {
	var chosen = document.getElementById("poiselect");
	var poi = chosen.options[chosen.selectedIndex].text;
	
	console.log(poi);
	var array = poisdata["Points"];
	var container = document.getElementById("poi-container");
	var imageGallery = document.getElementById("imageGallery");
	for (var d = 0; d < array.length; d++) {
		if (poi == (array[d].building+" - "+array[d].pointname)) {
			console.log(array[d].pointname);
			console.log(array[d].building);
			console.log(array[d].floor);
			console.log(array[d].description);
			console.log(array[d].image);
			document.getElementById("pointnameInput").value = array[d].pointname;
			document.getElementById("buildingInput").value = array[d].building;
			document.getElementById("floorInput").value = array[d].floor;	
			document.getElementById("descriptionInput").innerHTML = array[d].description;
			document.getElementById("coords").innerHTML = "x=" + array[d].x + "<br> y=" + array[d].y;
			var snowball = document.getElementById("circle");
			snowball.style.position = "absolute";
        	snowball.style.left = ((array[d].x)-5)  + 'px';
        	snowball.style.top = ((array[d].y)-5) + 'px';
			document.getElementById("x").value = array[d].x;
        	document.getElementById("y").value = array[d].y;
			
		}
	}
}