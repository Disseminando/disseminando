<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
// Incluir aquivo de conexão
include("conn.php");

// Recebe o valor enviado
$valor = $_GET['valor'];
 
// Procura titulos no banco relacionados ao valor
$sql = mysql_query("SELECT * FROM mensagem WHERE msg_titulo LIKE '%".$valor."%'");
 
// Exibe todos os valores encontrados
while ($mensagem = mysql_fetch_object($sql)) {
	echo "<a href=\"javascript:func()\" onclick=\"exibir('".$mensagem->msg_id."')\">" . $mensagem->msg_titulo."</a><br />";
}
 
?>
</body>
</html>