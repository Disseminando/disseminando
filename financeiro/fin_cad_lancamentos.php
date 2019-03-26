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
	$data = $_POST['lanc_data'];
	$data = explode("/", $data);
    $data = $data[2]."-".$data[1]."-".$data[0];
	$valor = $_POST['lanc_valor'];
	$valor = str_replace(',', '.',$valor);
	$data2 = $_POST['lanc_venc'];
	$data2 = explode("/", $data2);
    $data2 = $data2[2]."-".$data2[1]."-".$data2[0];
  $insertSQL = sprintf("INSERT INTO fin_lancamento (lanc_data, lanc_cat, lanc_situa, lanc_tp_pag, lanc_credor, lanc_valor, lanc_venc, lanc_parcela, lanc_obs, lanc_usuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($data, "date"),
                       GetSQLValueString($_POST['lanc_cat'], "int"),
                       GetSQLValueString($_POST['lanc_situa'], "int"),
                       GetSQLValueString($_POST['lanc_tp_pag'], "int"),
                       GetSQLValueString($_POST['lanc_credor'], "text"),
                       GetSQLValueString($valor, "double"),
                       GetSQLValueString($data2, "date"),
                       GetSQLValueString($_POST['lanc_parcela'], "int"),
                       GetSQLValueString($_POST['lanc_obs'], "text"),
                       GetSQLValueString($_POST['lanc_usuario'], "text"));

  mysql_select_db($database_con01, $con01);
  $Result1 = mysql_query($insertSQL, $con01) or die(mysql_error());

  $insertGoTo = "fin_cad_lancamentos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$usuario=$_SESSION['MM_Username'];

mysql_select_db($database_con01, $con01);
$query_ls_categoria = "SELECT * FROM fin_categoria WHERE cat_usuario='$usuario' ORDER BY cat_nome ASC";
$ls_categoria = mysql_query($query_ls_categoria, $con01) or die(mysql_error());
$row_ls_categoria = mysql_fetch_assoc($ls_categoria);
$totalRows_ls_categoria = mysql_num_rows($ls_categoria);

mysql_select_db($database_con01, $con01);
$query_ls_situacao = "SELECT * FROM situacao_financeira ORDER BY sit_fin_tipo ASC";
$ls_situacao = mysql_query($query_ls_situacao, $con01) or die(mysql_error());
$row_ls_situacao = mysql_fetch_assoc($ls_situacao);
$totalRows_ls_situacao = mysql_num_rows($ls_situacao);

mysql_select_db($database_con01, $con01);
$query_ls_pagamento = "SELECT * FROM tipo_pagamento ORDER BY tipo_pag ASC";
$ls_pagamento = mysql_query($query_ls_pagamento, $con01) or die(mysql_error());
$row_ls_pagamento = mysql_fetch_assoc($ls_pagamento);
$totalRows_ls_pagamento = mysql_num_rows($ls_pagamento);

$maxRows_ls_despesas = 10;
$pageNum_ls_despesas = 0;
if (isset($_GET['pageNum_ls_despesas'])) {
  $pageNum_ls_despesas = $_GET['pageNum_ls_despesas'];
}
$startRow_ls_despesas = $pageNum_ls_despesas * $maxRows_ls_despesas;

mysql_select_db($database_con01, $con01);
$query_ls_despesas = "SELECT lanc_situa, lanc_credor, lanc_valor, lanc_venc, sit_fin_tipo FROM fin_lancamento, situacao_financeira WHERE lanc_situa=sit_fin_id ORDER BY lanc_venc DESC";
$query_limit_ls_despesas = sprintf("%s LIMIT %d, %d", $query_ls_despesas, $startRow_ls_despesas, $maxRows_ls_despesas);
$ls_despesas = mysql_query($query_limit_ls_despesas, $con01) or die(mysql_error());
$row_ls_despesas = mysql_fetch_assoc($ls_despesas);

if (isset($_GET['totalRows_ls_despesas'])) {
  $totalRows_ls_despesas = $_GET['totalRows_ls_despesas'];
} else {
  $all_ls_despesas = mysql_query($query_ls_despesas);
  $totalRows_ls_despesas = mysql_num_rows($all_ls_despesas);
}
$totalPages_ls_despesas = ceil($totalRows_ls_despesas/$maxRows_ls_despesas)-1;
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
    <li><a href="../financeiro/fin_cad_categoria.php">Categoria</a></li>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=132"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9"><br />
      <h1 class="maintitle space-top"> <span>Cadastra Categoria</span></h1>
      <hr class="hrtitle">
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Data:</td>
            <td><input type="text" name="lanc_data" value="<?php  
																						$date = date('d/m/Y');
																						echo $date;
																						?>" size="10" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Categoria:</td>
            <td><select name="lanc_cat" id="lanc_cat">
            <option value="0">Selecione....</option>
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
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Situação:</td>
            <td><select name="lanc_situa" id="lanc_situa">
            <option value="0">Selecione....</option>
              <?php
do {  
?>
              <option value="<?php echo $row_ls_situacao['sit_fin_id']?>"><?php echo $row_ls_situacao['sit_fin_tipo']?></option>
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
            <td nowrap align="right">Pagamento:</td>
            <td><select name="lanc_tp_pag" id="lanc_tp_pag">
            <option value="0">Selecione....</option>
              <?php
				do {  
				?>
			    <option value="<?php echo $row_ls_pagamento['id_tp_pag']?>"><?php echo $row_ls_pagamento['tipo_pag']?></option>
							  <?php
				} while ($row_ls_pagamento = mysql_fetch_assoc($ls_pagamento));
				  $rows = mysql_num_rows($ls_pagamento);
				  if($rows > 0) {
					  mysql_data_seek($ls_pagamento, 0);
					  $row_ls_pagamento = mysql_fetch_assoc($ls_pagamento);
				  }
				?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Credor:</td>
            <td><input name="lanc_credor" type="text" value="" size="32" maxlength="30"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Valor R$:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="lanc_valor" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Vencimento:</td>
            <td><span id="sprytextfield2">
            <input type="text" name="lanc_venc" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">parcela:</td>
            <td><span id="sprytextfield3">
            <input name="lanc_parcela" type="text" value="" size="10" maxlength="3">
            <span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap>Observação:</td>
            <td><textarea name="lanc_obs" cols="32" rows="3"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Usuário:</td>
            <td><input type="text" name="lanc_usuario" value="<?php $usuario =$_SESSION['MM_Username'];echo "$usuario";?>" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
<br>
       <h5>Últimas Contas</h5>
        <hr>
        <table border="1" cellpadding="10" cellspacing="10">
          <tr>
            <td bgcolor="#999999"><font color="#000099" size="4">Credor</font></td>
            <td bgcolor="#999999"><font color="#000099" size="4">Valor</font></td>
            <td bgcolor="#999999"><font color="#000099" size="4">Vencimento</font></td>
            <td bgcolor="#999999"><font color="#000099" size="4">Situação</font></td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_ls_despesas['lanc_credor']; ?></td>
              <td><?php echo $row_ls_despesas['lanc_valor']; ?></td>
              <td><?php echo $row_ls_despesas['lanc_venc']; ?></td>
              <td><?php echo $row_ls_despesas['sit_fin_tipo']; ?></td>
            </tr>
            <?php } while ($row_ls_despesas = mysql_fetch_assoc($ls_despesas)); ?>
        </table>
<br>
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
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", validateOn:["blur", "change"], useCharacterMasking:true});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($ls_categoria);

mysql_free_result($ls_situacao);

mysql_free_result($ls_pagamento);

mysql_free_result($ls_despesas);
?>
