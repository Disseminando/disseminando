<?php

$nome = trim($_POST['cur_usu_nome']);
$usuario = trim($_POST['cur_usu_login']);
$senha = trim($_POST['cur_usu_senha']);
$email = trim($_POST['cur_usu_email']);

/* Vamos checar algum erro nos campos */

if ((!$nome) || (!$usuario) || (!$senha) || (!$email)){

echo "ERRO: <br /><br />";

if (!$nome){

echo "Nome é requerido.<br />";

}

if (!$usuario){

echo "Sobrenome é requerido.<br /> <br />";

}

if (!$senha){

echo "Email é um campo requerido.<br /><br />";

}

if (!$email){

echo "Nome de Usuário é requerido.<br /><br />";

}

echo "Preencha os campos abaixo: <br /><br />";

include "index.php";

}else{

/* Vamos checar se o nome de Usuário escolhido e/ou Email já existem no banco de dados */

define('BD_USER', 'disseminando');
define('BD_PASS', 'a2b4m9');
define('BD_NAME', 'disseminando');

mysql_connect('mysql.disseminando.com', BD_USER, BD_PASS);
mysql_select_db(BD_NAME);

$sql_email_check = mysql_query(

"SELECT COUNT(cur_usu_id) FROM curriculo_usuario WHERE cur_usu_email='{$email}'"

);

$sql_usuario_check = mysql_query(

"SELECT COUNT(cur_usu_id) FROM curriculo_usuario WHERE cur_usu_login='{$usuario}'"

);

$eReg = mysql_fetch_array($sql_email_check);
$uReg = mysql_fetch_array($sql_usuario_check);

$email_check = $eReg[0];
$usuario_check = $uReg[0];

if (($email_check > 0) || ($usuario_check > 0)){

echo "<strong>ERRO</strong>: <br /><br />";

if ($email_check > 0){

echo "Este email ja esta sendo utilizado.<br /><br />";

unset($email);

}

if ($usuario_check > 0){

echo "Este nome de usuario ja esta sendo utilizado.<br /><br />";

unset($usuario);

}

include "curriculo_cadastro.php";

}else{

/* Se passarmos por esta verificação ilesos é hora de finalmente cadastrar os dados. 
   Vamos utilizar uma função para gerar a senha de forma randômica*/

function makeRandomPassword(){

$salt = "abchefghjkmnpqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;

while ($i <= 7){

$num = rand() % 33;
$tmp = substr($salt, $num, 1);
$pass = $pass . $tmp;
$i++;

}

return $pass;

}

$senha_randomica = makeRandomPassword();
$senha = ($senha_randomica);

// Inserindo os dados no banco de dados

$info = htmlspecialchars($info);

$sql = mysql_query(

"INSERT INTO curriculo_usuario
(cur_usu_nome, cur_usu_login, cur_usu_senha, cur_usu_email, cur_usu_data)

VALUES
('$nome', '$usuario', '$senha', '$email', now())")

or die( mysql_error()

);

if (!$sql){

echo "Ocorreu um erro ao criar sua conta, entre em contato.";

}else{

$usuario_id = mysql_insert_id();

// Enviar um email ao usuário para confirmação e ativar o cadastro!

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Disseminando - Webmaster<disseminando@disseminando.com>";

$subject = "Confirmação de cadastro - disseminando.com";
$mensagem = "Prezado {$nome} {$sobrenome},<br />
Obrigado pelo seu cadastro em nosso site, <a href='http://www.disseminando.com'>
http://www.disseminando.com</a>!<br /> <br />

Para confirmar seu cadastro e ativar sua conta em nosso site, podendo acessar à
áreas exclusivas, por favor clique no link abaixo ou copie e cole na barra de
endereço do seu navegador.<br /> <br />

<a href='http://www.disseminando.com/ativar.php?id={$usuario_id}&code={$senha}'>

http://www.disseminando.com/ativar.php?id={$usuario_id}&code={$senha}

</a>

<br /> <br />
Apos a ativacao de sua conta, voce podera ter acesso ao conteudo exclusivo
efetuado o login com os seguintes dados abaixo:<br > <br />

<strong>Usuario</strong>: {$usuario}<br />
<strong>Senha</strong>: {$senha_randomica}<br /> <br />

Obrigado!<br /> <br />

Webmaster<br /> <br /> <br />
Esta e uma mensagem automatica, por favor nao responda!";

mail($email, $subject, $mensagem, $headers);

echo "Foi enviado para seu email - ( ".$email." ) um pedido de
confirmacao de cadastro, por favor verifique e sigas as instrucoes!";

include "index.php";
}

}

}

?>