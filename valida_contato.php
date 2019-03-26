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
<br>
<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">Sua mensagem é muito importante.</h1>
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
				<span><i class="icon-envelope-alt"></i> Fale Conosco</span>
				</h1>
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

<!-- FOOTER ================================================== -->
<?php include('util/rodape.html');?>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js'></script>
<script src="js/index.js"></script>
<script src="./js/modernizr-latest.js"></script>
<script src="./js/common.js"></script>
<script src="./js/jquery.cslider.js"></script>
<script src="./js/jquery.cycle.js"></script>
<script src="./js/jquery.carouFredSel-6.0.3-packed.js"></script>
<script src="./js/jquery.tweet.js"></script>
<script type="text/javascript">
$(window).load(function(){			
			$('#recent-projects').carouFredSel({
				responsive: true,
				width: '100%',
				auto: true,
				circular	: true,
				infinite	: false,
				prev : {
					button		: "#car_prev",
					key			: "left",
						},
				next : {
					button		: "#car_next",
					key			: "right",
							},
				swipe: {
					onMouse: true,
					onTouch: true
					},
				scroll : 2000,
				items: {
					visible: {
						min: 4,
						max: 4
					}
				}
			});
		});	
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("img.imgOpa").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
    });
  });
</script>
</body>
</html>
