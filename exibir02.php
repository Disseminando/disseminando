<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
// Incluir aquivo de conex�o
include("conn.php");
 
// Recebe a id enviada no m�todo GET
$id = $_GET['msg_id'];
 
// Seleciona a noticia que tem essa ID
$sql = mysql_query("SELECT * FROM mensagem WHERE msg_id = '".$id."'");
 
// Pega os dados e armazena em uma vari�vel
$mensagem = mysql_fetch_object($sql);
 
// Exibe o conte�do da notica
echo "CONSULTA MENSAGEM <br /><br />";
echo "Titulo:&nbsp".$mensagem->msg_titulo."<br />";
echo "Mensagem:&nbsp".$mensagem->msg_texto."<br />";
?>
</body>
</html>