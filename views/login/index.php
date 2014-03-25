<form action="login/login" method="post" id="loginForm">
	<div id="loginBoxContainer">
		<div id="loginBox">
			<strong>Email:</strong> <br/>
			<input type="text" name="login_email" id="loginEmail" value="<?php echo $con->loginEmail; ?>"/><br/>
			<br/>
			<strong>Password:</strong><br/>
			<input type="password" name="login_password" id="loginPassword"/><br/>
			<br/>
			<input type="submit" value="Login" class="button_link">
			<br/><br/>
			<div class="errorMessage">
				<?php 
					if($con->isError) {
						echo $con->getErrorMessage();
						$con->unsetErrorMessage();
					}
				?>
			</div>
		</div>
	</div>	
	<br/>
</form>