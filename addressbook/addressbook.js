require(["dojo/_base/fx", "dojo/on", "dojo/dom", "dojo/request", 
		"dojo/dom-form", "dojo/dom-construct", "dojo/query", "dojo/json", "dojo/_base/array", 
		"dojo/dom-attr", "dojo/domReady!"], 
	function(fx, on, dom, request, domForm, domConstruct, query, JSON, arrayUtil ) {
		
		if(dom.byId('view-button') != null) {
			domConstruct.destroy(dom.byId("view-button"));
		}
		var DeleteForm = dom.byId("view-form");
		var record = query("#select-record");
		
		record.on( "change", function(evt) {

			//prevent the page from navigating after submit
			evt.stopPropagation();
			evt.preventDefault();
			
			if(this.value == "default") {
				//if value is "default," do nothing
				
			} else {
				request.post("ViewJavaScript.php", 
					{
						data: domForm.toObject("view-form"),
						timeout: 2000,
						handleAs: "json",
					}
				).then(
					function(data) {
						//alert(JSON.stringify(data));
						var DetailView = dom.byId("detail-view");
						DetailView.innerHTML = "";
						var test = domConstruct.create("div", {
						style: {
							opacity: "0",
						}
						}, DetailView);
						
						var content = "<h2>" + data.name + "</h2>"
										+ "<fieldset>";
						
						//Print Address
						content += "<legend>Address:</legend><ul>";
						arrayUtil.forEach(data.addressInfo, function(item,i) {
							content += "<li>" + item.address + " " + item.city + " " + item.province + " " 
										+ item.zipcode + " (" + item.type +")" + "</li>";
						});
						content += "</ul></fieldset><fieldset>";
						
						//Print Telephone
						content += "<legend>Telephone:</legend><ul>";
						arrayUtil.forEach(data.telInfo, function(item,i) {
							content += "<li>" + item.tel_number + " (" + item.type +")" + "</li>";
						});
						content += "</ul></fieldset><fieldset>";
						
						//Print Fax
						content += "<legend>Fax:</legend><ul>";
						arrayUtil.forEach(data.faxInfo, function(item,i) {
							content += "<li>" + item.fax_number + " (" + item.type +")" + "</li>";
						});
						content += "</ul></fieldset><fieldset>";
						
						//Print Email
						content += "<legend>Email:</legend><ul>";
						arrayUtil.forEach(data.emailInfo, function(item,i) {
							content += "<li>" + item.email + " (" + item.type +")" + "</li>";
						});
						content += "</ul></fieldset><fieldset>";
						
						//Print Notes
						content += "<legend>Note:</legend><ul>";
						arrayUtil.forEach(data.noteInfo, function(item,i) {
							content += "<li>" + item.note + "</li>";
						});
						content += "</ul></fieldset>";
						
						test.innerHTML = content;
						
						fx.fadeIn({node: test, duration: 300}).play();
							
					});
			}
			
		});
		
		on(DeleteForm, "submit", function(evt) {
			//prevent the page from navigating after submit
			evt.stopPropagation();
			evt.preventDefault();
			
			request.post("DeleteJavaScript.php", 
					{
						data: domForm.toObject("view-form"),
						timeout: 2000,
						handleAs: "json",
					}
				).then(
					function(data) {
						//alert(JSON.stringify(data));
						//alert(data);
						var DetailView = dom.byId("detail-view");
						DetailView.innerHTML = "";
						var Message = domConstruct.create("div", {
								style: {
									opacity: "0",
								}
							}, DetailView);
						
						if(data.status === "failed") {
							//Failed to delete. Display an error message.
							Message.innerHTML = "Error: Deletefailed";
							Message.className = "alert alert-error";
							
						} else 
						if(data.status === "success") {
							//Success deleting a contact. Display the result.
							Message.innerHTML = "Success: The contact was successfully deleted";
							Message.className = "alert alert-success";
							//Reload sidebar navigaion
							var SelectBar = dom.byId("select-record");
							SelectBar.innerHTML = "";
							var content = "<option class='rec' value='default'>--Select One--</option>";
							
							arrayUtil.forEach(data.contact_info, function(item,i) {
								content += "<option value='" + item.id + "'>	" + item.display_name + "</option>";
							});
		
							SelectBar.innerHTML = content;
							
							if(data.contact_info === null) {
								var test = domConstruct.create("div", {
									innerHTML: "No records found. Click Add Entry to add a contact.",
									}, dom.byId("record-block"), "after");
								
							} else {
								

							}
							
						} else {
							//Default value was chosen. Display appropriate instructions.
							Message.innerHTML = "<h2>Please select a valid contact to delete </h2>";
	
						}
						
						fx.fadeIn({node: Message, duration: 300}).play();
						
					});
			
		});
		
	
});