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
					<li><a href="projetoAna.php">ANA</a></li>										
					<li><a href="biblia01.php">Bíblia</a></li>							
				<li class="last"><a href="contato.php">Contato</a></li>				
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
				<span>CADASTRO DE USUARIO</span>
				</h1>
				  <form name="cadastro" method="post" action="cadastrar.php">
                    Nome:
                    <input name="cur_usu_nome" type="text" id="cur_usu_nome" value="" maxlength="100" /><br />
                    
                    Usuario:
                    <input name="cur_usu_login" type="text" id="cur_usu_login" value="" maxlength="20" /><br />
                    
                    Senha::                    
                    <input name="cur_usu_senha" type="password" id="cur_usu_senha" value="" maxlength="20" /><br />
                    
                    Email:                    
                    <input name="cur_usu_email" type="text" id="cur_usu_email" value="" maxlength="100" /><br />                   
					<input name="Submit" type="submit" class="button" value="Cadastrar" /> <br />                    
              </form>			
          </div><!-- end main content -->			
			<!-- SIDEBAR -->	
			<div class="c3">
				<div class="rightsidebar">
					<h1 class="maintitle space-top">
					<span>Parceiro</span>
					</h1>
					<script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=203"></script>					
				</div>
			</div><!-- end sidebar -->			
		</div>
</div><!-- end grid -->

<!-- FOOTER
================================================== -->
<?php include('util/rodape.html');?>
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