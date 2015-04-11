// JavaScript Document

//Add Bootstrap class names to Google API tables
google.load('visualization', '1', {packages:['table']});
google.setOnLoadCallback(drawTable);
function drawTable() {
	var query = new google.visualization.Query('https://spreadsheets.google.com/tq?key=1Drn1soYe5HLCa-7J_oWoeNYg-OdX7i8q2LD6OZhpDNQ&gid=46038258');
	query.send(handleQueryResponse);
}

function handleQueryResponse(response) {
	if (response.isError()) {
		alert('Error in query: ' + response.getMessage() + '' + response.getDetailedMessage());
		return;
	}
	
	var data = response.getDataTable();
	var today = new Date();
	var cssClassNames = {
		'headerRow': 'rowHeader',
		'tableRow': 'tableRow',
		'hoverTableRow': 'rowHover'
	};
	
	var formatter = new google.visualization.PatternFormat('<a href="{19}" target="_blank">Update Brew</a>');
	formatter.format(data, [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],20);
	
	var options = {'showRowNumber': false, 'allowHtml': true, 'alternatingRowStyle': false, 'cssClassNames': cssClassNames};	  
		
	//Drink Table information
	var drink = new google.visualization.DataView(data);
		drink.setColumns([0,1,2,17,18]),drink.setRows(drink.getFilteredRows([{column:3, minValue:'0'}]));
		var table = new google.visualization.Table(document.getElementById('drink_table'));
		
		google.visualization.events.addListener(table, "ready", function() {
			$(".google-visualization-table-table").addClass("table");
		});
					
		table.draw(drink, options);
	
	//Secondary Table information
	var sec = new google.visualization.DataView(data);
	sec.setColumns([0,7,8,20]),sec.setRows(sec.getFilteredRows([{column:1, minValue:'' },{column:2, value:null}])), sec.hideColumns([8]);
	var secCount = sec.getNumberOfRows();
	if (secCount > 0) {
		var table = new google.visualization.Table(document.getElementById('sec_table'));
		table.draw(sec, options);
		$(".sec_section").prepend("<h3>Ready to Secondary</h3>");
	}
	
	//Dry Hop Table information
	var hop = new google.visualization.DataView(data);
	hop.setColumns([0,10,11,20]),hop.setRows(hop.getFilteredRows([{column:1, minValue:'' },{column:2, value:null}])), hop.hideColumns([11]);
	var hopCount = hop.getNumberOfRows();
	if (hopCount > 0) {
		var table = new google.visualization.Table(document.getElementById('hop_table'));
		table.draw(hop, options);
		$(".hop_section").prepend("<h3>Ready for Dry Hop</h3>");
	}
	
	//Bottling Table information
	var bottle = new google.visualization.DataView(data);
	bottle.setColumns([0,13,14,20]),bottle.setRows(bottle.getFilteredRows([{column:1, minValue:'' },{column:2, value:null}])), bottle.hideColumns([14]);
	var bottleCount = bottle.getNumberOfRows();
	if (bottleCount > 0) {
		var table = new google.visualization.Table(document.getElementById('bottle_table'));
		table.draw(bottle, options);
		$(".bottle_section").prepend("<h3>Ready for Bottling</h3>");
	}
}