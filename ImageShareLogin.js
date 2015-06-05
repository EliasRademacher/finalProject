var createAccountForm = document.getElementById("createAccount");
var loginForm = document.getElementById("login");
var username = document.getElementById("username");
var password = document.getElementById("password");
var usernameInit = document.getElementById("usernameInit");
var usernameInitLabel = document.getElementById("usernameInitLabel");
var passwordInit1 = document.getElementById("passwordInit1");
var passwordInit2 = document.getElementById("passwordInit2");
var passwordInit2Label = document.getElementById("passwordInit2Label");

var button = document.getElementsByTagName("button")[0];
var body = document.getElementsByTagName("body")[0];



createAccountForm.style.display = "none";


button.addEventListener("click", 
 function() {
	 if (createAccountForm.style.display == "none") {
		 createAccountForm.style.display = "";
		 loginForm.style.display = "none";
		 this.innerHTML = "Return to login page";
	 }
	 
	 else {
		 loginForm.style.display = "";
		 createAccountForm.style.display = "none";
		 this.innerHTML = "Create an Account";
	 }
	 
 }
);

passwordInit1.oninput = 
	function(){
		if (usernameInit.value == "") {
			usernameInitLabel.style.color = "red";
		}
	};
	
usernameInit.oninput = 
	function() {
		usernameInitLabel.style.color = "white";
		if (-1 != usernameInit.value.indexOf(" ")) {
			usernameInitLabel.innerHTML = "No spaces, please";
			usernameInitLabel.style.color = "red";
		}
		
		else {
			usernameInitLabel.innerHTML = "Enter a username:";
			usernameInitLabel.style.color = "white";
		}
	};


passwordInit2.oninput = 
	function(){
		if (this.value != passwordInit1.value) {
			passwordInit2Label.innerHTML = "passwords do not match";
			passwordInit2Label.style.color = "red";
		}
		
		else if (this.value == passwordInit1.value) {
			passwordInit2Label.innerHTML = "passwords match";
			passwordInit2Label.style.color = "green";
		}
		
	};
	





