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
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "meu_curriculo.php";
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
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style> 
select {
    width: 100%;
    padding: 16px 20px;
    border: none;
    border-radius: 4px;
    background-color: #f1f1f1;
}
textarea {
    width: 100%;
    height: 150px;
    padding: 12px 20px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #f8f8f8;
    font-size: 16px;
    resize: none;
}
</style>
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
	<div class="row space-bot">
		<!--Logo-->
		<div class="c4">
			<a href="#">
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
					<li><a href="projetoAna.php">ANA</a></li>										
					<li><a href="biblia01.php">Bíblia</a></li>
                    <li><a href="<?php echo $logoutAction ?>">Fechar</a></li>
				</ul>
				</li>							
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
				<h1 class="titlehead">Meu Curriculo</h1>
			</div>			
		</div>
	</div>
</div>
<!-- CONTENT
================================================== -->
<div class="grid">		
		
		<div class="row space-top">
			<!-- CONTACT FORM -->
		  <div class="c8 space-top">
				<h1 class="maintitle">
				<span><i class="icon-envelope-alt"></i> CADASTRO</span>
				</h1>				 
          </div>	
    </div>
    <div class="container">
        <form name="curriculo" method="post" class="form-horizontal" action="valida_curriculo.php">            
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Nome:</label>
              <div class="col-sm-10">          
                <input name="cur_nome" type="text" class="form-control" id="cur_nome" maxlength="100" placeholder="Informe seu nome">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Nacionalidade:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_nacionalidade" name="cur_nacionalidade" value="Brasileiro" readonly="readonly">
              </div>
            </div>              
          <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Estado Civil:</label>
            <div class="col-sm-10">    
              <select id="cur_estado_civil" name="cur_estado_civil">
                <option value="1">Solteiro</option>
                <option value="2">Casado</option>
                <option value="3">Divorciado</option>
                <option value="4">Viuvo</option>
              </select>
            </div>
          </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Idade:</label>
              <div class="col-sm-10">          
                <input name="cur_idade" type="text" class="form-control" id="cur_idade" maxlength="2" placeholder="Informe sua Idade">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Endereço:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_end" name="cur_end"  placeholder="Informe seu Endereço" maxlength="100">
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Bairro:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_bairro" name="cur_bairro" placeholder="Informe o Bairro" maxlength="80">
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Cidade:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_cidade" name="cur_cidade" placeholder="Informe a Cidade" maxlength="80">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Estado:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_estado" name="cur_estado" placeholder="Informe o Estado" maxlength="40">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Telefone:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_fone" name="cur_fone" placeholder="Informe o Telefone" maxlength="25">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Email:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_email" name="cur_email" placeholder="Informe a Cidade" maxlength="100">
              </div>
            </div>        
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Objetivo:</label>
              <div class="col-sm-10">          
                <textarea id="cur_objetivo" name="cur_objetivo" placeholder="Descreva seu objetivo"></textarea>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Formação:</label>
              <div class="col-sm-10">          
                <textarea id="cur_formacao" name="cur_formacao" placeholder="Descreva sua formação"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Experiência:</label>
              <div class="col-sm-10">          
                <textarea id="cur_experiencia" name="cur_experiencia" placeholder="Descreva sua experiencia profissional"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Qualificação:</label>
              <div class="col-sm-10">          
                <textarea id="cur_qualificacao" name="cur_qualificacao" placeholder="Descreva sua qualificacao profissional"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Outras:</label>
              <div class="col-sm-10">          
                <textarea id="cur_outras" name="cur_outras" placeholder="Espaço para observacao...."></textarea>
              </div>
            </div>
           <div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Usuário:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="cur_cadastrador" name="cur_cadastrador" value="<?php  echo $_SESSION['MM_Username'];?>" size="20" maxlength="40" readonly="readonly">
              </div>
            </div>                  
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Cadastrar</button>
              </div>
            </div>
        </form> 
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

<!-- contact form -->
<script src="js/contact.js"></script>

</body>
</html>