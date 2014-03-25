

/*******
 INFO BOX
********/
var infoBox = function(className,type,artist) {
	var info = $(".infoBox." + className).find(".infoBoxImage");
	info.css("background-image","url(/imgs/"+type+"/"+artist+".jpg)");
};