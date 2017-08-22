<?php

$nome = trim($_POST['cur_nome']);
$nacionalidade = trim($_POST['cur_nacionalidade']);
$estado_civil = trim($_POST['cur_estado_civil']);
$idade = trim($_POST['cur_idade']);
$endereco = trim($_POST['cur_end']);
$bairro = trim($_POST['cur_bairro']);
$cidade = trim($_POST['cur_cidade']);
$estado = trim($_POST['cur_estado']);
$telefone = trim($_POST['cur_fone']);
$email = trim($_POST['cur_email']);
$objetivo = trim($_POST['cur_objetivo']);
$formacao = trim($_POST['cur_formacao']);
$experiencia = trim($_POST['cur_experiencia']);
$qualificacao = trim($_POST['cur_qualificacao']);
$outras = trim($_POST['cur_outras']);
$cadastrador = trim($_POST['cur_cadastrador']);	
/* Vamos checar algum erro nos campos */

if ((!$nome) || (!$nacionalidade) || (!$estado_civil) || (!$idade) || (!$endereco) || (!$bairro) || (!$cidade) || (!$estado) || (!$telefone) || (!$email) || (!$objetivo) || (!$formacao) || (!$experiencia) || (!$qualificacao)){

echo "ERRO: <br /><br />";

if (!$nome){

echo "Nome é requerido.<br />";

}

if (!$nacionalidade){

echo "Nacionalidade é requerida.<br /> <br />";

}

if (!$estado_civil){

echo "Estado Civil é requerido.<br /><br />";

}

if (!$idade){

echo "Idade é requerida.<br /> <br />";

}

if (!$endereco){

echo "Endereco é requerido.<br /> <br />";

}
if (!$bairro){

echo "Bairro é requerido.<br /> <br />";

}
if (!$cidade){

echo "Idade é requerida.<br /> <br />";

}
if (!$estado){

echo "Estado é requerido.<br /> <br />";

}
if (!$telefone){

echo "Telefone é requerido.<br /> <br />";

}
if (!$email){

echo "Email é requerido.<br /> <br />";

}
if (!$objetivo){

echo "Objetivo é requerido.<br /> <br />";

}
if (!$formacao){

echo "Formacao é requerida.<br /> <br />";

}
if (!$experiencia){

echo "Experiencia é requerida.<br /> <br />";

}
if (!$qualificacao){

echo "Qualificacao é requerida.<br /> <br />";

}

echo "Preencha os campos para continuar. <br /><br />";

include "index.php";

}else{

/* Vamos checar se o nome de Usuário escolhido e/ou Email já existem no banco de dados */

define('BD_USER', 'disseminando');
define('BD_PASS', 'a2b4m9');
define('BD_NAME', 'disseminando');

mysql_connect('mysql.disseminando.com', BD_USER, BD_PASS);
mysql_select_db(BD_NAME);

$sql_email_check = mysql_query("SELECT count(cur_id) FROM curriculo WHERE cur_email ='{$email}'");

$sql_usuario_check = mysql_query("SELECT count(cur_id) FROM curriculo WHERE cur_fone ='{$telefone}'");

$eReg = mysql_fetch_array($sql_email_check);
$uReg = mysql_fetch_array($sql_usuario_check);

$email_check = $eReg[0];
$usuario_check = $uReg[0];

if (($email_check > 0) || ($usuario_check > 0)){

echo "<strong>ERRO</strong>: <br /><br />";

if ($email_check > 0){

echo "Este email ja esta cadastrado em nosso Banco de Dados.<br /><br />";

unset($email);

}

if ($usuario_check > 0){

echo "Este Telefone ja esta cadastrado em nosso Banco de Dados.<br /><br />";

unset($telefone);

}

include "index.php";

}else{

// Inserindo os dados no banco de dados

$sql = mysql_query(

"INSERT INTO curriculo
(cur_data, cur_nome, cur_nacionalidade, cur_estado_civil, cur_idade, cur_end, cur_bairro, cur_cidade, cur_estado, cur_fone, cur_email, cur_objetivo, cur_formacao, cur_experiencia, cur_qualificacao, cur_outras, cur_cadastrador)

VALUES
(now(), '$nome', '$nacionalidade', '$estado_civil', '$idade', '$endereco', '$bairro', '$cidade', '$estado', '$telefone', '$email', '$objetivo', '$formacao', '$experiencia', '$qualificacao', '$outras', '$cadastrador')")

or die( mysql_error());

if (!$sql){

echo "Ocorreu um erro ao cadastrar seu curriculo, entre em contato com o Administrador.";

}else{

$usuario_id = mysql_insert_id();

// Enviar um email ao usuário para confirmação e ativar o cadastro!

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Disseminando - Webmaster<disseminando@disseminando.com>";

$email ="antonioborges103@outlook.com";
$subject = "Novo Curriculo cadastrado - disseminando.com";
$mensagem = "Prezado Administrador o usuario: {$nome},<br />
cadastrou seu curriculo!<br /> <br />

Webmaster<br /> <br /> <br />
Esta e uma mensagem automatica, por favor nao responda!";

mail($email, $subject, $mensagem, $headers);

echo "Seu curriculo foi cadastrado com Sucesso !!!";

include "index.php";
}

}

}

?>