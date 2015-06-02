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
	
	var article = articleList[i];
	
	article.style.textAlign = "center";
	article.style.margin = "20px";
	article.style.cssFloat = "left";
	article.style.boxShadow = "5px 10px 30px";
	
	
	var title = article.childNodes[0];
	var author = article.childNodes[1];
	var image = article.childNodes[2];
	var story = article.childNodes[3];
	image.style.borderRadius = "5px";
	
	article.addEventListener("click", 
		function() {
			var title = this.childNodes[0];
			var author = this.childNodes[1];
			var image = this.childNodes[2];
			var story = this.childNodes[3];
			
			
			if (image.style.height == "150px") {
				image.style.height = "500px";
				image.style.maxWidth = "450px";
				this.style.maxWidth = "500px";
				
				image.style.maxHeight = "500px";
				image.style.height = "";
				title.style.color = "white";
				author.style.color = "white";
				story.style.width = "100%";
				story.style.display = "";
				story.style.color = "white";
				
				
				this.style.padding = "10px";
				this.style.border = "15px groove #2E2E1F";
				this.style.borderRadius = "5px";
				this.style.backgroundColor = "black";
			}
			
			else {
				image.style.height = "150px";
				title.style.color = "black";
				author.style.color = "black";
				story.style.display = "none";
				
				this.style.cursor = "pointer";
				this.style.padding = "2px";
				this.style.border = "1px solid #2E2E1F";
				this.style.borderRadius = "5px";
				this.style.backgroundColor = "";
			}
		}
	);
	
	
	article.click();
	
}






