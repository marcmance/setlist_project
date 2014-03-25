<div id="view_setlist_menu">
	<table cellspacing="10">
		<tr>
			<td>
				<div id="all_div">All</div>
			</td>
			<td>
				<div id="artist_div">Artist</div>
			</td>
			<td>
				<div id="venue_div">Venue</div>
			</td>
			<td>
				<div id="date_div">Date</div>
			</td>
		</tr>
	</table>
	
	<script>
		$(document).ready(function() {
			var path = window.location.pathname;
			if(path == "/yourSetlists.php") {
				$("#all_div").css("background", selectedColor);
			}
			else if(path == "/artistSetlists.php") {
				$("#artist_div").css("background", selectedColor);
			}
		});
		$("#view_setlist_menu div").click(function(){
			var div_id = $(this).attr("id");
			if(div_id == "all_div") {
				window.location = "/yourSetlists.php";
			}
			else if(div_id == "artist_div") {
				window.location = "/artistSetlists.php";
			}
			else if(div_id == "venue_div") {
				window.location = "/venueSetlists.php";
			}
			else if(div_id == "date_div") {
				window.location = "/dateSetlists.php";
			}
		});
	</script>
</div>