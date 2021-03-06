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
  $MM_dupKeyRedirect="adm_menu_principal.php";
  $loginUsername = $_POST['cnpj_cli'];
  $LoginRS__query = sprintf("SELECT cnpj_cli FROM adm_cliente WHERE cnpj_cli=%s", GetSQLValueString($loginUsername, "text"));
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

mysql_select_db($database_con01, $con01);
$query_cs_situacao = "SELECT sit_cad_id, sit_cad_nome FROM situacao_cadastro";
$cs_situacao = mysql_query($query_cs_situacao, $con01) or die(mysql_error());
$row_cs_situacao = mysql_fetch_assoc($cs_situacao);
$totalRows_cs_situacao = mysql_num_rows($cs_situacao);
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
    <li><a href="adm_cs_contrato.php">Consulta</a></li>
    <li><a href="mensagemCadastro.php">Mensagem</a></li>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=132"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9"><br />
      <h1 class="maintitle space-top"> <span>CADASTRO DE CLIENTE</span></h1>
      <hr class="hrtitle">
       <form method="post" name="form1" id="form1" action="valida_contrato.php">
         <table align="center" border="0">           
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Cnpj:</strong></td>
             <td><input type="text" name="cnpj_cli" value="" size="32" maxlenght="30" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Nome:</strong></td>
             <td><input type="text" name="nome_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Endereço:</strong></td>
             <td><input type="text" name="end_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Bairro:</strong></td>
             <td><input type="text" name="bairro_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Estado:</strong></td>
             <td><select name="estado_cli" id="estado_cli">
               <option value="1">DF</option>
               <option value="2">GO</option>
             </select></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Cidade:</strong></td>
             <td><select name="cidade_cli" id="cidade_cli">
               <option value="1">Brasilia</option>
               <option value="2">Valparaiso</option>
             </select></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Cep:</strong></td>
             <td><input type="text" name="cep_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Telefone:</strong></td>
             <td><input type="text" name="fone_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Email:</strong></td>
             <td><input type="text" name="email_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Contato:</strong></td>
             <td><input type="text" name="contato_cli" value="" size="32" /></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Situação:</strong></td>
             <td><select name="situacao_cli" id="situacao_cli">
               <option value="0">Selecione....</option>
               <?php
				do {  
				?>
				<option value="<?php echo $row_cs_situacao['sit_cad_id']?>"><?php echo $row_cs_situacao['sit_cad_nome']?></option>
			   <?php
				} while ($row_cs_situacao = mysql_fetch_assoc($cs_situacao));
				  $rows = mysql_num_rows($cs_situacao);
				  if($rows > 0) {
					  mysql_data_seek($cs_situacao, 0);
					  $row_cs_situacao = mysql_fetch_assoc($cs_situacao);
				  }
				?>
             </select></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Observação:</strong></td>
             <td><textarea name="obs_cli" id="obs_cli" cols="45" rows="5"></textarea></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right"><strong>Usuario:</strong></td>
             <td><input type="text" name="usuario_cli" value="<?php $usuario =$_SESSION['MM_Username'];echo "$usuario";?>" readonly="readonly"></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right">&nbsp;</td>
             <td><input type="submit" value="Cadastrar" /></td>
           </tr>
         </table>
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
<script src="../js/jquery.tweet.js"></script>

</body>
</html>
<?php
mysql_free_result($cs_situacao);
?>