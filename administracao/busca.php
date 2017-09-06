<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
// Incluir aquivo de conexão
include("../conn.php");

// Recebe o valor enviado
$valor = $_GET['valor'];
 
// Procura titulos no banco relacionados ao valor
$sql = mysql_query("SELECT * FROM adm_cliente WHERE nome_cli LIKE '%".$valor."%'");
 
// Exibe todos os valores encontrados
while ($noticias = mysql_fetch_object($sql)) {
	echo "<a href=\"javascript:func()\" onclick=\"exibirConteudo('".$noticias->id_cli."')\">" . $noticias->nome_cli."</a><br />";
}
 
?>
</body>
</html>