<?php require_once('../Connections/con01.php'); ?>
<?php include("../Connections/con01.php");?>
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

$MM_restrictGoTo = "../administracao/painelControle.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE videos SET vid_data=%s, vid_codigo=%s, vid_categoria=%s, vid_situacao=%s, vid_usuario=%s WHERE vid_id=%s",
                       GetSQLValueString($_POST['vid_data'], "date"),
                       GetSQLValueString($_POST['vid_codigo'], "text"),
                       GetSQLValueString($_POST['vid_categoria'], "int"),
                       GetSQLValueString($_POST['vid_situacao'], "int"),
                       GetSQLValueString($_POST['vid_usuario'], "text"),
                       GetSQLValueString($_POST['vid_id'], "int"));

  mysql_select_db($database_con01, $con01);
  $Result1 = mysql_query($updateSQL, $con01) or die(mysql_error());

  $updateGoTo = "videoLista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ls_videos = "-1";
if (isset($_GET['vid_id'])) {
  $colname_ls_videos = $_GET['vid_id'];
}
mysql_select_db($database_con01, $con01);
$query_ls_videos = sprintf("SELECT vid_id, vid_data, vid_codigo, vid_categoria, vid_situacao, vid_usuario FROM videos WHERE vid_id = %s", GetSQLValueString($colname_ls_videos, "int"));
$ls_videos = mysql_query($query_ls_videos, $con01) or die(mysql_error());
$row_ls_videos = mysql_fetch_assoc($ls_videos);
$totalRows_ls_videos = mysql_num_rows($ls_videos);

mysql_select_db($database_con01, $con01);
$query_ls_categoria = "SELECT vid_cat_id, vid_cat_tipo FROM video_categoria";
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
<title>Disseminando Cristo</title>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/icons.css"/>
<link rel="stylesheet" type="text/css" href="../css/skinblue.css"/>
<link rel="stylesheet" type="text/css" href="../css/responsive.css"/>
<script src="../js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../js/funcs.js"></script>
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
<li class="active"><a href="adm_menu_principal.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
<li><a href="#">Menu</a>
  <ul style="display: none;">    
    <li><a href="mensagemCadastro.php">Cadastro</a></li>
    <li><a href="msg_consulta.php">Consulta</a></li>
     <li><a href="videoCadastro.php">Video</a></li>
    <li class="last"><a href="<?php echo $logoutAction ?>">Fechar</a></li>
  </ul>
</nav>
</div>
</div>
</div>
<br>
<!-- HEADER================================================== -->
<div class="undermenuarea">
  <div class="boxedshadow"> </div>
  <div class="grid">
    <div class="row">
      <div class="c8">
        <h1 class="titlehead">Atualiza Video</h1>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=58"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9">
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Data:</td>
            <td><input name="vid_data" type="text" value="<?php echo htmlentities($row_ls_videos['vid_data'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Codigo:</td>
            <td><input type="text" name="vid_codigo" value="<?php echo htmlentities($row_ls_videos['vid_codigo'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Categoria:</td>
            <td>
              <select name="vid_categoria" id="vid_categoria">
                <?php
do {  
?>
                <option value="<?php echo $row_ls_categoria['vid_cat_id']?>"<?php if (!(strcmp($row_ls_categoria['vid_cat_id'], $row_ls_videos['vid_categoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ls_categoria['vid_cat_tipo']?></option>
                <?php
} while ($row_ls_categoria = mysql_fetch_assoc($ls_categoria));
  $rows = mysql_num_rows($ls_categoria);
  if($rows > 0) {
      mysql_data_seek($ls_categoria, 0);
	  $row_ls_categoria = mysql_fetch_assoc($ls_categoria);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Situacao:</td>
            <td>
              <select name="vid_situacao" id="vid_situacao">
                <?php
do {  
?>
                <option value="<?php echo $row_ls_situacao['sit_cad_id']?>"<?php if (!(strcmp($row_ls_situacao['sit_cad_id'], $row_ls_videos['vid_situacao']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ls_situacao['sit_cad_nome']?></option>
                <?php
} while ($row_ls_situacao = mysql_fetch_assoc($ls_situacao));
  $rows = mysql_num_rows($ls_situacao);
  if($rows > 0) {
      mysql_data_seek($ls_situacao, 0);
	  $row_ls_situacao = mysql_fetch_assoc($ls_situacao);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Usuario:</td>
            <td><input name="vid_usuario" type="text"value="<?php  echo $_SESSION['MM_Username'];?>" size="32" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Gravar"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="vid_id" value="<?php echo $row_ls_videos['vid_id']; ?>">
      </form>
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
<script src="..<?php
mysql_free_result($ls_situacao);
?>/js/jquery.tweet.js"></script>

</body>
</html>
<?php
mysql_free_result($ls_videos);

mysql_free_result($ls_categoria);

mysql_free_result($ls_situacao);
?>
