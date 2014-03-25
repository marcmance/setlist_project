<?php
include 'connection.php';
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	
		<link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
		<link href="styles/styles.css" type="text/css" rel="stylesheet" />
	
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
		<script>

		$(document).ready(function() {
		
			var selectedList = {};
			var isEncore = false;
			
			$("#encore_and_form").hide();
			$(".errors").hide();
			
			$("li.albumItem").live('click', function(){
				//raw song ID comes from here!
				var liID = $(this).attr("id");
				if(selectedList[liID]) {
					selectedList[liID] = false;
					$(this).css("background",startColor);
					$("#mainSetlist li#m-" + liID).remove();
				}
				else {
					selectedList[liID] = true;
					$(this).css("background",selectedColor);
					var listItem = "<li id=\"m-" + liID + "\" class=\"mainSetlistItem\">";
					listItem += "<table border=\"0\" width=\"100%\">";
					listItem += "<tr><td class=\"li_song_name\"><b>" + $(this).text() + "</b></td>"
					listItem += "<td align=\"right\" width=\"65\">";
					listItem += "<div class=\"main_setlist_li_extra\" id=\"td"+ liID +"\">";
					listItem += "<a class=\"deleteFromUL\" href=\"#\" id=\"d-"+ liID +"\">";
					listItem += "<i class=\"icon-remove\"></i></a>|<a class=\"addInfoUL\" href=\"#\" id=\"add-"+ liID +"\"><i class=\"icon-double-angle-right\"></i> </a>";
					listItem += "</div></td></tr></table></li>";
					//listItem += "<input type='hidden' name='songs[]' value='"+liID+"'/>"
					
					$("#mainSetlist").append(listItem);
					$('#mainSetlist').sortable();
					if(isEncore) {
						setLiToEncore();
					}
					$(".main_setlist_li_extra").hide(); //hide on load	
					
				}
				showEncoreAndEnter();
			});

			//LI
			$(".mainSetlistItem").live('mouseover mouseout', function(event) {
				var liID = parseId($(this).attr("id"));
				if (event.type == 'mouseover') {
					if(!$(this).hasClass("encore")) {
						$(this).css("background",selectedColor);
					}
					$("#td"+liID).show();
				} 
				else {
					if(!$(this).hasClass("encore")) {
						$(this).css("background",startColor);
					}
					$("#td"+liID).hide();
				}
			});
			
			$("a.deleteFromUL").live('click', function(){
				var liID = parseId($(this).attr("id"));
				$("#mainSetlist li#m-" + liID).remove();
				selectedList[liID] = false;
				$("li#" + liID).css("background",startColor);
				$("#songInfoDiv div#songInfo-" + liID).remove();
				showEncoreAndEnter();
			});
			
			$("a.addInfoUL").live('click', function(){
				var liID = parseId($(this).attr("id"));	
				var songName = $("li#m-"+liID+" table td.li_song_name").text();
				
				$(".songInfo").hide();				
				if(!document.getElementById("songInfo-"+liID)) {
					var divItem = '<div class="songInfo" id="songInfo-'+liID+'" height="40" border="1">'
					divItem += '<b>Extra notes for '+songName +'</b><br/>'
					divItem += '<textarea rows="4" cols="50" id="song_notes_'+liID+'"/>';
					divItem += '</div>';
					$("#songInfoDiv").append(divItem);
				}
				else {
					$("#songInfo-"+liID).show();
				}
			});
			
			$('#mainSetlist').sortable().bind('sortupdate', function(e, ui) {
				if(isEncore) {	
					setLiToEncore();
				}
			});
			
			//BUTONS
			$("#encore_button").click(function() {
				if(!isEncore){
					var listItem = '<li class="encore_line"></li>';
					$(this).css("background", encoreColor);
					$("#mainSetlist").append(listItem);
					$('#mainSetlist').sortable();
					isEncore = true;
				}
				else {
					$("#mainSetlist li.encore_line").remove();
					$("li.mainSetlistItem").css("background",startColor).removeClass("encore");
					$(this).css("background", darkColor);
					isEncore = false;
				}
			});
			
			$("#clear_setlist").click(function() {
				$("#mainSetlist").empty();
				$("#songInfoDiv").empty();
				showEncoreAndEnter();
				selectedList = {};
				$("li.albumItem").css("background",startColor);
			});
			
			
			$("#artistSelect").change(function() {
				$("#albumDiv").empty();
				$("#albumDiv").load("getAlbums.php?choice=" + $("#artistSelect").val());
				$("#mainSetlist").empty();
				$("#songInfoDiv").empty();
				showEncoreAndEnter();
			});
		
			$('#spinner').bind("ajaxSend", function() {
				$(this).show();
			}).bind("ajaxComplete", function() {
				$(this).hide();
			});
			
			$(".opacity").fadeTo(0, 0.5, function() {
			  // Animation complete.
			});
			
			$(".opacity").hover(function(){$(this).fadeTo(0,1,function(){});}, function(){$(this).fadeTo(0,0.5,function(){});}  );

			$("form").submit(function() {
				
				if($("#dateSelect").val() == null || $("#dateSelect").val() == "" || 
				$("#venueSelect").val() == "") {
					$(".errors").show();
					event.preventDefault();
				}
				else{
					$(".errors").hide();
					var hiddenInputs = '';
		
					var songArray = new Array();
					$("#mainSetlist li.mainSetlistItem").each(function() {
						var liID = parseId($(this).attr("id"));
						var encore = "false";
						var description = $("#song_notes_"+liID).val();
						if(description == null || description == "") {
							description = "";
						}
						else {
							
						}
						if($(this).hasClass("encore")) {
							encore = "true";
						}
					
						var arr = new song(liID, encore, description);
						songArray.push(arr);
						
						//hiddenInputs += '<input type="hidden" name="songs[]" value="'+liID+'"/>';
					});
					
					var songsJSON = JSON.stringify(songArray);
					//alert(songsJSON);
					var hiddenInputs = 	"<input type='hidden' name='hidden_input' value='"+songsJSON+"'/>";
					$("#setlistDiv").append(hiddenInputs);
				}
			});
			
			/******************
				START FUNCTIONS
			********************/
			function song(id, encore, description) {
				this.id = id;
				this.encore = encore;
				this.description = description;
			}
			
			function setLiToEncore() {
				$("li.mainSetlistItem").css("background",startColor).removeClass("encore");
				$("li.encore_line").nextUntil("ul").css("background",encoreColor).addClass("encore");
			}
			
			function showEncoreAndEnter() {
				if($("#mainSetlist li").size() == 0) {
					$("#encore_and_form").hide();
					$("#encore_button").css("background", darkColor);
					isEncore = false;
				}
				else if($("#mainSetlist li").size() == 1 && isEncore) {
					$("#mainSetlist li.encore_line").remove();
					$("input[name='encore']").attr('checked', false);
					$("#encore_button").css("background", darkColor);
					$("#encore_and_form").hide();
					isEncore = false;
				}
				else {
					$("#encore_and_form").show();
				}
			}
		});
		</script>
		<title>Create new setlist</title>
	</head>
	<body>
		<?php include 'header.php'; ?>
		
		<form method="post" action="submitForm.php">
		<select id="artistSelect" name="artistSelect">
			<option>Please select an artist</option>
			<?php 
				$query = "Select * from artist";
				$result = mysql_query($query);
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row{'artist_id'} . "\">".$row{'artist_name'} . "</option>";
				}
			?>
		</select>
		<br/><br/>
		<select id="venueSelect" name="venueSelect">
			<option value="">Please select a venue</option>
			<?php 
				$venue_query = "Select * from venue";
				$venue_result = mysql_query($venue_query);
				while ($row = mysql_fetch_array($venue_result)) {
					echo "<option value=\"".$row{'venue_id'} . "\">".$row{'venue_name'} . "</option>";
				}
			?>
		</select>
		<br/><br/>
		<input name="date" id="dateSelect"/>
	
		<br/>
		<div class="errors">Please correct the errors!</div>
		<br/>
		<table id="mainTable" cellspacing="0">
			<tr>
				<td id="select_songs_td">
					<div id="spinner">
					  <img src="spinner.gif" alt="Loading" />
					</div>
					<div id="albumDiv">
						<b>Please select an artist</b>
					</div>
				</td>
				<td id="setlist_td">
					<div id="setlistDiv">
						<b>Your setlist</b>
						<ul id="mainSetlist">
						</ul>
					</div>
					<div id="encore_and_form">
						<a id="encore_button" class="button_link">Encore</a>
						<a id="clear_setlist" class="button_link">Clear</a>
						<input class="button_link" type="submit" value="Enter" id="setlist_submit">
					</div>	
				</td>
				<td>
					<div id="songInfoDiv">
						
					</div>
				</td>
			</tr>
		</table>
		<script src="jquery.sortable.js"></script>
		<script>
			$('#mainSetlist').sortable();	
		</script>
		</form>
	</body>
</html>