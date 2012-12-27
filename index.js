require(["dojo/_base/fx", "dojo/on", "dojo/dom", "dojo/request", 
		"dojo/dom-form", "dojo/dom-construct", "dojo/domReady!"], 
	function(fx, on, dom, request, domForm, domConstruct ) {
		
		var form = dom.byId('login-form');
	
		on(form, "submit", function(evt) {
			
			//prevent the page from navigating after submit
			evt.stopPropagation();
			evt.preventDefault();
		
			request.post("indexJavaScript.php", 
				{
					data: domForm.toObject("login-form"),
					timeout: 2000,
					handleAs: "json",
			
				}
			).then(
				function(data) {
					//alert(data);
					if(data === "false") {
						if(dom.byId("loginError") !== null) {
							domConstruct.destroy(dom.byId("loginError"));
						}
						var LoginFormBox = dom.byId("login-form-box");
						var loginError = domConstruct.create ("div", {
							innerHTML: "<a id='error-message' class='close' data-dismiss='alert'>x</a> Login failed. Either your user name or password is wrong.",
							id: "loginError",
							className: "alert alert-error",
							style: {
								opacity: "0",
								width: "40%",
								margin: "0 auto",
							}
							},  LoginFormBox, "before");
		
							fx.fadeIn({node: loginError, duration: 500}).play();
							
							var ErrorFadeOut = dom.byId("error-message");	
							on(ErrorFadeOut, "click", function(evt){
								fx.fadeOut({ node: "loginError", onEnd: domConstruct.destroy, }).play();
							});
							
					} else if(data === "true"){
						window.location = "addressbook/addressbook.php";
					}
					
				});
			
		});
		
			
		
	}
	
);

