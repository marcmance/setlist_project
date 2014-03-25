$(document).ready(function() {
	var errorMessage = $('.errorMessage');

	$("#registerNewUserForm").submit(function(e) {

		$("#registerNewUserForm input").each(function(){
			if($(this).val() == "") {
				$(this).css("border","1px solid red");
			}
			else {
				$(this).css("border","1px solid green");
			}
		});
		
		if($("#registerEmail").val() == "" || $("#registerPassword").val() == "") {
			e.preventDefault();
			errorMessage.text("Please enter your email and password.");
			errorMessage.show();
		}
	});
	
	if (errorMessage.html().trim() === "") {
		errorMessage.hide();
	}
});

