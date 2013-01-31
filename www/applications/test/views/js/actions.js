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

});
