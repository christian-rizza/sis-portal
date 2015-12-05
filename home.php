<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

if (!isset($_SESSION['login']))
{
	header("Location: index.php");
}

?>

<div id="tabs">
	<ul>
		<li><a href="#home">Avvisi</a></li>
        <li><a href="#profilo">Modifica Profilo</a></li>
        <li><a href="#prenotazione">Prenotazione</a></li>
        <li><a href="#consultazione">Consultazione</a></li>
        <li><a href="#pagamenti">Pagamenti</a></li>
        <li><a href="#documenti">Documenti</a></li>
		<li><a href="#contatti">Contatti</a></li>
	</ul>
    <div class="tabs-div" id="home">
		<?php include_once(BASE_PATH."/modules/mod_user_home.php"); ?>
	</div>
    <div class="tabs-div" id="profilo">
		<?php include_once(BASE_PATH."/modules/mod_user_profile.php"); ?>
	</div>
    <div class="tabs-div" id="prenotazione">
		<?php include_once(BASE_PATH."/modules/mod_user_booking.php"); ?>
	</div>
    <div class="tabs-div" id="consultazione">
		<?php include_once(BASE_PATH."/modules/mod_user_consult.php"); ?>
	</div>
    <div class="tabs-div" id="pagamenti">
		<?php include_once(BASE_PATH."/modules/mod_user_payment.php"); ?>
	</div>
    <div class="tabs-div" id="documenti">
    	<?php include_once(BASE_PATH."/modules/mod_user_document.php"); ?>
    </div>
    <div class="tabs-div" id="contatti">
    	<?php include_once(BASE_PATH."/modules/mod_user_contact.php"); ?>
    </div>
    
</div>

<div id="searchDialog" class="column">
        <form id="searchForm" action="index.php?module=student" method="POST">
            <p>
            <label id="searchLabel" for="search">Cerca Studente:</label>
            <input type="text" id="searchInput" name="search" />
            </p>
            <div class="button">
                <button type="submit">Cerca</button>
            </div>
     	</form>
</div>