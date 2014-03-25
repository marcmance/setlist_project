<div id="loginBoxContainer">
	<div id="loginBox">
		<b>Register a new user</b><br/>
		<br/>
		<form action="user/create" method="post" id="registerNewUserForm">
			<b>First Name:</b> <input type="text" name="register_first_name" id="registerFirstName"/><br/>
			<b>Last Name:</b> <input type="text" name="register_last_name" id="registerLastName"/><br/>
			<b>Email:</b> <input type="text" name="register_email" id="registerEmail"/><br/>
			<b>Password:</b> <input type="password" name="registerPassword" id="registerPassword"/><br/>
			<br/>
			<input type="submit" value="Register" class="button_link">
			<br/>
			<br/>
			<div class="errorMessage"></div>
		</form>
		<br/>
		<br/>
	</div>

	
	<?php
		//$m = new Model();
		//printArray($m->query("SELECT user_id,user_first_name from user where user_id = ? limit 1"));
	
	?>
	
	<div class="setlistContainerListView">
		<div class="setlistDate">
			<span class="setlistMonth">APRIL</span><br/>
			<span class="setlistDay">20</span><br/>
			<span class="setlistYear">2013</span><br/>
		</div>
		<div class="setlistInfo">
			<span class="setlistArtist">Motion City Soundtrack</span><br/>
			<span class="setlistVenue">Starland Ballroom, Sayerville, NJ</span>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
