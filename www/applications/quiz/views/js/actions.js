$(document).ready(function(){
	
	$("#addObjectivo").click(function(){
		$(".molde1").clone().appendTo($("#goals-table")).removeClass("molde1").find(".id-goal").val($(".id-goal").length);
		$(".molde").clone().appendTo($("#goals-explain")).removeClass("molde").find(".goal").val($(".id-goal").length);	
		
		$('table#goals-table tbody tr td input[name]:last').val("");
		$('#goals-explain tbody tr:last td input').val("");
		$('#goals-explain tbody tr:last td input.goal').val($(".id-goal").length);
		return false;
	
	});
	
	$("#removeObjectivo").click(function(){
		if($(".id-goal").length > 1) {
			$("#goals-table tr:last").remove();
			$("#goals-explain tr:last").remove();	
		}
		return false;
	});
	
	$('#goals-explain tbody tr.molde td input').bind('blur keyup keydown', function() {
		var digit = parseInt($(this).val());
		
		if(isNaN(digit) || digit > 4) {
			$(this).val("");
		}
		
	});
	
	$('#goals-explain tbody tr.molde td input').keypress(function(e) {
		if(e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
    });
    
    $('#goals-table tbody tr.molde1 td input').keypress(function(e) {
		if(e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
    });

});
