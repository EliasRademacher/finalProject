var story = document.getElementById("story");
var loginName = document.getElementById("loginName");
var loginName = document.getElementById("loginName");

story.placeholder = "Write a little story here that took place in your photo. \
	It can be fiction or nonfiction";

story.oninput =
	function() {
		if (this.style.height == "") {
			this.style.height = "200px";
			this.style.width = "100%";
		}
	};

var articleList = document.getElementsByTagName("article");

for (var i = 0; i < articleList.length; i++) {
	
	var article = articleList[i];
	
	article.style.textAlign = "center";
	article.style.margin = "20px";
	article.style.cssFloat = "left";
	article.style.boxShadow = "5px 10px 30px";
	
	var deleteForm = article.childNodes[0];
	var deleteButton = deleteForm.childNodes[2];
	var title = article.childNodes[1];
	var author = article.childNodes[2];
	var image = article.childNodes[3];
	var story = article.childNodes[4];
	image.style.borderRadius = "5px";

	
	
	
	if ("by " + loginName.textContent  != author.textContent )
		deleteForm.style.display = "none";
	
	var changeDisplay;
	
	article.addEventListener("click", 
		changeDisplay = function() {
			
			if (this.nodeName == "button") {
				return;
			}
			
			
			
			var deleteForm = this.childNodes[0];
			var title = this.childNodes[1];
			var author = this.childNodes[2];
			var image = this.childNodes[3];
			var story = this.childNodes[4];
			
			
			if (image.style.height == "150px") {
				image.style.height = "500px";
				image.style.maxWidth = "450px";
				this.style.maxWidth = "500px";
				
				deleteForm.style.backgroundColor = "black";
				image.style.maxHeight = "500px";
				image.style.height = "";
				title.style.maxWidth = "";
				title.style.color = "#CCFFFF";
				author.style.color = "#CCFFFF";
				story.style.width = "100%";
				story.style.display = "";
				story.style.color = "white";
				
				
				this.style.padding = "10px";
				this.style.border = "15px groove #2E2E1F";
				this.style.borderRadius = "5px";
				this.style.backgroundColor = "black";
			}
			
			else {
				deleteForm.style.backgroundColor = "white";
				image.style.height = "150px";
				title.style.color = "black";
				title.style.maxWidth = "300px";
				author.style.color = "black";
				story.style.display = "none";
				
				this.style.cursor = "pointer";
				this.style.padding = "5px";
				this.style.border = "1px solid #669999";
				this.style.borderRadius = "5px";
				this.style.backgroundColor = "white";
				this.style.borderWidth = "3px";
			}
		}
	);
	
	article.click();
	
}






