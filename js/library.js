// JavaScript Document

function deleteFromView(id)
{
	var str ='<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>I dati verranno eliminati definitivamente!<br>Sei sicuro di voler continuare?</p>';
	document.getElementById('dialog').innerHTML = str;
	document.getElementById('operation').value="delete#"+id;
	$( "#dialog" ).dialog({
		title: "Conferma Eliminazione",
		resizable: false,
		height:155,
		modal: true,
		buttons: {
			"Elimina": function() {
				document.getElementById('formModuleView').submit();
			},
			"Annulla": function() {
				document.getElementById('operation').value="";
				$( this ).dialog( "close" );
			}
		}
	});
	$( "#dialog" ).dialog( "open" );
}
function editFromView(id)
{
	document.getElementById('operation').value="edit#"+id;
	document.getElementById('formModuleView').submit();
}

//JQUERY FUNCTION
$(function() {
	$( "button" ).button();
	$( "#tabs" ).tabs();
	$( "#tabs2" ).tabs();
	$( "#dialog" ).dialog(
	{
		resizable: false,
		autoOpen: false,
		height: 250,
		width: 405,
		modal: true
	});
	$( "#searchDialog" ).dialog(
	{
		resizable: false,
		autoOpen: false,
		height: 150,
		width: 450,
		modal: true
	});
});