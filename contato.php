<!DOCTYPE HTML>
<html>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando | Sua fé sem fronteiras.</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- Change skin color here -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- scripts at the bottom of the document -->
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<?php include('util/menu01.html');?>
<br>
<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">Fale Conosco</h1>
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
				<span><i class="icon-envelope-alt"></i> Envie sua mensagem</span>
				</h1>				
                <div class="pgContato">
                   <div class="contato">
                      <div class="formContato">
                         <form id="formContato" tabindex="1" action="valida_contato.php" method="post">
                            <input id="nome" name="nome" required="" type="text" placeholder="Nome" /> 
                            <input id="email" name="email" required="" type="email" placeholder="Email" /> 
                            <input id="tel" name="tel" type="tel" placeholder="Telefone" /> 
                            <textarea id="conteudo" name="conteudo" required="" placeholder="Deixe uma mensagem"></textarea>
                            <button name="BTEnvia" class="botaoContato" type="submit">Enviar</button>
                         </form>
                      </div>
                   </div>
                    </div>
                </div>
			<div class="c3">
				<h2 class="title"><i class="icon-link"></i> Parceiro</h2>
				<hr class="footerstress">
				<script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=58"></script>			
			</div>
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

<!-- contact form -->
<script src="js/contact.js"></script>

</body>
</html>