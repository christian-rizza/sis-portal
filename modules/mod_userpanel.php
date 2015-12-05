<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

if (isset($_SESSION['login']) || isset($_SESSION['admin']))
{
	
?>
    <div class="user_panel">
        <p>
            <b>Benvenuto</b><br />
            <?php echo strtoupper($_SESSION['login']); ?>
            <?php echo strtoupper($_SESSION['admin']); ?>
            
        <br />
        </p>
        <ul>
			<li><span><a href="index.php">Home</a></span></li>
            <li><span><a href="<?php echo BASE_PATH?>?action=logout">Esci</a></span></li>
        </ul>
    </div>

<?php
}
?>