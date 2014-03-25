<div id="page-user-artists" class="gen-page-container">
	<?php if($con->validId) { ?>
		<div class="profileHeader">
			<?php echo $con->profileUser->getFullName(); ?>'s Artists
		</div><br/>
		
		<?php include "/views/user/_profilemenu.php" ?>

		<div class="setlistListContainer">
			<?php
				while($row = $con->userArtistList->fetch_assoc()) {
					echo $row['artist_name'] . "<br/>";
				}
			?>
		</div>
		<div class="clearfix"></div>
		
		
	<?php } else {  ?>
		<div class="errorMessage">
			Invalid User
		</div>
	<?php } ?>
</div>