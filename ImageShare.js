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
	var rotateButton = article.childNodes[1];
	var title = article.childNodes[2];
	var author = article.childNodes[3];
	var image = article.childNodes[4];
	var story = article.childNodes[5];
	image.style.borderRadius = "5px";
	title.style.marginTop = "50px";
	image.style.transform = "rotate(0deg)";
	
	
	if ("by " + loginName.textContent  != author.textContent ) {
		deleteForm.style.display = "none";
	}
	
	image.addEventListener("click", 
		function() {
			article = this.parentNode;
			
			
			var deleteForm = article.childNodes[0];
			var rotateButton = article.childNodes[1];
			var title = article.childNodes[2];
			var author = article.childNodes[3];
			var image = article.childNodes[4];
			var story = article.childNodes[5];
			
			
			if (image.style.height == "150px") {
				image.style.height = "500px";
				image.style.maxWidth = "450px";
				article.style.maxWidth = "500px";
				
				deleteForm.style.backgroundColor = "black";
				rotateButton.style.display = "";
				image.style.maxHeight = "500px";
				image.style.height = "";
				image.style.width = "";
				title.style.marginTop = "50px";
				title.style.maxWidth = "";
				title.style.color = "orange";
				author.style.color = "orange";
				story.style.width = "100%";
				story.style.display = "";
				story.style.color = "white";
				
				
				article.style.padding = "10px";
				article.style.border = "15px groove #2E2E1F";
				article.style.borderRadius = "5px";
				article.style.backgroundColor = "black";
			}
			
			else {
				deleteForm.style.backgroundColor = "white";
				rotateButton.style.display = "none";
				title.style.marginTop = "30px";
				image.style.transform = "rotate(0deg)";
				image.style.height = "150px";
				image.style.cursor = "pointer";
				title.style.color = "black";
				title.style.maxWidth = "300px";
				author.style.color = "black";
				author.style.marginBottom = "10px";
				story.style.marginTop = "10px";
				story.style.display = "none";
				
				article.style.padding = "5px";
				article.style.border = "1px solid #CC3300";
				article.style.borderRadius = "5px";
				article.style.backgroundColor = "white";
				article.style.borderWidth = "3px";
			}
		}
	);
	
	rotateButton.addEventListener("click",
		function() {
			article = this.parentNode;
			author = article.childNodes[3];
			image = article.childNodes[4];
			story = article.childNodes[5];
			
			this.margin = "100px";
			this.marginLeft = "100px";
			
			if (image.style.transform == "rotate(0deg)") {
				author.style.marginBottom = "100px";
				story.style.marginTop = "100px";
				image.style.transform = "rotate(90deg)";
				
			}
			
			else if (image.style.transform == "rotate(90deg)") {
				author.style.marginBottom = "10px";
				story.style.marginTop = "10px";
				image.style.transform = "rotate(180deg)";
			}
			
			else if (image.style.transform == "rotate(180deg)") {
				author.style.marginBottom = "100px";
				story.style.marginTop = "100px";
				image.style.transform = "rotate(270deg)";
			}
			
			else if (image.style.transform == "rotate(270deg)") {
				author.style.marginBottom = "10px";
				story.style.marginTop = "10px";
				image.style.transform = "rotate(0deg)";
			}
			
		}
	);
	
	image.click();
	

	
}






