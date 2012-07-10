$(document).ready(function(){
	
	$('#thumbs1 ul li a, #thumbs2 ul li a, #thumbs3 ul li a').click(
		function() {
			return false;
		}
	);
	
	
	
	$('#thumbs1 ul li a').hover(
		function() {
			var currentBigImage = $('#bigpic1 img').attr('src');
			var newBigImage = $(this).attr('href');
			var currentThumbSrc = $(this).attr('rel');
			switchImage1(newBigImage, currentBigImage, currentThumbSrc);
		},
		function() {}
	);

	
	function switchImage1(imageHref, currentBigImage, currentThumbSrc) {
		 
		var theBigImage = $('#bigpic1 img');
		
		if (imageHref != currentBigImage) {
		
			theBigImage.fadeOut(250, function(){
				theBigImage.attr('src', imageHref).fadeIn(250);
				var newImageDesc = $("#thumbs1 ul li a img[src='"+currentThumbSrc+"']").attr('alt');
				$('p#desc').empty().html(newImageDesc);
			});
			
			
		}
		
	}
	
	$('#thumbs2 ul li a').hover(
		function() {
			var currentBigImage = $('#bigpic2 img').attr('src');
			var newBigImage = $(this).attr('href');
			var currentThumbSrc = $(this).attr('rel');
			switchImage2(newBigImage, currentBigImage, currentThumbSrc);
		},
		function() {}
	);


	function switchImage2(imageHref, currentBigImage, currentThumbSrc) {
		 
		var theBigImage = $('#bigpic2 img');
		
		if (imageHref != currentBigImage) {
		
			theBigImage.fadeOut(250, function(){
				theBigImage.attr('src', imageHref).fadeIn(250);
				var newImageDesc = $("#thumbs2 ul li a img[src='"+currentThumbSrc+"']").attr('alt');
				$('p#desc').empty().html(newImageDesc);
			});
			
			
		}
		
	}
	
	
	$('#thumbs3 ul li a').hover(
		function() {
			var currentBigImage = $('#bigpic3 img').attr('src');
			var newBigImage = $(this).attr('href');
			var currentThumbSrc = $(this).attr('rel');
			switchImage3(newBigImage, currentBigImage, currentThumbSrc);
		},
		function() {}
	);

	
	function switchImage3(imageHref, currentBigImage, currentThumbSrc) {
		 
		var theBigImage = $('#bigpic3 img');
		
		if (imageHref != currentBigImage) {
		
			theBigImage.fadeOut(250, function(){
				theBigImage.attr('src', imageHref).fadeIn(250);
				var newImageDesc = $("#thumbs3 ul li a img[src='"+currentThumbSrc+"']").attr('alt');
				$('p#desc').empty().html(newImageDesc);
			});
			
			
		}
		
	}
	
});
