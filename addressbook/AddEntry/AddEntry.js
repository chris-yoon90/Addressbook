require(["dojo/_base/fx", "dojo/_base/lang", "dojo/on", "dojo/dom", "dojo/request", 
		"dojo/dom-form", "dojo/dom-construct", "dojox/validate/ca", "dojox/validate/web", "dojo/json", 
		"dojo/dom-attr", "dojo/domReady!"], 
	function(fx, lang, on, dom, request, domForm, domConstruct, validateCa, validateWeb, domAttr, JSON ) {
		
		var form = dom.byId("add-entry-form");
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
			if(dom.byId("addressError") !== null) {
				domConstruct.destroy(dom.byId("addressError"));
			}
			if(dom.byId("cityError") !== null) {
				domConstruct.destroy(dom.byId("cityError"));
			}
			if(dom.byId("provinceError") !== null) {
				domConstruct.destroy(dom.byId("provinceError"));
			}
			if(dom.byId("zipcodeError") !== null) {
				domConstruct.destroy(dom.byId("zipcodeError"));
			}
			if(dom.byId("telNumberError") !== null) {
				domConstruct.destroy(dom.byId("telNumberError"));
			}
			if(dom.byId("faxNumberError") !== null) {
				domConstruct.destroy(dom.byId("faxNumberError"));
			}
			if(dom.byId("emailError") !== null) {
				domConstruct.destroy(dom.byId("emailError"));
			}

			
			var formObject = domForm.toObject("add-entry-form");
			var errorCount = 0;
			//alert(JSON.stringify(formObject));
			//alert(typeof(formObject.tel_number));
			
			if(!validateWeb.isText(formObject.first_name)) {
				var firstName = dom.byId("first_name");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "firstNameError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  firstName, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(!validateWeb.isText(formObject.last_name)) {
				var lastName = dom.byId("last_name");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "lastNameError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  lastName, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if(lang.trim(formObject.address) === "" ) {
				if(lang.trim(formObject.city) !== "" || lang.trim(formObject.province) !== "default") {
					var address = dom.byId("address");
					var errorMessage = domConstruct.create ("span", {
							innerHTML: "Please fill out the Street Address information.",
							id: "addressError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  address, "after");
				
					fx.fadeIn({node: errorMessage, duration: 500}).play();
				
					errorCount++;
				}
			}
			
			if(lang.trim(formObject.city) === "" ) {
				if(lang.trim(formObject.address) !== "" || lang.trim(formObject.province) !== "default") {
					var city = dom.byId("province");
					var errorMessage = domConstruct.create ("span", {
							innerHTML: "Please fill out the City information.",
							id: "cityError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  city, "after");
				
					fx.fadeIn({node: errorMessage, duration: 500}).play();
				
					errorCount++;
				}
			}
			
			if(lang.trim(formObject.province) === "default") {
				if((lang.trim(formObject.address) !== "") ||(lang.trim(formObject.city) !== "")) {
					var province = dom.byId("province");
					var errorMessage = domConstruct.create ("span", {
							innerHTML: "Please select a province.",
							id: "provinceError",
							className: "help-inline",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  province, "after");
				
					fx.fadeIn({node: errorMessage, duration: 500}).play();
				
					errorCount++;
				}
			}
			
			if((lang.trim(formObject.zipcode) !== "") && !validateCa.isPostalCode(formObject.zipcode)) {
				var zipcode = dom.byId("zipcode");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "zipcodeError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  zipcode, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if((lang.trim(formObject.tel_number) !== "") && !validateCa.isPhoneNumber(formObject.tel_number)) {
				var tel_number = dom.byId("tel_number");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "telNumberError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  tel_number, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if((lang.trim(formObject.fax_number) !== "") && !validateCa.isPhoneNumber(formObject.fax_number)) {
				var fax_number = dom.byId("fax_number");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "faxNumberError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  fax_number, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			if((lang.trim(formObject.email) !== "") && !validateWeb.isEmailAddress(formObject.email)) {
				var email = dom.byId("email");
				var errorMessage = domConstruct.create ("span", {
							innerHTML: "Invalid input.",
							id: "emailError",
							className: "help-block",
							style: {
								opacity: "0",
								color: "#FF0000",	
							}
							},  email, "after");
				
				fx.fadeIn({node: errorMessage, duration: 500}).play();
				
				errorCount++;
			}
			
			
			if(errorCount == 0) {
		
				request.post("AddEntryJavaScript.php", 
					{
						data: domForm.toObject("add-entry-form"),
						timeout: 2000,
						//handleAs: "json",
						
					}
				).then(
					function(data) {
						//alert(data);
						if(data === "success") {
							alert("Registration was successful.");
							window.location = "../addressbook.php";
						} else if(data === "failed") {
							alert("Registration has failed.");
							window.location = "AddEntry.php";
						} 
					
					
					});
			}
			
		});
	
	
	
	
	
	});