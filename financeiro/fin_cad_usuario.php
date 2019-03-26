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

$MM_restrictGoTo = "../financeiro/fin_menu_principal.php";
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="fin_cad_usuario.php";
  $loginUsername = $_POST['usu_email'];
  $LoginRS__query = sprintf("SELECT usu_email FROM usuario WHERE usu_email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_con01, $con01);
  $LoginRS=mysql_query($LoginRS__query, $con01) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$data2 = $_POST['usu_data'];
	$data2 = explode("/", $data2);
    $data2 = $data2[2]."-".$data2[1]."-".$data2[0];
  $insertSQL = sprintf("INSERT INTO usuario (usu_data, usu_nome, usu_fone, usu_email, usu_uf, usu_cidade, usu_igreja, usu_nivel, usu_situacao, usu_cadastrador) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($data2, "date"),
                       GetSQLValueString($_POST['usu_nome'], "text"),
                       GetSQLValueString($_POST['usu_fone'], "text"),
                       GetSQLValueString($_POST['usu_email'], "text"),
                       GetSQLValueString($_POST['usu_uf'], "int"),
                       GetSQLValueString($_POST['usu_cidade'], "int"),
                       GetSQLValueString($_POST['usu_igreja'], "text"),
                       GetSQLValueString($_POST['usu_nivel'], "int"),
                       GetSQLValueString($_POST['usu_situacao'], "int"),
                       GetSQLValueString($_POST['usu_cadastrador'], "text"));

  mysql_select_db($database_con01, $con01);
  $Result1 = mysql_query($insertSQL, $con01) or die(mysql_error());

  $insertGoTo = "fin_cad_usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_con01, $con01);
$query_cs_situacao = "SELECT sit_cad_id, sit_cad_nome FROM situacao_cadastro";
$cs_situacao = mysql_query($query_cs_situacao, $con01) or die(mysql_error());
$row_cs_situacao = mysql_fetch_assoc($cs_situacao);
$totalRows_cs_situacao = mysql_num_rows($cs_situacao);

$usuario =$_SESSION['MM_Username'];

mysql_select_db($database_con01, $con01);
$query_ls_cadastro = "SELECT usu_id, usu_data, usu_nome, usu_fone, usu_email, usu_uf, usu_cidade, usu_igreja, usu_nivel, usu_situacao, usu_cadastrador FROM usuario WHERE usu_cadastrador='$usuario' ORDER BY usu_data ASC";
$ls_cadastro = mysql_query($query_ls_cadastro, $con01) or die(mysql_error());
$row_ls_cadastro = mysql_fetch_assoc($ls_cadastro);
$totalRows_ls_cadastro = mysql_num_rows($ls_cadastro);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando | Sua fé sem fronteiras.</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/icons.css"/>
<link rel="stylesheet" type="text/css" href="../css/skinblue.css"/>
<!-- change skin color -->
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
<li class="active"><a href="../administracao/painelControle.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
<li><a href="#">Configuração</a>
  <ul style="display: none;">
    <li><a href="../financeiro/fin_cad_categoria.php">Categoria</a></li>
    <li><a href="../financeiro/fin_cad_dados_bancarios.php">Dados Bancários</a></li>
    <li><a href="../financeiro/fin_cad_usuario.php">Dados Cadastrais</a></li> 
    <li><a href="../financeiro/fin_cad_saldo.php">Saldo</a></li> 
  </ul>
</li>
<li><a href="#">Movimentação</a>
  <ul style="display: none;">
     <li><a href="../financeiro/fin_cad_baixa.php">Baixa</a></li>
    <li><a href="../financeiro/fin_cs_lancamentos.php">Consulta</a></li>
    <li><a href="../financeiro/fin_cad_lancamentos.php">Lançamentos</a></li>
  </ul>
</li>
<li><a href="<?php echo $logoutAction ?>">Sair</a></li>
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
      <h1 class="maintitle space-top"> <span>CADASTRA USUÁRIO</span></h1>
      <hr class="hrtitle">
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Data:</td>
            <td><input type="text" name="usu_data" value="<?php  
																						$date = date('d/m/Y');
																						echo $date;
																						?>" size="10" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Nome:</td>
            <td><span id="sprytextfield2">
              <input type="text" name="usu_nome" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Telefone:</td>
            <td><span id="sprytextfield3">
            <input type="text" name="usu_fone" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Email:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="usu_email" value="" size="32">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Estado:</td>
            <td><span id="sprytextfield4">
              <input name="usu_uf" type="text" value="" size="32" maxlength="40">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Cidade:</td>
            <td><span id="sprytextfield5">
              <input name="usu_cidade" type="text" value="" size="32" maxlength="40">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Igreja:</td>
            <td><span id="sprytextfield6">
              <input name="usu_igreja" type="text" value="" size="32" maxlength="40">
            <span class="textfieldRequiredMsg">Um valor é necessário.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Nivel:</td>
            <td>
              <select name="usu_nivel" id="usu_nivel">
                <option value="5">Usuário</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Situação:</td>
            <td>
              <select name="usu_situacao" id="usu_situacao">
                <option value="1">Ativo</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Cadastrador:</td>
            <td><input type="text" name="usu_cadastrador" value="<?php $usuario =$_SESSION['MM_Username'];echo "$usuario";?>" readonly="readonly"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" class="success" value="Inserir registro"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      </form> 
      <br>
      <br>
       <h5>Meu Cadastro</h5>
        <hr>        
        <br>
        <table border="1" cellpadding="10" cellspacing="10">
          <tr>
            <td bgcolor="#CCCCCC"><strong>Nome</strong></td>
            <td bgcolor="#CCCCCC"><strong>Telefone</strong></td>
            <td bgcolor="#CCCCCC"><strong>Email</strong></td>
          </tr>
          <?php do { ?>
            <tr>
              <td><a href="fin_upd_usuario.php?usu_id=<?php echo $row_ls_cadastro['usu_id']; ?>"><?php echo $row_ls_cadastro['usu_nome']; ?></a></td>
              <td><?php echo $row_ls_cadastro['usu_fone']; ?></td>
              <td><?php echo $row_ls_cadastro['usu_email']; ?></td>
            </tr>
            <?php } while ($row_ls_cadastro = mysql_fetch_assoc($ls_cadastro)); ?>
        </table> 
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
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["blur", "change"], useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "custom", {pattern:"(xx)xxxxx-xxxx", validateOn:["blur", "change"], useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($cs_situacao);

mysql_free_result($ls_cadastro);
?>