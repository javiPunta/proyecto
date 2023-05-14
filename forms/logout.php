<?php
include "../funciones/funcione.php"; 
session_start(); 

session_destroy();

header("Location: ../index1.html");
?>