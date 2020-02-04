// call when loading this file
$(function(){
	$('input[type=button]').on('click', function (e) {
		$("div").each(function(){
			$(location).attr("href","index.php");
		});
	});

});
