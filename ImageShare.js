// document.body.style.backgroundColor = "#003300"; 

var story = document.getElementById("story");
story.style.width = "100%";
story.placeholder = "Write a little story that takes place in your picture";

story.addEventListener("click", 
	function() {
		if (this.style.height == "") {
			this.style.height = "200px";
			this.style.width = "100%";
		}
		
		else if (this.style.height == "200px")
			this.style.height = "";
	}
);

var articleList = document.getElementsByTagName("article");

for (var i = 0; i < articleList.length; i++) {
	articleList[i].style.textAlign = "center";
	articleList[i].style.margin = "20px";
	articleList[i].style.cssFloat = "left";
	articleList[i].style.boxShadow = "5px 10px 30px";
	
	var title = articleList[i].childNodes[0];
	var image = articleList[i].childNodes[1];
	var story = articleList[i].childNodes[2];
	image.style.borderRadius = "5px";
	
	image.addEventListener("click", 
		function() {
			if (this.style.height == "100px") {
				this.style.height = "";
				this.style.maxHeight = "500px";
				this.previousSibling.style.color = "white";
				this.nextSibling.style.display = "";
				this.nextSibling.style.color = "white";
				this.parentNode.style.padding = "10px";
				this.parentNode.style.border = "15px groove #2E2E1F";
				this.parentNode.style.borderRadius = "5px";
				this.parentNode.style.backgroundColor = "black";
			}
			
			else if (this.style.height == "") {
				this.style.height = "100px";
				this.style.cursor = "pointer";
				this.previousSibling.style.color = "black";
				this.nextSibling.style.display = "none";
				this.parentNode.style.padding = "2px";
				this.parentNode.style.border = "1px solid #2E2E1F";
				this.parentNode.style.borderRadius = "5px";
				this.parentNode.style.backgroundColor = "";
			}
		}
	);
	
	
	image.click();
	
}






