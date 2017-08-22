<?php require_once('Connections/con01.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['cur_usu_login'])) {
  $loginUsername=$_POST['cur_usu_login'];
  $password=$_POST['cur_usu_senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "meu_curriculo.php";
  $MM_redirectLoginFailed = "curriculo_login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_con01, $con01);
  
  $LoginRS__query=sprintf("SELECT cur_usu_login, cur_usu_senha FROM curriculo_usuario WHERE cur_usu_login=%s AND cur_usu_senha=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $con01) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML>
<html>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando | Sua fé sem fronteiras.</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
	<div class="row space-bot">
		<!--Logo-->
		<div class="c4">
			<a href="index.php">
			<img src="images/logo02.jpg" class="logo" alt="">
			</a>
		</div>
		<!--Menu-->
		<div class="c8">
			<nav id="topNav">
			<ul id="responsivemenu">
				<li class="active"><a href="index.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
				<li><a href="#">Menu</a>
				<ul style="display: none;">
					<li><a href="curriculo_cadastro.php">Novo Usuario</a></li>																		
			</ul>
			</nav>
		</div>
	</div>
</div>
<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">Curriculo</h1>
			</div>
			
		</div>
	</div>
</div>
<!-- CONTENT
================================================== -->
<div class="grid">
		<div class="shadowundertop">
		</div>
		<div class="row">		
			
			<!-- MAIN CONTENT -->
			<div class="c9">
				<h1 class="maintitle space-top">
				<span>ACESSO RESTRITO</span>
				</h1>
                <form name="login" method="POST" action="<?php echo $loginFormAction; ?>">                 
                        Usuario:
                        <input name="cur_usu_login" type="text" id="cur_usu_login" value="" maxlength="20" /><br />                    
                        Senha::                    
                        <input name="cur_usu_senha" type="password" id="cur_usu_senha" value="" maxlength="20" /><br />                   
                        <input name="Submit" type="submit" class="button" value="Acessar" /> <br />                    
                  </form>
                <br />
                <a href="curriculo_recupera_senha.php"><img src="images/recupera_senha.png" alt="Recupera Senha" title="Recupera Senha"/></img></a>                			
           </div>	
			<!-- SIDEBAR -->	
			<div class="c3">
				<div class="rightsidebar">
					<h1 class="maintitle space-top">
					<span>Parceiro</span>
					</h1>
				  <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=205"></script>				
				</div>
			</div><!-- end sidebar -->			
		</div>
</div><!-- end grid -->

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
				<img src="images/03.png" style="padding-top: 70px;" alt="">
			</div>
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
			</div>
			<div class="c3">
				<h2 class="title"><i class="icon-envelope-alt"></i> Contato</h2>
				<hr class="footerstress">
				<dl>
					<dd>E-mail: atendimento.disseminando@gmail.com</dd>
				</dl>
				<ul class="social-links" style="margin-top:15px;">					
					<li class="facebook-link smallrightmargin">
					<a href="#" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a>
					</li>
					<li class="google-link smallrightmargin">
					<a href="#" class="google has-tip" title="Google +" target="_blank">Google</a>
					</li>
				</ul>
                <br />
                <br />
                <dl>				
                  <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=202"></script>
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
<script src="js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="js/common.js"></script>

<!-- cycle -->
<script src="js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="js/jquery.tweet.js"></script>

</body>
</html>