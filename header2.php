<style>
.fixedElement {
    background-color: #688C96;
	color: #FFFFFF;
    position:fixed;
    top:0;
    width:100%;
	height: 20px;
    z-index:100;
	font-family: Helvetica;
}

.fixedElement a, .fixedElement a:visited {
	color: #FFFFFF;
}
</style>

<div class="fixedElement">
	<a href="/newSetlist.php">New Setlist</a> | 
	<a href="/yourSetlists.php">Setlists</a> | 
	<a href="/artist_songs.php">Insert</a> | 
	
	<?php
		if($con->loggedIn) {
		?>
			<a href="/user/<?php echo $con->s_user->username; ?>"><?php echo $con->s_user->user_first_name ?></a> | 
			<a href="/login/logout">Logout</a>
		<?php
		}
		else {
		?>
			<a href="/login">Login</a>
		<?php
		}
	?>
	
</div>