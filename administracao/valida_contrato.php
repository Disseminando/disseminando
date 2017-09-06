<?php require_once('../Connections/con01.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando | Sua fé sem fronteiras.</title>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/icons.css"/>
<link rel="stylesheet" type="text/css" href="../css/skinblue.css"/>
<link rel="stylesheet" type="text/css" href="../css/responsive.css"/>
<script src="../js/jquery-1.9.0.min.js"></script>
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
<div class="row space-bot">
<!--Logo-->
<div class="c4"> <a href="#"> <img src="../images/logo02.jpg" class="logo" alt=""> </a> </div>
<!--Menu-->
<div class="c8">
<nav id="topNav">
<ul id="responsivemenu">
<li class="active"><a href="painelControle.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
<li><a href="#">Menu</a>
  <ul style="display: none;">
    <li><a href="adm_cad_contrato.php">Cadastro</a></li>
    <li><a href="adm_cs_contrato.php">Consulta</a></li>
    <li class="last"><a href="<?php echo $logoutAction ?>">Fechar</a></li>
  </ul>
</nav>
</div>
</div>
</div>
<!-- HEADER
================================================== -->
<div class="undermenuarea">
  <div class="boxedshadow"> </div>
  <div class="grid">
    <div class="row">
      <div class="c8">
        <h1 class="titlehead">Administrativo</h1>
      </div>
      <div class="c4">
        <h1 class="titlehead rightareaheader"><i class="icon-map-marker">&nbsp Usuario:&nbsp<?php echo $_SESSION['MM_Username'];?></i></h1>
      </div>
    </div>
  </div>
</div>
<!-- CONTENT
================================================== -->
<div class="grid">
  <div class="shadowundertop"> </div>
  <div class="row"> 
    <!-- SIDEBAR -->
    <div class="c3">
      <div class="leftsidebar">
        <h2 class="title stresstitle">Parceiro</h2>
        <br />
        <br />
        <br />
        <br />
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=161"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9"><br />
      <h1 class="maintitle space-top"> <span>CADASTRO DE CLIENTE</span></h1>
      <hr class="hrtitle">
       <?php

			$cnpj = trim($_POST['cnpj_cli']);
			$nome = trim($_POST['nome_cli']);
			$endereco = trim($_POST['end_cli']);
			$bairro = trim($_POST['bairro_cli']);
			$estado =($_POST['estado_cli']);
			$cidade =($_POST['cidade_cli']);
			$cep = trim($_POST['cep_cli']);
			$telefone = trim($_POST['fone_cli']);
			$email = trim($_POST['email_cli']);
			$contato = trim($_POST['contato_cli']);
			$situacao = trim($_POST['situacao_cli']);
			$obs = ($_POST['obs_cli']);
			$usuario = ($_POST['usuario_cli']);
			
			/* Vamos checar algum erro nos campos */
			
			if ((!$cnpj) ||(!$nome) || (!$endereco) || (!$bairro) || (!$estado) || (!$cidade) || (!$cep) || (!$telefone )|| (!$email) || (!$contato) || (!$situacao)){
			
			echo "<strong>MENSAGEM DE ERRO:</strong><br /><br />";
			if (!$cnpj){
			
			echo "CNPJ é requerido.<br /><br />";
			
			}
			
			if (!$nome){
			
			echo "Nome é requerido.<br /><br />";
			
			}
			
			if (!$endereco){
			
			echo "Endereço é requerido.<br /> <br />";
			
			}
			
			if (!$bairro){
			
			echo "Bairro é um campo requerido.<br /><br />";
			
			}			
			
			if (!$cep){
			
			echo "CEP é requerido.<br /><br />";
			
			}
			if (!$telefone){
			
			echo "Telefone é requerido.<br /><br />";
			
			}
			if (!$email){
			
			echo "Email é requerido.<br /><br />";
			
			}
			if (!$contato){
			
			echo "Contato é requerido.<br /><br />";
			
			}
			if (!$situacao){
			
			echo "Situacao é requerido.<br /><br />";
			
			}		
			
						
			
			}else{
			
			/* Vamos checar se o nome de Usuário escolhido e/ou Email já existem no banco de dados */
			
			define('BD_USER', 'disseminando');
			define('BD_PASS', 'a2b4m9');
			define('BD_NAME', 'disseminando');
			
			mysql_connect('mysql.disseminando.com', BD_USER, BD_PASS);
			mysql_select_db(BD_NAME);
			
			$sql_email_check = mysql_query(
			
			"SELECT COUNT(id_cli) FROM adm_cliente WHERE email_cli='{$email}'"
			
			);
			
			$sql_usuario_check = mysql_query(
			
			"SELECT COUNT(id_cli) FROM adm_cliente WHERE fone_cli='{$telefone}'"
			
			);
			
			$eReg = mysql_fetch_array($sql_email_check);
			$uReg = mysql_fetch_array($sql_usuario_check);
			
			$email_check = $eReg[0];
			$usuario_check = $uReg[0];
			
			if (($email_check > 0) || ($usuario_check > 0)){
			
			echo "<strong>ERRO</strong>: <br /><br />";
			
			if ($email_check > 0){
			
			echo "Este Email ja esta sendo utilizado.<br /><br />";
			
			unset($email);
			
			}
			
			if ($usuario_check > 0){
			
			echo "Este Telefone ja esta sendo utilizado.<br /><br />";
			
			unset($usuario);
			
			}
			
			
			}else{
			
			/* Se passarmos por esta verificação ilesos é hora de finalmente cadastrar os dados. 
			   Vamos utilizar uma função para gerar a senha de forma randômica*/			
						
			// Inserindo os dados no banco de dados			
			
			$sql = mysql_query(
			"INSERT INTO adm_cliente
			(data_cli, cnpj_cli, nome_cli, end_cli, bairro_cli, estado_cli, cidade_cli, cep_cli, fone_cli, email_cli, contato_cli, situacao_cli, obs_cli, usuario_cli)
			
			VALUES
			(now(),'$cnpj','$nome','$endereco','$bairro','$estado','$cidade','$cep','$telefone','$email','$contato','$situacao','$obs','$usuario')")
			
			or die( mysql_error());
			
			if (!$sql){ 
			
			echo "Ocorreu um erro ao criar sua conta, entre em contato.";
			
			}else{			
			
			$usuario_id = mysql_insert_id();
			
			echo "Cadastro realizado com sucesso.";

			}
			
			}
			
			}
			
			?>    
    </div>
  </div>
</div>
<!-- FOOTER
================================================== -->
<div id="wrapfooter">
	<div class="grid">
		<div class="row" id="footer">
			<!-- to top button  -->
			<p class="back-top floatright">
				<a href="#top"><span></span></a>
			</p>
			<!-- 1st column -->
			<div class="c3">
				<img src="../images/03.png" style="padding-top: 70px;" alt="">
			</div>
			<!-- 2nd column -->
			<div class="c3">
				<h2 class="title"></i> Saiba mais...</h2>
                <br>				
				<div>
				<p align="justify">Criado em agosto de 2013, o disseminando é um Ministério de Evangelismo que não possui vinculo denominacional, foi idealizado como um espaço para disseminar o Evangelho de Jesus Cristo sem trazer marcas doutrinarias, temos como único objetivo o crescimento e fortalecimento do povo escolhido do Senhor, através do pleno conhecimento das suas palavras. Além de lutar com todas as nossas forças contra o trabalho indiscriminado dos falsos mestres dentro das igrejas.</p>
				</div>
			</div>
			<!-- 3rd column -->
			<div class="c3">
				<h2 class="title"></i> Destaque</h2>
				<br>
                <dl>				
                  <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=202"></script>
				</dl>				
			</div>
			<!-- end 4th column -->
			<div class="c3">
				<h2 class="title"></i> Parceiro</h2>
				<br>
                <dl>				
                  <a href="http://imecdnoticias.com/" target="_blank"><img src="../images/04.jpg" alt="Imecdnoticias" title="Imecdnoticias"></img></a>
				</dl>				
			</div>
		</div>
	</div>
</div>
<div class="copyright">
	<div class="grid">
		<div class="row">
			<div class="c6">
				 Disseminando &copy; 2013. All Rights Reserved.
			</div>
			<div class="c6">
			</div>
		</div>
	</div>
</div>
</div>
<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="../js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="../js/common.js"></script>

<!-- cycle -->
<script src="../js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="../js/jquery.tweet.js"></script>

</body>
</html>