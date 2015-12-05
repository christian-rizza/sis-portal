<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

?>

<p>
	Puoi utilizzare il modulo sottostante per poter contattare direttamente la segreteria studenti
</p>
<hr />
<form action="index.php" method="post" id="form_mail">
    <p>
	<label>Nome:</label>
    <input type="text" value="<?php echo $result["edit"]->name; ?>" disabled="disabled" />
    <input type="hidden" name="nome_studente" value="<?php echo $result["edit"]->name; ?>" />
    </p>
    <p>
	<label>Cognome:</label>
    <input type="text" value="<?php echo $result["edit"]->surname; ?>" disabled="disabled"/>
    <input type="hidden" name="cognome_studente" value="<?php echo $result["edit"]->surname; ?>" />
    </p>
    <p>
	<label for="campo_email">E-mail:</label>
    <input type="text" value="<?php echo $result["edit"]->email; ?>" disabled="disabled"/>
	<input type="hidden" style="text-transform:none" name="campo_email" id="campo_email" value="<?php echo $result["edit"]->email; ?>"/>
    </p>
    <p>
    <p>
	<label for="campo_oggetto">Oggetto:</label>
	<input type="text" name="campo_oggetto" id="campo_oggetto" value=""/>
    </p>
    <p>
	<label for="campo_messaggio">Messaggio:</label>
	<textarea cols="30" rows="8" name="campo_messaggio" id="campo_messaggio"></textarea>
    </p>
    <p>
    <label></label><button type="submit">Invia Messaggio</button>
    </p>
    <input type="hidden" name="operation" value="sendMail" />
</form>