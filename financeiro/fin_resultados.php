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

$data= $_POST['inicio'];
$data = explode("/", $data);
$data = $data[2]."-".$data[1]."-".$data[0];

$data1 = $_POST['final'];
$data1 = explode("/", $data1);
$data1 = $data1[2]."-".$data1[1]."-".$data1[0];

$usuario=$_SESSION['MM_Username'];

mysql_select_db($database_con01, $con01);
$query_ls_despesas = "SELECT lanc_id, lanc_data, lanc_cat, lanc_situa, lanc_tp_pag, lanc_credor, lanc_valor, lanc_venc, lanc_parcela, lanc_obs, lanc_usuario, sit_fin_tipo FROM fin_lancamento, situacao_financeira WHERE lanc_venc BETWEEN '$data' AND '$data1' AND lanc_situa=sit_fin_id AND lanc_usuario='$usuario' ORDER BY lanc_venc ASC";
$ls_despesas = mysql_query($query_ls_despesas, $con01) or die(mysql_error());
$row_ls_despesas = mysql_fetch_assoc($ls_despesas);
$totalRows_ls_despesas = mysql_num_rows($ls_despesas);
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

<script type="text/javascript" src="../js/funcs.js"></script>
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
    <li><a href="../financeiro/fin_cad_lancamentos.php">Lançamentos</a></li>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=58"></script>
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9"><br />
      <h1 class="maintitle space-top"> <span>LISTAGEM DE DESPESAS</span></h1>
      <hr class="hrtitle">        
        <div id="conteudo">
          <table border="1" cellpadding="10" cellspacing="10">
            <tr>
              <td bgcolor="#CCCCCC"><strong>Credor</strong></td>              
              <td bgcolor="#CCCCCC"><strong>Vencimento</strong></td>
              <td bgcolor="#CCCCCC"><strong>Situação</strong></td>
              <td bgcolor="#CCCCCC"><strong>Valor R$</strong></td>
            </tr>
            <?php do { ?>
              <tr>
                <td><a href="fin_upd_lancamentos.php?lanc_id=<?php echo $row_ls_despesas['lanc_id']; ?>"><?php echo $row_ls_despesas['lanc_credor']; ?></a></td>                
                <td><?php echo $row_ls_despesas['lanc_venc']; ?></td>
                <td><?php echo $row_ls_despesas['sit_fin_tipo']; ?></td>
                <td><?php echo $row_ls_despesas['lanc_valor']; ?></td>
              </tr>
              <?php } while ($row_ls_despesas = mysql_fetch_assoc($ls_despesas)); ?>
          </table>
       <br>
      </div>        
    </div>
  </div>
</div>
<!-- FOOTER================================================== -->

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
mysql_free_result($ls_despesas);
?>
