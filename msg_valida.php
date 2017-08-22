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
$msg = false;

if(isset($_FILES['msg_foto'])){
	
	$data = $_POST['msg_data'];
	$data = explode("/", $data);
    $data = $data[2]."-".$data[1]."-".$data[0];
	$categoria = $_POST['msg_categoria'];	
	$titulo = $_POST['msg_titulo'];
	$mensagem = $_POST['msg_texto'];
	$situacao = $_POST['msg_situacao'];		
	$autor = $_POST['msg_cadastrador'];
	$arquivo = $_FILES['msg_foto']['name'];
	$diretorio = "acervo/";
	
	// Pasta onde o arquivo vai ser salvo
	$_UP['pasta'] = 'acervo/';
	 
	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 10; // 10Mb
	 
	// Array com as extensões permitidas
	$_UP['extensoes'] = array('jpeg', 'jpg', 'pjpeg', 'png');
	 
	// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
	$_UP['renomeia'] = false;
	 
	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
	 
	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['msg_foto']['error'] != 0) {
	die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['msg_foto']['error']]);
	exit; // Para a execução do script
	}
	 
	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	 
	// Faz a verificação da extensão do arquivo
		 
	// Faz a verificação do tamanho do arquivo
	else if ($_UP['tamanho'] < $_FILES['msg_foto']['size']) {
	echo "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
	}
	 
	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	else {
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .ppsx
	$nome_final = time().'.jpeg';
	} else {
	// Mantém o nome original do arquivo
	$nome_final = $_FILES['msg_foto']['name'];
	}
	 
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	
	if (move_uploaded_file($_FILES['msg_foto']['tmp_name'], $diretorio.$nome_final)) {		
	
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	$host ="mysql.disseminando.com";
	$banco ="disseminando";
	$usu ="disseminando";
	$pass ="a2b4m9";
	$con02 =mysql_connect($host,$usu,$pass) or die(mysql_error());
	mysql_select_db($banco,$con02) or die(mysql_error()); 
	
	$sql_code= "INSERT INTO mensagem (msg_id, msg_data, msg_categoria, msg_titulo, msg_texto, msg_situacao, msg_foto, msg_diretorio, msg_cadastrador) 
	VALUES (null, '$data', '$categoria', '$titulo', '$mensagem', '$situacao', '$nome_final', '$diretorio', '$autor')";
	
	if(mysql_query($sql_code))
	
        $msg = "Arquivo enviado com sucesso !";		

	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	   $msg = "Falha ao enviar arquivo.";
	}
	 
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
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/>
<!-- change skin color -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head><body>
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
        <script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=204"></script> 
      </div>
    </div>
    <!-- end sidebar --> 
    
    <!-- MAIN CONTENT -->
    <div class="c9">
      <h1 class="maintitle space-top"> <span>Quadro Geral</span> </h1>
      <br />
              <strong><font color="#000099"><?php if($msg != false) echo $msg;?></font></strong>
              <br />
    </div>
    <!-- end main content --> 
    <!-- end main content --> 
  </div>
</div>
<!-- end grid --> 

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