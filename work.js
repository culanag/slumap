/*window.onload = function() {
	document.getElementById('go').addEventListener('click', loadPredefinedPanorama, false);
};*/

// Load the predefined panorama
function loadPredefinedPanorama() {
	//evt.preventDefault();

	// Loader
	var loader = document.createElement('div');
	loader.className = 'loader';

	// Panorama display
	var div = document.getElementById('sphere-container');
	div.style.height = '30px';

	var PSV = new PhotoSphereViewer({
		// Path to the panorama
		panorama: 'pano1.jpg',

		// Container
		container: div,

		// Deactivate the animation
		time_anim: false,

		// Display the navigation bar
		navbar: true,

		// Resize the panorama
		size: {
			width: '100%',
			height: '500px'
		},

		// HTML loader
		loading_html: loader,

		// Overlay
		overlay: {
			image: 'overlay.png',
			size: {
				width: '42px'
			},
			position: {
				x: 'right',
				y: 'top'
			}
		}
	});
}
