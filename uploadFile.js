function uploadFile() {
	
	var form = document.getElementById('image_form');
	var imageSelect = document.getElementById('image_input');
	
	/* Get the selected files from the input. */
	var images = imageSelect.files;
	
	/* Create a new FormData object. */
	var formData = new FormData();
	
  //var image = images[0];

  /* Check the file type. */
  if (!image.type.match('image.*')) {
		alert("file must be an image\n");
    return false;
  }

  /* Add the file to the request. */
  formData.append('picture', image);
	url = "http://web.engr.oregonstate.edu/~rademace/ImageShare/ImageShare.php";
	
	
	 /* Mozilla, Safari,... */
	if (window.XMLHttpRequest) {
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
		}
	}
	
	
	 /* Internet Explorer */
	else if (window.ActiveXObject) {
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		
		catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	
	
	if (!http_request) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	
	
	
	http_request.onreadystatechange = uploadStatus;
	http_request.open('POST', 'ImageShare.php', true);
	http_request.send(formData);

	
};


var uploadStatus = function() {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			alert("upload successful!");
		}
		
		else {
			alert('There was a problem with the request.');
		}
	}
}
