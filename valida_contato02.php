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
				<li class="active"><a href="index.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
				<li><a href="#">Menu</a>
				<ul style="display: none;">
					<li><a href="projetoAna.php">ANA</a></li>										
					<li><a href="biblia01.php">Bíblia</a></li>
					<li><a href="curriculo_login.php">Curriculo</a></li>
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
				<h1 class="titlehead">Contato</h1>
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
				<br>
				<div id="google_translate_element"></div><script type="text/javascript">
					function googleTranslateElementInit() {
					  new google.translate.TranslateElement({pageLanguage: 'pt', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-72548584-1'}, 'google_translate_element');
					}
					</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				<br>
                <div class="pgContato">
                   <div class="contato">
                      <div class="formContato">
                         <?php
							if (isset($_POST['BTEnvia'])) {	
								//Variaveis de POST, Alterar somente se necessário 
								//====================================================
								$nome = $_POST['nome'];
								$email = $_POST['email'];
								$telefone = $_POST['tel']; 
								$mensagem = $_POST['conteudo'];
								//====================================================
								
								//REMETENTE --> ESTE EMAIL TEM QUE SER VALIDO DO DOMINIO
								//==================================================== 
								$email_remetente = "disseminando@disseminando.com"; // deve ser uma conta de email do seu dominio 
								//====================================================
								
								//Configurações do email, ajustar conforme necessidade
								//==================================================== 
								$email_destinatario = "atendimento.disseminando@gmail.com"; // pode ser qualquer email que receberá as mensagens
								$email_reply = "$email"; 
								$email_assunto = "Contato Disseminando"; // Este será o assunto da mensagem
								//====================================================
								
								//Monta o Corpo da Mensagem
								//====================================================
								$email_conteudo = "Nome = $nome \n"; 
								$email_conteudo .= "Email = $email \n";
								$email_conteudo .= "Telefone = $telefone \n"; 
								$email_conteudo .= "Mensagem = $mensagem \n"; 
								//====================================================
								
								//Seta os Headers (Alterar somente caso necessario) 
								//==================================================== 
								$email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email_reply", "Return-Path: $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
								//====================================================
								
								//Enviando o email 
								//==================================================== 
								if (mail ($email_destinatario, $email_assunto, nl2br($email_conteudo), $email_headers)){ 
												echo "</b>E-Mail enviado com sucesso!</b>"; 
												} 
										else{ 
												echo "</b>Falha no envio do E-Mail!</b>"; } 
								//====================================================
							} 
							?>
                      </div>
                   </div>
                    </div>
                </div>
			<div class="c3">
				<h2 class="title"><i class="icon-link"></i> Parceiro</h2>
				<hr class="footerstress">
                <br />
				<script language="JavaScript1.1" type="text/javascript" src="http://www.afiliados.posthaus.com.br/get_banner.jsp?mkt=PH6856&bann=205"></script>				
			</div>
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