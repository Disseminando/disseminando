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
$noticia = mysql_fetch_object($sql);
 
// Exibe o conte�do da notica
echo "CONSULTA DADOS CADASTRAIS <br /><br />";
echo "Titulo:&nbsp".$noticia->msg_titulo."<br />";
?>
</body>
</html>