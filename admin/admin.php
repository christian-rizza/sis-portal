<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */


if (!isset($_SESSION['admin']))
{
	header("Location: ../index.php");
}
?>

<script type="text/javascript">


function searchStudent()
{
	$("#searchLabel").html("Cerca Studente:");
	$("#searchDialog").dialog( "open" );
	$("#searchInput").autocomplete({ source: "search.php?module=student"});
}

</script>

<div id="tabs" style="width: 700px">
	<ul>
		<li><a href="#tabs-1">Menu</a></li>
	</ul>
	<div id="tabs-1">
    	<div class="column">
	    	<div class="column_content" style="min-height: 150px;">
				<h3>Corsi</h3>
                <ul>
					<li><a href="?module=course">Gestione corsi</a></li>
					<li><a href="?module=subject">Gestione Materie</a></li>
					<li><a href="?module=plan">Piani di studio</a></li>
				</ul>
			</div>
            <div class="column_content">
            	<h3>Prenotazioni ed Esami</h3>
                <ul>
					
                    <li><a href="?module=booking">Gestione Appelli Esami</a></li>
                    <li><a href="?module=booked">Visualizza Prenotazioni</a></li>
				</ul>
			</div>
		</div>
        <div class="column">
        	<div class="column_content" style="min-height:150px;">
            	<h3>Studenti</h3>
                <ul>
	            	<li><a href="?module=student">Gestione studenti</a></li>
                    <li><a href="#" onClick="searchStudent();">Cerca studente</a></li>
                    <li><a href="?module=exam">Registrazione Esami</a></li>
					<li><a href="?module=payment">Gestione Pagamenti</a></li>
				</ul>
			</div>
			<div class="column_content">
    			<h3>Avvisi e Documenti</h3>
                <ul>
                	<li><a href="?module=notice">Gestione Avvisi</a></li>
                    <li><a href="?module=docs">Gestione Documenti</a></li>
                    
				</ul>
			</div>
		</div>
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
