<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
// Incluir aquivo de conex�o
include("../conn.php");
 
// Recebe a id enviada no m�todo GET
$id = $_GET['id'];
 
// Seleciona a noticia que tem essa ID
$sql = mysql_query("SELECT * FROM adm_cliente WHERE id_cli = '".$id."'");
 
// Pega os dados e armazena em uma vari�vel
$noticia = mysql_fetch_object($sql);
 
// Exibe o conte�do da notica
echo "CONSULTA DADOS CADASTRAIS <br /><br />";
echo "Nome:&nbsp".$noticia->nome_cli."<br />";
echo "Telefone:&nbsp".$noticia->fone_cli."<br />";
echo "Email:&nbsp".$noticia->email_cli."<br />";
echo "Contato:&nbsp".$noticia->contato_cli."<br />"; 

?>
</body>
</html>