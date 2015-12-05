<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>

<script type="text/javascript">
$(function() {
	
	$("#message").click(function() {
			$( "#message" ).hide( "blind", 100 );
	});
})

</script>
<?php
if (isset($result['errorMessage'])) 
{
	echo "<div id=\"message\" class=\"ui-state-error ui-corner-all\" style=\"padding: .7em;\" >";
	echo "<strong><span class=\"ui-icon ui-icon-alert\" style=\"float: left; padding: 1px;\"></span>Attenzione:<br /></strong>";
	echo $result["errorMessage"];
	echo "<div style=\"float: right; font-size: xx-small; margin-top: -20px; \">Clicca per chiudere questo messaggio</div>";
	echo "</div>";
}
if (isset($result['statusMessage'])) 
{
	echo "<div id=\"message\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0.7em;\" >";
	echo "<strong><span class=\"ui-icon ui-icon-info\" style=\"float: left; padding: 1px;\"></span>Informazioni:<br /></strong>";
	echo $result["statusMessage"];
	echo "<div style=\"float: right; font-size: xx-small; margin-top: -20px; \">Clicca per chiudere questo messaggio</div>";
	echo "</div>";
}
?>