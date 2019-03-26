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

$usuario=$_SESSION['MM_Username'];
$ano= date("Y");
$mes= date("m");

mysql_select_db($database_con01, $con01);
$query_ls_saldo = "SELECT cont_id, cont_data, cont_bco_id, cont_saldo_anterior, cont_saldo_atual, cont_usuario FROM fin_controla_saldo WHERE cont_usuario='$usuario'";
$ls_saldo = mysql_query($query_ls_saldo, $con01) or die(mysql_error());
$row_ls_saldo = mysql_fetch_assoc($ls_saldo);
$totalRows_ls_saldo = mysql_num_rows($ls_saldo);

mysql_select_db($database_con01, $con01);
$query_ls_valor_total = "SELECT  SUM(lanc_valor) FROM fin_lancamento WHERE lanc_usuario='$usuario' AND YEAR(lanc_venc)='$ano' AND MONTH(lanc_venc)='$mes'";
$ls_valor_total = mysql_query($query_ls_valor_total, $con01) or die(mysql_error());
$row_ls_valor_total = mysql_fetch_assoc($ls_valor_total);
$totalRows_ls_valor_total = mysql_num_rows($ls_valor_total);

mysql_select_db($database_con01, $con01);
$query_ls_total_aberto = "SELECT SUM(lanc_valor) FROM fin_lancamento, situacao_financeira WHERE lanc_situa=sit_fin_id AND lanc_situa=1 AND lanc_usuario='$usuario' AND YEAR(lanc_venc)='$ano' AND MONTH(lanc_venc)='$mes'";
$ls_total_aberto = mysql_query($query_ls_total_aberto, $con01) or die(mysql_error());
$row_ls_total_aberto = mysql_fetch_assoc($ls_total_aberto);
$totalRows_ls_total_aberto = mysql_num_rows($ls_total_aberto);

mysql_select_db($database_con01, $con01);
$query_ls_total_pago = "SELECT SUM(lanc_valor) FROM fin_lancamento, situacao_financeira WHERE lanc_situa=sit_fin_id AND lanc_situa=2 AND lanc_usuario='$usuario' AND YEAR(lanc_venc)='$ano' AND MONTH(lanc_venc)='$mes'";
$ls_total_pago = mysql_query($query_ls_total_pago, $con01) or die(mysql_error());
$row_ls_total_pago = mysql_fetch_assoc($ls_total_pago);
$totalRows_ls_total_pago = mysql_num_rows($ls_total_pago);

mysql_select_db($database_con01, $con01);
$query_ls_dados_bancarios = "SELECT usu_id, usu_nome, usu_fone, usu_email,usu_cadastrador, banco_numero, banco_agencia, banco_conta, cont_saldo_anterior, cont_saldo_atual, lanc_credor, lanc_venc, lanc_situa, lanc_valor, sit_fin_tipo, lanc_parcela
FROM usuario, fin_dados_bancarios, fin_controla_saldo, fin_lancamento, situacao_financeira 
WHERE usu_cadastrador='$usuario'
AND banco_usuario='$usuario'
AND cont_usuario='$usuario'
AND lanc_usuario='$usuario'
AND sit_fin_id=lanc_situa
AND YEAR(lanc_venc)='$ano'
AND MONTH(lanc_venc)='$mes'
ORDER BY lanc_venc DESC";
$ls_dados_bancarios = mysql_query($query_ls_dados_bancarios, $con01) or die(mysql_error());
$row_ls_dados_bancarios = mysql_fetch_assoc($ls_dados_bancarios);
$totalRows_ls_dados_bancarios = mysql_num_rows($ls_dados_bancarios);
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="boxedtheme">
<div class="grid">
<div class="row space-bot">
<div class="c4"> <a href="#"> <img src="../images/logo02.jpg" class="logo" alt=""> </a> </div>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=208"></script>
      </div>
    </div>
    <!-- end sidebar --> 
	<div class="c9"><h1 class="maintitle space-top"> <span>Extrato Financeiro</span></h1></div>	
    <div class="container"> 
	   <div class="table-responsive">
       <?php
			  $res=$totalRows_ls_dados_bancarios;									      
			  if($res>0)
			  {?> 
        <table width="100%" border="1" cellspacing="10" cellpadding="10">
          <tr>
            <th colspan="3" scope="col"><strong>Dados Bancários</strong></th>
          </tr>
          <tr>
            <td width="14%">Nome:</td>
            <td colspan="2"><?php echo $row_ls_dados_bancarios['usu_nome']; ?></td>
          </tr>
          <tr>
            <td>Telefone:</td>
            <td colspan="2"><?php echo $row_ls_dados_bancarios['usu_fone']; ?></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td colspan="2"><?php echo $row_ls_dados_bancarios['usu_email']; ?></td>
          </tr>
          <tr>
            <td>Banco:</td>
            <td colspan="2"><?php echo $row_ls_dados_bancarios['banco_numero']; ?></td>
          </tr>
          <tr>
            <td>Agencia:</td>
            <td colspan="2"><?php echo $row_ls_dados_bancarios['banco_agencia']; ?></td>
          </tr>
          <tr>
            <td>Conta:</td>
            <td width="33%"><?php echo $row_ls_dados_bancarios['banco_conta']; ?></td>
            <td width="53%"><strong>Saldo DisponivelR$:&nbsp<?php
             $saldo1=$row_ls_saldo['cont_saldo_anterior'];
			 $saldo2=$row_ls_saldo['cont_saldo_atual'];
			 $valor_total=$row_ls_valor_total['SUM(lanc_valor)'];
			 echo (($saldo2 + $saldo1)-$valor_total);
			?></strong></td>
          </tr>          
          <tr>
            <th colspan="3" scope="col"><strong>Movimentação</strong></th>
          </tr>
        </table>
        <table width="100%" border="1" cellspacing="10" cellpadding="10">
          <tr>
            <th scope="col"><strong>Credor</strong></th>
            <th scope="col"><strong>Situação</strong></th>
            <th scope="col"><strong>Vencimento</strong></th>
            <th scope="col"><strong>Parcela</strong></th>
            <th scope="col"><strong>ValorR$</strong></th>
          </tr><strong>
           <?php do { ?>
          <tr>
            <td><?php echo $row_ls_dados_bancarios['lanc_credor']; ?></td>
            <td><?php echo $row_ls_dados_bancarios['sit_fin_tipo']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($row_ls_dados_bancarios['lanc_venc'])); ?></td>
            <td><?php echo $row_ls_dados_bancarios['lanc_parcela']; ?></td>
            <td><?php echo $row_ls_dados_bancarios['lanc_valor']; ?></td>
          </tr>
          <?php } while ($row_ls_dados_bancarios = mysql_fetch_assoc($ls_dados_bancarios)); ?>
        </table>
        <table width="100%" border="1" cellspacing="10" cellpadding="10">
          <tr>
            <th colspan="2" scope="col"><strong>Resultado</strong></th>
          </tr>          
          <tr>
            <td>Total Em Aberto R$:</td>
            <td><?php echo $row_ls_total_aberto['SUM(lanc_valor)']; ?></td>
          </tr>
          <tr>
            <td>Total Pago R$:</td>
            <td><?php echo $row_ls_total_pago['SUM(lanc_valor)']; ?></td>
          </tr>
          <tr>
            <td width="17%">Valor Total R$:</td>
            <td width="83%"><?php echo $row_ls_valor_total['SUM(lanc_valor)']; ?></td>
          </tr>   
        </table>
        <?php } else {			   
										 
					echo "Não foi encontrado nenhum registro.";
				 }
		?>
	  </div>
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

</body>
</html>
<?php
mysql_free_result($ls_saldo);

mysql_free_result($ls_valor_total);

mysql_free_result($ls_total_aberto);

mysql_free_result($ls_total_pago);

mysql_free_result($ls_dados_bancarios);
?>
