<?php

define('BD_USER', 'disseminando');
define('BD_PASS', 'a2b4m9');
define('BD_NAME', 'disseminando');

mysql_connect('mysql.disseminando.com', BD_USER, BD_PASS);
mysql_select_db(BD_NAME);

$usuario_id = $_REQUEST['id'];
$senha = $_REQUEST['code'];

$sql = mysql_query(

"UPDATE curriculo_usuario SET ativado='1'
WHERE cur_usu_id='{$usuario_id}'
AND cur_usu_senha='{$senha}'"

);

$sql_doublecheck = mysql_query(

"SELECT * FROM curriculo_usuario
WHERE cur_usu_id='{$usuario_id}'
AND cur_usu_senha='{$senha}'
AND ativado='1'"

);

$doublecheck = mysql_num_rows($sql_doublecheck);

if ($doublecheck == 0){

echo "<strong>Sua conta nao pode ser ativada!</strong>";

}elseif ($doublecheck > 0){

echo "<strong>Seu cadastro foi ativado com sucesso!</strong><br />
Voce pode fazer o login logo abaixo!<br /><br />";

include "index.php";

}

?>