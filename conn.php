<?php
$host = "mysql.disseminando.com"; 
$usuario = "disseminando";
$senha = "a2b4m9";
$banco = "disseminando";
 
$conn = mysql_connect($host, $usuario, $senha);
$db = mysql_select_db($banco, $conn);
?>