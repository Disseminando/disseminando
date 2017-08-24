<?php include("Connections/con01.php");?>
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
<link rel="stylesheet" type="text/css" href="css/slider.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script>

<!-- inicio do Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-72548584-1', 'auto');
	  ga('send', 'pageview');

	</script>
	
	<!-- class="w3-content" -->
	
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-3345109171356225",
		enable_page_level_ads: true
	  });
	</script>

</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
	<div class="row space-bot">
		<!--Logo-->
		<div class="c4">
			<a href="index.#">
			<img src="images/logo02.jpg" class="logo" alt="">
			</a>
		</div>
		<!--Menu-->
		<div class="c8">
			<nav style="margin-bottom:0;" id="topNav">
			<ul id="responsivemenu">
				<li class="active"><a href="index.php"><i class="icon-home homeicon"></i><span class="showmobile">Inicio</span></a></li>
				<li><a href="#">Menu</a>
				<ul style="display: none;">
					<li><a href="projetoAna.php">ANA</a></li>										
					<li><a href="biblia01.php">Bíblia</a></li>
					<li><a href="curriculo_login.php">Curriculo</a></li>
                    <li><a href="vagas01.php">Restrito</a></li>
				</ul>
				</li>							
				<li class="last"><a href="contato.php">Contato</a></li>
			</ul>
			</nav>
		</div>
	</div>
</div>
<div class="">
	<!-- SLIDER AREA
	================================================== -->
	<div style="height:420px;" id="da-slider" class="da-slider">
		<?php include('util/slider_principal.html');?>
	</div>
</div>
<!-- UNDER SLIDER - BLACK AREA
================================================== -->
<div class="undersliderblack">
	<div class="grid">
		<div class="row space-bot">
			<div class="c12">
				<!--Box 1-->
				<div class="c4 introbox introboxfirst">
					<div class="introboxinner">
					<img src="images/banner01.png"></img>	
					</div>
				</div>
				<!--Box 2-->
				<div class="c4 introbox introboxmiddle">
					<div class="introboxinner">
						<img src="images/banner01.png"></img>
					</div>
				</div>
				<!--Box 3-->
				<div class="c4 introbox introboxlast">
					<div class="introboxinner">
						<img src="images/natura03.jpg" alt="Natura Bem Estar" title="Natura Bem Estar"></img>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="shadowunderslider">
</div>
<!-- START content area
================================================== -->
<div class="grid">
	<div class="row space-bot">
		<!--INTRO-->
		<div class="c12">
			<div class="royalcontent">
				<!-- Criar uma area de publicação de conteudo 
                <h1 class="royalheader">Seja Bem vindo ao Disseminando !!!</h1>
                -->
			</div>			
		<!--Box 1-->
		<div class="row space-top">
		<div class="c12 space-top">
			<h1 class="maintitle ">
			<span>Categorias</span>
			</h1>
			<div id="google_translate_element"></div><script type="text/javascript">
				function googleTranslateElementInit() {
				  new google.translate.TranslateElement({pageLanguage: 'pt', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-72548584-1'}, 'google_translate_element');
				}
				</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		<br>
		<br>
		</div>		
		</div>
	</div>
		<div class="c4">
			<h2 class="title hometitlebg"><i class="icon-qrcode smallrightmargin"></i> Escola Bíblica</h2>
			<div class="noshadowbox">
				<a href="escolaBiblica01.php"><img src="images/escola	01.jpg" class="logo" alt=""></a>
				<p class="bottomlink">
					<a href="escolaBiblica01.php" class="neutralbutton"><i class="icon-link"></i></a>
				</p>				
			</div>
		</div>
		<!--Box 2-->
		<div class="c4">
			<h2 class="title hometitlebg"><i class="icon-qrcode smallrightmargin"></i> Evangelismo</h2>
			<div class="noshadowbox">
				<a href="evangelismo01.php"><img src="images/evangelismo01.png" class="logo" alt=""></a>
				<p class="bottomlink">
					<a href="evangelismo01.php" class="neutralbutton"><i class="icon-link"></i></a>
				</p>
			</div>
		</div>
		<!--Box 3-->
		<div class="c4">
			<h2 class="title hometitlebg"><i class="icon-user" style="margin-right:10px;"></i>Oportunidades</h2>
			<div class="noshadowbox">
				<a href="#"><img src="images/natura01.jpg" class="logo" alt="Natura Bem Estar" title="Revenda Natura Em Breve"></a>
				<p class="bottomlink">
					<a href="#" class="neutralbutton"><i class="icon-link"></i></a>
				</p>
			</div>
		</div>
	</div>
	<!-- SHOWCASE
	================================================== -->
	<?php include('util/anuncio02.html');?>

<!-- FOOTER
================================================== -->
<?php include('util/rodape.html');?>

<!-- Call opacity on hover images from carousel-->
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