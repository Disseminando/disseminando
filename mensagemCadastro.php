<?php require_once('Connections/con01.php'); ?>
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
	
  $logoutGoTo = "index.php";
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

$MM_restrictGoTo = "index.php";
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
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_con01, $con01);
$query_ls_categoria = "SELECT cat_id, cat_nome FROM categoria";
$ls_categoria = mysql_query($query_ls_categoria, $con01) or die(mysql_error());
$row_ls_categoria = mysql_fetch_assoc($ls_categoria);
$totalRows_ls_categoria = mysql_num_rows($ls_categoria);

mysql_select_db($database_con01, $con01);
$query_ls_situacao = "SELECT sit_cad_id, sit_cad_nome FROM situacao_cadastro";
$ls_situacao = mysql_query($query_ls_situacao, $con01) or die(mysql_error());
$row_ls_situacao = mysql_fetch_assoc($ls_situacao);
$totalRows_ls_situacao = mysql_num_rows($ls_situacao);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando | Sua fé sem fronteiras.</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/>
<!-- change skin color -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
<script src="ckeditor/ckeditor.js" type="text/javascript"></script> 
<script src="js/validator.min.js"></script>
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
<div class="row space-bot">
<!--Logo-->
<div class="c4"> <a href="#"> <img src="images/logo02.jpg" class="logo" alt=""> </a> </div>
<!--Menu-->
<div class="c8">
<nav id="topNav">
<ul id="responsivemenu">
<li class="active"><a href="painelControle.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
<li><a href="#">Menu</a>
  <ul style="display: none;">
    <li><a href="#">Anuncio</a></li>
    <li><a href="mensagemCadastro.php">Mensagem</a></li>
    <li><a href="#">Vagas</a></li>
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
        <h1 class="titlehead">Painel de Controle</h1>
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
        <hr class="hrtitle">
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=201"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9">
      <h1 class="maintitle space-top"> <span>Nova Mensagem</span> </h1>
        <form method="post" name="form1" action="msg_valida.php" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="msg_data" class="control-label">Data:</label>
			<input name="msg_data" type="text" class="form-control" id="msg_data" value="<?php  
																						$date = date('d/m/Y');
																						echo $date;
																						?>" size="10" readonly="readonly">
            
		  </div>
		  <div class="form-group">
			<label for="categoria" class="control-label">Categoria:</label>
			<select name="msg_categoria" id="msg_categoria" class="form-control">
			  <option value="0">Selecione...</option>
			  <?php
				do {  
				?>
				<option value="<?php echo $row_ls_categoria['cat_id']?>"><?php echo $row_ls_categoria['cat_nome']?></option>
				<?php
				} while ($row_ls_categoria = mysql_fetch_assoc($ls_categoria));
				  $rows = mysql_num_rows($ls_categoria);
				  if($rows > 0) {
					  mysql_data_seek($ls_categoria, 0);
					  $row_ls_categoria = mysql_fetch_assoc($ls_categoria);
				  }
				?>
            </select>
		  </div>
		  <div class="form-group">
			<label for="titulo" class="control-label">Titulo:</label>
			<input name="msg_titulo" type="text" class="form-control" id="msg_titulo" size="10"  placeholder="Informe o Titulo...">
		  </div>
		<div class="form-group">
		  <label for="mensagem" class="control-label">Mensagem:</label>
		  <textarea class="form-control" rows="5" id="msg_texto" name="msg_texto"></textarea>
		  <script type="text/javascript">
			CKEDITOR.replace('msg_texto');
			</script>				  
		</div> 
		<div class="form-group">
			<label for="situacao" class="control-label">Situação:</label>
			<select name="msg_situacao" id="msg_situacao" class="form-control">
			  <option value="0">Selecione...</option>
			  <?php
				do {  
				?>
				<option value="<?php echo $row_ls_situacao['sit_cad_id']?>"><?php echo $row_ls_situacao['sit_cad_nome']?></option>
				<?php
				} while ($row_ls_situacao = mysql_fetch_assoc($ls_situacao));
				  $rows = mysql_num_rows($ls_situacao);
				  if($rows > 0) {
					  mysql_data_seek($ls_situacao, 0);
					  $row_ls_situacao = mysql_fetch_assoc($ls_situacao);
				  }
				?>
          </select>
		  </div>
		  <div class="form-group">
			<label for="imagem" class="control-label">Imagem:</label>
			<input name="msg_foto" type="file" class="form-control" id="msg_foto">
		  </div>
		  <div class="form-group">
			<label for="usuario">Usuario:</label>
			<input name="msg_cadastrador" type="text" class="form-control" id="msg_cadastrador" size="10" value="<?php $usuario =$_SESSION['MM_Username'];echo "$usuario";?>" readonly="readonly">
		  </div>
		  <button type="submit" class="btn btn-default">Cadastrar</button>
		</form> 
    </div>
  </div>
</div>
<!-- end grid --> 

<!-- FOOTER
================================================== -->
<div id="wrapfooter">
<div class="grid">
<div class="row" id="footer">
<!-- to top button  -->
<p class="back-top floatright"> <a href="#top"><span></span></a> </p>
<!-- 1st column -->
<div class="c3"> <img src="images/03.png" style="padding-top: 70px;" alt=""> </div>
<!-- 2nd column -->
<div class="c3">
  <h2 class="title"><i class="icon-twitter"></i> Saiba mais...</h2>
  <hr class="footerstress">
  <div>
    <p align="justify">Criado em agosto de 2013, o disseminando é um Ministério de Evangelismo que não possui vinculo denominacional, foi idealizado como um espaço para disseminar o Evangelho de Jesus Cristo sem trazer marcas doutrinarias, temos como único objetivo o crescimento e fortalecimento do povo escolhido do Senhor, através do pleno conhecimento das suas palavras. Além de lutar com todas as nossas forças contra o trabalho indiscriminado dos falsos mestres dentro das igrejas.</p>
  </div>
</div>
<!-- 3rd column -->
<div class="c3">
<h2 class="title"><i class="icon-link"></i>Rádio-OnLine</h2>
<hr class="footerstress">
<?php include('radio.html');?>
<?php
mysql_free_result($ls_categoria);

mysql_free_result($ls_situacao);
?>
</div>
<div class="c3">
  <h2 class="title"><i class="icon-envelope-alt"></i>Contato</h2>
  <hr class="footerstress">
  <dl>
    <dd>E-mail: atendimento.disseminando@gmail.com</dd>
  </dl>
  <ul class="social-links" style="margin-top:15px;">
    <li class="facebook-link smallrightmargin"><a href="#" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a></li>
    <li class="google-link smallrightmargin"><a href="#" class="google has-tip" title="Google +" target="_blank">Google</a></li>
  </ul>
  <br />
    <br />
    <dl>
        <dd>Parceiro</dd>
      <script>
        window.dna = {
            r:'7b3ce9a622885',
            c:'hospedagem-de-sites',
            t:'300x250'
        };
    </script>
    <script type="text/javascript" src="//www.kinghost.com.br/dna.js"></script>
    
    </dl>		
</div>
<!-- end 4th column -->
</div>
</div>
</div>
<!-- copyright area -->
<div class="copyright">
  <div class="grid">
    <div class="row">
      <div class="c6">Disseminando &copy; 2013. All Rights Reserved.</div>
      <div class="c6"></div>
    </div>
  </div>
</div>
</div>
<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="js/common.js"></script>

<!-- cycle -->
<script src="js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="js/jquery.tweet.js"></script>

</body>
</html>