<div id="page-user-profile" class="gen-page-container">
	<?php if($con->validId) { ?>
		<div class="profileHeader">
			<?php echo $con->profileUser->getFullName(); ?>'s Setlists
		</div><br/>
		
		<?php include "/views/user/_profilemenu.php" ?>

		<div class="setlistListContainer">
			<?php
				foreach ($con->setlists as $s) {
					$dateExploded = dateParser($s['date']);
			?>
			
			<div class="setlistContainerListView">
				<div class="setlistDate">
					<span class="setlistMonth"><?php echo $dateExploded[1];?></span><br/>
					<span class="setlistDay"><?php echo $dateExploded[2];?></span><br/>
					<span class="setlistYear"><?php echo $dateExploded[0];?></span><br/>
				</div>
				<div class="setlistInfo">
					<span class="setlistArtist"><a href="/setlist/<?php echo $s['setlist_id']; ?>"><?php echo $s['artist_name'];?></a></span><br/>
					<span class="setlistVenue"><?php echo $s['venue_name'] . ", " . $s['city'] . ", " . $s['state'];?></span>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
		
		
	<?php } else {  ?>
		<div class="errorMessage">
			Invalid User
		</div>
	<?php } ?>
</div>