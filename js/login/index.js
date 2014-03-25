
$(document).ready(function() {
	var errorMessage = $('.errorMessage');

	$("#loginForm").submit(function(e) {
		//alert($("#loginEmail").val());
		if($("#loginEmail").val() == "" || $("#loginPassword").val() == "") {
			e.preventDefault();
			errorMessage.text("Please enter your email and password.");
			errorMessage.show();
			//$("#errorMessage").css("color","red");
		}
	});
	
	if (errorMessage.html().trim() === "") {
		errorMessage.hide();
	}
});

