$(document).ready(function() {
	var selectedAlbumId = "";
	var selectedNewSongs = false;
	
	$("#totalSongs").click(function() {
		if(selectedNewSongs) {
			turnOffSelectedNewSongs();
		}
		if(selectedAlbumId != "") {
			turnOffSelectedAlbum();
		}
	});
	
	$("#newsongs").click(function() {
		if(selectedNewSongs) {
			turnOffSelectedNewSongs();
		}
		else {
			$("li").not(".newSong").addClass("opacityDimmed");
			selectedNewSongs = true;
		}
	});
	
	$(".album").click(function() {
		if(selectedAlbumId != "") {
			turnOffSelectedAlbum();
		}
		selectedAlbumId = parseId($(this).attr("id"));
		$("li.a-"+selectedAlbumId).addClass("selected");
	});
	
	function turnOffSelectedNewSongs() {
		$("li").not(".newSong").removeClass("opacityDimmed");
		selectedNewSongs = false;
	}
	
	function turnOffSelectedAlbum() {
		$("li.a-"+selectedAlbumId).each(function(){
			if($(this).hasClass("encore")) {
				$(this).removeClass("selected");
			}
			else{
				$(this).removeClass("selected");
			}
		});
		selectedAlbumId = "";
	}
});