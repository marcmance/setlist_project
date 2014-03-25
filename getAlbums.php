<?php
	include 'connection.php';
	$choice = mysql_real_escape_string($_GET['choice']);
	$album_query = "Select * from album where artist_id ='$choice'";
	$album_result = mysql_query($album_query);
	$song_query = "Select * from song where artist_id ='$choice'";
	$song_result = mysql_query($song_query);
 
	$songArr[] = array();

	while ($row = mysql_fetch_array($song_result)) {
		$songArr[$row{'album_id'}][$row{'song_id'}] = $row{'song_name'};
	}
	
	echo '<table border="0" cellpadding="0" cellspacing="0" id="album_song_table"><tr><td valign="top" id="album_td">';
	
	//this forward loop creates the album cover art TD
	$counter = 1;
	while ($row = mysql_fetch_array($album_result)) {
		if($counter == 1) {
			echo '<a href="#" class="album_link" id="album_link_'.$row{'album_id'}.'"><img class="album_art_show" id="album_art_'.$row{'album_id'}.'" border="0" width="100" height="100" src="imgs/'.$row{'cover_art_url'} . '"></a>';
		}
		else {
			echo '<a href="#" class="album_link" id="album_link_'.$row{'album_id'}.'"><img class="album_art_hide" id="album_art_'.$row{'album_id'}.'" border="0" width="100" height="100" src="imgs/'.$row{'cover_art_url'} . '"></a>';
		}
		$counter++;
	}
	echo '</td><td valign="top" id="arrow_td">';
	
	mysql_data_seek($album_result, 0);
	$counter = 1;
	
	while ($row = mysql_fetch_array($album_result)) {
		if($counter == 1) {
			echo '<div class="arrow_container" id="arrow'.$row{'album_id'}.'"><div class="arrow-left"></div></div>';
		}
		else {
			echo '<div class="arrow_container" id="arrow'.$row{'album_id'}.'"><div></div></div>';
		}
		$counter++;
	}
	echo '</td><td valign="top" id="song_td">';
	mysql_data_seek($album_result, 0);
	$counter = 1;
	while ($row = mysql_fetch_array($album_result)) {
		//if its the first album, apply the opacity to 100%
		if($counter == 1) {
			echo '<div id="album_songs_'.$row{'album_id'}.'" class="album_songs_show">';
		}
		else {
			echo '<div id="album_songs_'.$row{'album_id'}.'" class="album_songs_hide">';
		}
		echo "<center><span class=\"album_title\"><b>" . $row{'album_name'} . " (". $row{'year'} .") </b></span></center><br/>";
		echo "<ul>";
		//loop through each song
		foreach ($songArr[$row{'album_id'}] as $k => $s) {
			echo '<li class="albumItem" id="' .$k . '"> <b>'.$s.'</b></li>';
		}
		echo '</ul>';
		echo '</div>';
		$counter++; 
	}
	
	echo '</td></tr></table>';
	
	foreach ($songArr as $song) {
		foreach ($song as $s) {
			//echo "$s<br/>";
		}
	}
?>
<script>
	$('.album_songs_hide').hide();
	$(".album_art_hide").fadeTo(0, 0.5, function() {
			  // Animation complete.
			});
			
	$(".album_art_hide").hover(function(){$(this).fadeTo(0,1,function(){});}, function(){$(this).fadeTo(0,0.5,function(){});}  );

	$('.album_link').click(function(e) {
			e.preventDefault(); 
		var album_id = $(this).attr("id");
		album_id = album_id.substring(11,album_id.length);

		//alert(album_id);
		$(".album_songs_show").attr("class","album_songs_hide");
		$("div #album_songs_"+  album_id).attr("class","album_songs_show");
		$(".album_songs_show").show();
		$('.album_songs_hide').hide();
		
		$(".album_art_show").attr("class","album_art_hide");
		$("#album_art_"+  album_id).attr("class","album_art_show");
		$(".album_art_hide").fadeTo(0, 0.5, function() {
		  // Animation complete.
		});
		
		//$(".album_art_show").hover(function(){$(this).fadeTo(0,1,function(){});}, function(){$(this).fadeTo(0,1,function(){});}  );
		$(".album_art_show").unbind("hover");
		$(".album_art_hide").hover(function(){$(this).fadeTo(0,1,function(){});}, function(){$(this).fadeTo(0,0.5,function(){});}  );
		
		//arrow
		
		$('div.arrow-left').each(function(){
			$(this).removeClass("arrow-left");
		});
		$("div #arrow"+ album_id).find('div').attr("class","arrow-left");
		
		
	});

/*
$('.connected').sortable({
	connectWith: '#mainSetlist'
});*/

</script>