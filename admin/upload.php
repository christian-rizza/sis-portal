<?php

    // RECUPERO I PARAMETRI DA PASSARE ALLA FUNZIONE PREDEFINITA PER L'UPLOAD
	
	print_r($_FILES);
	
    $percorso = $_FILES['file'];
	
    // ESEGUO L'UPLOAD CONTROLLANDO L'ESITO
    if (move_uploaded_file($percorso['tmp_name'], $percorso['name']))
    {
        echo "Upload eseguito con successo"; 
    }
    else
    {
        echo "Si sono verificati dei problemi durante l'Upload"; 
    }

?>