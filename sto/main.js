$(document).ready(function() {
	var submitting = false;
	document.querySelector('#fileButton').addEventListener('click', function(e) {
	  document.querySelector('#fileInput').click();
	}, false);
	var scrollHeight;
	$(window).scroll(function() {
		$(".file").each(function() {
			var offset = $(this).offset().top - 20;
			var scroll = $(window).scrollTop();
			var opacityValue = offset - scroll;
			if (opacityValue < 140) {
				opacityValue = opacityValue / 140;
				if (opacityValue < 0) {
					opacityValue = 0;
				}
			} else {
				opacityValue = 1;
			}
			$(this).css("opacity", opacityValue);
		});
	});
	$("#fileInput").change(function() {
		$("form#upload").submit();
		$("#loading").css("display", "inline");
		$("button#fileButton").css("display", "none");
		$("h3").text("Uploading...");
	})
	$("#upload-button").click(function() {
		$("form#upload").fadeIn();
		$("#shadow").fadeIn();
	});
	$("#shadow").click(function() {
		$("form#upload").fadeOut();
		$("#shadow").fadeOut();		
	});
	$(".file").click(function() {
		if ($(this).hasClass("clicked")) {
			if (!$(this).hasClass("downloaded")) {
				$("input#fileDownload").val($(this).attr("ref"));
				$("input#timeDownload").val($(this).attr("data"));
				$("form#download").submit();
				$(this).addClass("downloaded").removeClass("clicked");
			}
		} else {
			$(".file").each(function() {
				$(this).removeClass("clicked");
			});
			$(this).addClass("clicked");	
		}
	});
});