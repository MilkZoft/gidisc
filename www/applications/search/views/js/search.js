var delay 	     = 500;
var search_timer = null;

$(".noresults").hide();
$(".loadgif").hide();

$("#inputsearch").click( function() {
	if($.trim($("input[name='search']").val()) != "") {
		var post = { "search" : $("input[name='search']").val()};

		$("#videos").html('');
		search(post, "/search/ajax/search");
	}
});

$("input[name='search']").keypress(function(event) {
	if(event.which == 13) {
		$("#inputsearch").click();
		return false;
	} else {
		clearTimeout(search_timer);
		search_timer = setTimeout(click, delay);
	}
});

function click() {
	$("#inputsearch").click();
}

function search(post, url) {
	$.ajax({
		type: "POST",
		url: PATH + url,
		data: post,
		dataType: "json",
		beforeSend: function(jqXHR, settings){
			$(".loadgif").show();
		},

		success: function(response, textStatus, jqXHR) {
			var data = response["response"];
			
			$(".wrapper").html('');
			
			if(data != false) {
				if(data["centers"] != false) {
					$(".wrapper").append(getTableCenters());
					
					for(var i in data["centers"]) {
						$(".wrapper .centers .table").append(getObjectCenter(data["centers"][i]));
					}
				} else {
					$(".wrapper .centers .table").html('<div class="center">No results :(</div>');
				}
				
				if(data["users"] != false) {
					$(".wrapper").append(getTableUsers());
					
					for(var i in data["users"]) {
						$(".wrapper .userspeople .table tbody").append(getObjectUser(data["users"][i]));
					}
				} else {
					$(".wrapper .userspeople .table").html('<div class="center">No results :(</div>');
				}
				
				if(data["pages"] != false) {
					$(".wrapper").append(getTablePages());
					
					for(var i in data["pages"]) {
						$(".wrapper .pages .table").append(getObjectPage(data["pages"][i]));
					}
				} else {
					$(".wrapper .pages .table").html('<div class="center">No results :(</div>');
				}
			} else {
				$(".wrapper").html('<div class="center">No results :(</div>');	
			}
		},

		error: function(jqXHR, textStatus){

		},

		complete: function(jqXHR, textStatus){
			$(".loadgif").hide();
		}
	});
}

/*Centers*/
function getTableCenters() {
	var table = '<div class="centers"><h2>Centros</h2>';
		table = table + '<table class="bordered-table zebra-striped table">';
			table = table + '<thead><tr>';
			table = table + '<th>#</th><th>Nombre</th><th>Direccci&oacute;n</th><th>Tel&eacute;fono</th><th>Actions</th>';
			table = table + '</tr></thead>';
			table = table + '<tbody></tbody>';
		table = table + '</table>';
	table = table + '</div>';
	
	return table;
}


function getObjectCenter(data) {
	var object  = '<tr>';
	
		object = object + '<td>' + data["ID_Center"] + '</td>';
		object = object + '<td>' + data["Name"]      + '</td>';
		object = object + '<td>' + data["Address"]   + '</td>';
		object = object + '<td>' + data["Phone"]     + '</td>';
		object = object + '<td>';
			object = object + '<a href="' + PATH + '/centers/cpanel/edit/' + data["ID_Center"] + '/" title="Edit" onclick="return confirm(\'Do you want to edit the record?\')">';
			object = object + '<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		
			object = object + '<a href="' + PATH + '/centers/cpanel/trash/' + data["ID_Center"] + '/" title="Send to trash" onclick="return confirm(\'Do you want to send to the trash the record?\')">';
			object = object + '<span class="tiny-image tiny-trash no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		object = object + '</td>';
	
	object = object + '</tr>';
	
	return object;
}


/*Users*/
function getTableUsers() {
	var table = '<div class="userspeople"><h2>Usuarios</h2>';
		table = table + '<table class="bordered-table zebra-striped table">';
			table = table + '<thead><tr>';
			table = table + '<th>#</th><th>Nombre</th><th>Apellidos</th><th>Email</th><th>Actions</th>';
			table = table + '</tr></thead>';
			table = table + '<tbody></tbody>';
		table = table + '</table>';
	table = table + '</div>';
	
	return table;
}

function getObjectUser(data) {
	console.log(data);
	var object  = '<tr>';
	
		object = object + '<td>' + data["ID_User"] + '</td>';
		object = object + '<td>' + data["Name"]    + '</td>';
		object = object + '<td>' + data["Last_Name"] + " " + data["Maiden_Name"] + '</td>';
		object = object + '<td>' + data["Email"]   + '</td>';
		object = object + '<td>';
			object = object + '<a href="' + PATH + '/users/cpanel/edit/' + data["ID_User"] + '/" title="Edit" onclick="return confirm(\'Do you want to edit the record?\')">';
			object = object + '<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		
			object = object + '<a href="' + PATH + '/users/cpanel/trash/' + data["ID_User"] + '/" title="Send to trash" onclick="return confirm(\'Do you want to send to the trash the record?\')">';
			object = object + '<span class="tiny-image tiny-trash no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		object = object + '</td>';
	
	object = object + '</tr>';
	
	return object;
}

/*Pages*/
function getTablePages() {
	var table = '<div class="pages"><h2>P&aacute;ginas</h2>';
		table = table + '<table class="bordered-table zebra-striped table">';
			table = table + '<thead><tr>';
			table = table + '<th>#</th><th>T&iacute;tulo</th><th>Lenguaje</th><th>Situation</th><th>Actions</th>';
			table = table + '</tr></thead>';
			table = table + '<tbody></tbody>';
		table = table + '</table>';
	table = table + '</div>';
	
	return table;
}

function getObjectPage(data) {
	var object  = '<tr>';
	
		object = object + '<td>' + data["ID_Page"]   + '</td>';
		object = object + '<td>' + data["Title"]     + '</td>';
		object = object + '<td>' + data["Language"]  + '</td>';
		object = object + '<td>' + data["Situation"] + '</td>';
		object = object + '<td>';
			object = object + '<a href="' + PATH + '/pages/cpanel/edit/' + data["ID_Page"] + '/" title="Edit" onclick="return confirm(\'Do you want to edit the record?\')">';
			object = object + '<span class="tiny-image tiny-edit no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		
			object = object + '<a href="' + PATH + '/pages/cpanel/trash/' + data["ID_Page"] + '/" title="Send to trash" onclick="return confirm(\'Do you want to send to the trash the record?\')">';
			object = object + '<span class="tiny-image tiny-trash no-decoration">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			object = object + '</a>';
		object = object + '</td>';
	
	object = object + '</tr>';
	
	return object;
}
