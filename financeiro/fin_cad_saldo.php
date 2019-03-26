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
$MM_authorizedUsers = "1,2,3,4,5";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$data = $_POST['cont_data'];
	$data = explode("/", $data);
    $data = $data[2]."-".$data[1]."-".$data[0];
	
	$valor = $_POST['cont_saldo_anterior'];
	$valor = str_replace(',', '.',$valor);
	
	$valor2 = $_POST['cont_saldo_atual'];
	$valor2 = str_replace(',', '.',$valor2);
	
  $insertSQL = sprintf("INSERT INTO fin_controla_saldo (cont_data, cont_bco_id, cont_saldo_anterior, cont_saldo_atual, cont_usuario) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($data, "date"),
                       GetSQLValueString($_POST['cont_bco_id'], "int"),
                       GetSQLValueString($valor, "double"),
                       GetSQLValueString($valor2, "double"),
                       GetSQLValueString($_POST['cont_usuario'], "text"));

  mysql_select_db($database_con01, $con01);
  $Result1 = mysql_query($insertSQL, $con01) or die(mysql_error());

  $insertGoTo = "fin_cad_saldo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$usuario=$_SESSION['MM_Username'];

mysql_select_db($database_con01, $con01);
$query_ls_banco = "SELECT banco_id, banco_numero FROM fin_dados_bancarios WHERE banco_usuario='$usuario' ORDER BY banco_numero ASC";
$ls_banco = mysql_query($query_ls_banco, $con01) or die(mysql_error());
$row_ls_banco = mysql_fetch_assoc($ls_banco);
$totalRows_ls_banco = mysql_num_rows($ls_banco);

$maxRows_ls_saldo = 12;
$pageNum_ls_saldo = 0;
if (isset($_GET['pageNum_ls_saldo'])) {
  $pageNum_ls_saldo = $_GET['pageNum_ls_saldo'];
}
$startRow_ls_saldo = $pageNum_ls_saldo * $maxRows_ls_saldo;

mysql_select_db($database_con01, $con01);
$query_ls_saldo = "SELECT cont_id, cont_data, cont_bco_id, cont_saldo_anterior, cont_saldo_atual, cont_usuario, banco_numero FROM fin_controla_saldo, fin_dados_bancarios WHERE cont_bco_id=banco_id ORDER BY cont_id DESC";
$query_limit_ls_saldo = sprintf("%s LIMIT %d, %d", $query_ls_saldo, $startRow_ls_saldo, $maxRows_ls_saldo);
$ls_saldo = mysql_query($query_limit_ls_saldo, $con01) or die(mysql_error());
$row_ls_saldo = mysql_fetch_assoc($ls_saldo);

if (isset($_GET['totalRows_ls_saldo'])) {
  $totalRows_ls_saldo = $_GET['totalRows_ls_saldo'];
} else {
  $all_ls_saldo = mysql_query($query_ls_saldo);
  $totalRows_ls_saldo = mysql_num_rows($all_ls_saldo);
}
$totalPages_ls_saldo = ceil($totalRows_ls_saldo/$maxRows_ls_saldo)-1;
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
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</script>
<script language="javascript">
function mascaraMutuario(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1)
}
 
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
 
function cpfCnpj(v){
 
    //Remove tudo o que não é dígito
    v=v.replace(/\D/g,"")
 
    if (v.length <= 14) { //CPF
 
        //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
 
        //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
 
        //Coloca um hífen entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
 
    } else { //CNPJ
 
        //Coloca ponto entre o segundo e o terceiro dígitos
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")
 
        //Coloca ponto entre o quinto e o sexto dígitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
 
        //Coloca uma barra entre o oitavo e o nono dígitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
 
        //Coloca um hífen depois do bloco de quatro dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2")
 
    }
 
    return v
 
}
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="boxedtheme">
<div class="grid">
<div class="row space-bot">
<!--Logo-->
<div class="c4"> <a href="#"> <img src="../images/logo02.jpg" class="logo" alt=""> </a> </div>
<!--Menu-->
<div class="c8">
<nav id="topNav">
<ul id="responsivemenu">
<li class="active"><a href="fin_menu_principal.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
<li><a href="#">Menu</a>
  <ul style="display: none;">
    <li><a href="../financeiro/fin_cad_lancamentos.php">Lançamentos</a></li>
    <li><a href="../financeiro/fin_cs_lancamentos.php">Consulta</a></li>
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
        <h1 class="titlehead">Financeiro</h1>
      </div>
      <div class="c4">
        <h1 class="titlehead rightareaheader"><i class="icon-map-marker">&nbsp Usuario:&nbsp</i></h1>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=132"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9"><br />
      <h1 class="maintitle space-top"> <span>Saldo Bancário</span></h1>
      <hr class="hrtitle">
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Data:</td>
            <td><input type="text" name="cont_data" value="<?php  
																						$date = date('d/m/Y');
																						echo $date;
																						?>" size="10" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Banco:</td>
            <td><span id="spryselect1">
              <select name="cont_bco_id" id="cont_bco_id">
                <option value="0">Selecione....</option>
                <?php
do {  
?>
                <option value="<?php echo $row_ls_banco['banco_id']?>"><?php echo $row_ls_banco['banco_numero']?></option>
                <?php
} while ($row_ls_banco = mysql_fetch_assoc($ls_banco));
  $rows = mysql_num_rows($ls_banco);
  if($rows > 0) {
      mysql_data_seek($ls_banco, 0);
	  $row_ls_banco = mysql_fetch_assoc($ls_banco);
  }
?>
              </select>
            <span class="selectInvalidMsg">Selecione um item válido.</span><span class="selectRequiredMsg">Selecione um item.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Saldo Anterior R$:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="cont_saldo_anterior" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Saldo Atual R$:</td>
            <td><span id="sprytextfield2">
            <input type="text" name="cont_saldo_atual" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Usuário:</td>
            <td><input type="text" name="cont_usuario" value="<?php $usuario =$_SESSION['MM_Username'];echo "$usuario";?>" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" class="success" value="Cadastrar"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
      <br>
       <h5>Últimos lançamentos</h5>
        <hr>
        <br>
        <table border="1" cellpadding="10" cellspacing="10">
          <tr>
            <td bgcolor="#CCCCCC"><strong>Data</strong></td>
            <td bgcolor="#CCCCCC"><strong>Banco</strong></td>
            <td bgcolor="#CCCCCC"><strong>Saldo anterior R$</strong></td>
            <td bgcolor="#CCCCCC"><strong>Saldo atual R$</strong></td>
            <td bgcolor="#CCCCCC"><strong>Saldo Total R$</strong></td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_ls_saldo['cont_data']; ?></td>
              <td><?php echo $row_ls_saldo['banco_numero']; ?></td>
              <td><?php echo $row_ls_saldo['cont_saldo_anterior']; ?></td>
              <td><?php echo $row_ls_saldo['cont_saldo_atual']; ?></td>
              <td><?php 
			       $saldo1=$row_ls_saldo['cont_saldo_anterior'];
			       $saldo2=$row_ls_saldo['cont_saldo_atual'];				   
			       echo ($saldo2+$saldo1);?></td>
            </tr>
            <?php } while ($row_ls_saldo = mysql_fetch_assoc($ls_saldo)); ?>
        </table>
    </div>    
  </div>
</div>
<!-- FOOTER -->
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
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency", {format:"dot_comma", validateOn:["blur", "change"], useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency", {format:"dot_comma", validateOn:["blur", "change"], useCharacterMasking:true});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"0", validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($ls_banco);

mysql_free_result($ls_saldo);
?>
