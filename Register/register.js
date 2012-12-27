require(["dojo/_base/fx", "dojo/on", "dojo/dom", "dojo/request", 
		"dojo/dom-form", "dojo/dom-construct", "dojox/validate/web", "dojo/json", "dojo/query", "dojo/domReady!"], 
	function(fx, on, dom, request, domForm, domConstruct, validate, JSON, query ) {
		
		var form = dom.byId("register-form");
		on(form, "submit", function(evt) {
			
			//prevent the page from navigating after submit
			evt.stopPropagation();
			evt.preventDefault();
			
			//Delete any error messages if they exist already
			if(dom.byId("firstNameError") !== null) {
				domConstruct.destroy(dom.byId("firstNameError"));
			}
			if(dom.byId("lastNameError") !== null) {
				domConstruct.destroy(dom.byId("lastNameError"));
			}
			if(dom.byId("emailError") !== null) {
				domConstruct.destroy(dom.byId("emailError"));
			}
			if(dom.byId("usernameError") !== null) {
				domConstruct.destroy(dom.byId("usernameError"));
			}
			if(dom.byId("passwordError") !== null) {
				domConstruct.destroy(dom.byId("passwordError"));
			}
			if(dom.byId("confirmPasswordError") !== null) {
				domConstruct.destroy(dom.byId("confirmPasswordError"));
			}
			
			var formObject = domForm.toObject("register-form");
			var errorCount = 0;
			
			if(!validate.isText(formObject.first_name)) {
				var firstName = dom.byId("first_name");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "firstNameError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  firstName, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(!validate.isText(formObject.last_name)) {
				var lastName = dom.byId("last_name");
				var firstName = dom.byId("first_name");
				
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "lastNameError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  lastName, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(!validate.isEmailAddress(formObject.email)) {
				var email = dom.byId("email");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "emailError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  email, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(!validate.isText(formObject.username, {minlength: 4, maxlength: 13})) {
				var username = dom.byId("username");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "usernameError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  username, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(!validate.isText(formObject.password, {minlength: 6, maxlength: 13})) {
				var password = dom.byId("password");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "passwordError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  password, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				errorCount++;
			}
			
			if(formObject.password !== formObject.confirm_password) {
				var confirm_password = dom.byId("confirm_password");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "confirmPasswordError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  confirm_password, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				errorCount++;
			}
			
			if(errorCount == 0) {
		
				request.post("registerJavaScript.php", 
					{
						data: domForm.toObject("register-form"),
						timeout: 2000,
					}
				).then(
					function(response) {
						//alert(response);
						if(response === "success") {
							alert("Registration was successful.");
							window.location = "../index.php";
						} else if(response === "failed") {
							/*var error = domConstruct.create("div", {
							innerHTML: "<a id='error-message' class='close' data-dismiss='alert'>x</a> Registration failed.",
							className: "alert alert-error",
							style: {
								opacity: "0",
								width: "60%",
							}
							},  dom.byId("register_title"), "after");
							
							fx.fadeIn({node: error, duration: 500}).play();
							
							var ErrorFadeOut = dom.byId("error-message");	
							on(ErrorFadeOut, "click", function(evt){
								fx.fadeOut({ node: error, onEnd: domConstruct.destroy, }).play();
							});*/
							alert("Registration has failed.");
							window.location = "register.php";
							
						} 
					
					});
			}
			
		});
	
	
	
	
	
	});