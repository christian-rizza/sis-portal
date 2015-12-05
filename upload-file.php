<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

session_start();
if (!isset($_SESSION['login']))
{
	header("Location: index.php");
}

$student_id = $_SESSION['id_student'];
$uploaddir = './upload/';

$file = $uploaddir . basename($_FILES['uploadfile']['name']);
$path_parts = pathinfo($_FILES["uploadfile"]["name"]);
$ext = $path_parts['extension']; 

$file2 = $uploaddir . basename("matr_".$student_id.".".$ext);
  
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file2)) 
{ 
  	echo "success#".$file2; 
} 
else 
{
	echo "error";
}
?>