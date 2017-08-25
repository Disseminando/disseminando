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

$maxRows_ls_msgebd = 4;
$pageNum_ls_msgebd = 0;
if (isset($_GET['pageNum_ls_msgebd'])) {
  $pageNum_ls_msgebd = $_GET['pageNum_ls_msgebd'];
}
$startRow_ls_msgebd = $pageNum_ls_msgebd * $maxRows_ls_msgebd;

mysql_select_db($database_con01, $con01);
$query_ls_msgebd = "SELECT msg_id, msg_data, msg_categoria, msg_titulo, msg_texto, msg_situacao, msg_foto, msg_diretorio, msg_cadastrador FROM mensagem WHERE msg_categoria=1 ORDER BY msg_data DESC";
$query_limit_ls_msgebd = sprintf("%s LIMIT %d, %d", $query_ls_msgebd, $startRow_ls_msgebd, $maxRows_ls_msgebd);
$ls_msgebd = mysql_query($query_limit_ls_msgebd, $con01) or die(mysql_error());
$row_ls_msgebd = mysql_fetch_assoc($ls_msgebd);

if (isset($_GET['totalRows_ls_msgebd'])) {
  $totalRows_ls_msgebd = $_GET['totalRows_ls_msgebd'];
} else {
  $all_ls_msgebd = mysql_query($query_ls_msgebd);
  $totalRows_ls_msgebd = mysql_num_rows($all_ls_msgebd);
}
$totalPages_ls_msgebd = ceil($totalRows_ls_msgebd/$maxRows_ls_msgebd)-1;
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
				<li class="last"><a href="projetoAna.php">Ana</a></li>
				<li class="last"><a href="biblia01.php">Bíblia</a></li>
				<li class="last"><a href="contato.php">Contato</a></li>
				<li class="last"><a href="vagas01.php">Restrito</a></li>
			</ul>
			</nav>
		</div>
	</div>
</div>

	<!-- SLIDER AREA
	================================================== -->

		<?php include('util/slider_principal.html');?>



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
	<br>
	<div class="grid">
		<div class="shadowundertop">
		</div>
		<div class="row">
			<div class="c12">
				<h1 class="maintitle ">
				<span>Mensagens Recentes</span>
				</h1>
			    <?php do { ?>
				<div id="content">
					<div class="boxfourcolumns fw">
						<div class="container">
						<div class="grid">
							<?php
                                echo '<img src="'.$row_ls_msgebd['msg_diretorio'].$row_ls_msgebd['msg_foto'].'"width="150" alt="350"</>';
			                ?>
							<br>
							<strong><a href="evangelismo02.php?msg_id=<?php echo $row_ls_msgebd['msg_id']; ?>"><?php echo $row_ls_msgebd['msg_titulo']; ?></a></strong>
							<br>
							<p align="justify">
							 <?php echo mb_strimwidth($row_ls_msgebd['msg_texto'], 4, 180, "...");?>
							</p>
							</div>						
						</div>
					</div>
					<!-- box -->
				</div>
				<?php } while ($row_ls_msgebd = mysql_fetch_assoc($ls_msgebd)); ?>
			</div>
		</div>
</div>
<!-- end grid -->
<!-- SHOWCASE
================================================== -->
	<div class="row space-top">
		<div class="c12 space-top">
			<h1 class="maintitle ">
			<span>Anuncios</span>
			</h1>
		</div>
	</div>
	<div class="row space-bot">
		<div class="c12">
			<div class="list_carousel">
				<div class="carousel_nav">
					<a class="prev" id="car_prev" href="#"><span>prev</span></a>
					<a class="next" id="car_next" href="#"><span>next</span></a>
				</div>
				<div class="clearfix">
				</div>
				<ul id="recent-projects">
					<!--featured-projects 1-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
						<a href="curriculo_cadastro.php"><img src="./images/Modelo_Anuncio05.png" alt="Cadastrar Curriculo" title="Cadastrar Curriculo"></img></a>
					</div>						
					</div>
					</li>
					<!--featured-projects 2-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
                        <a target="_blank"  href="https://www.amazon.com.br/gp/product/8000003635/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=8000003635&linkCode=as2&tag=disseminando-20&linkId=1ac4876a37d335b4a28ed610fde66453"><img border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=BR&ASIN=8000003635&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL160_&tag=disseminando-20" ></a><img src="//ir-br.amazon-adsystem.com/e/ir?t=disseminando-20&l=am2&o=33&a=8000003635" width="auto" height="auto" border="0" alt="" style="border:none !important; margin:0px !important;" />						</div>						
					</div>
					</li>
					<!--featured-projects 3-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
							<a href="http://produto.mercadolivre.com.br/MLB-898592082-camiseta-evangelismo-algodo-branca-_JM"><img src="./images/Modelo_Anuncio03.png" alt="Camiseta Evangelismo" title="Camiseta Evangelismo"></a>
						</div>						
					</div>
					</li>
					<!--featured-projects 4-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
							<a href="http://produto.mercadolivre.com.br/MLB-898596714-camiseta-evangelismo-babylook-algodo-branca-_JM"><img src="./images/Modelo_Anuncio04.png" alt="Camiseta Evangelismo" title="Camiseta Evangelismo"></a>
						</div>						
					</div>
					</li>
					<!--featured-projects 5-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
							<a href="#"><img src="./images/Modelo_Anuncio01.jpg" alt="Anuncie Aqui" title="Anuncie Aqui"></a>
						</div>						
					</div>
					</li>
					<!--featured-projects 6-->					
				</ul>
				<div class="clearfix">
				</div>
			</div>
		</div>
	</div>
	
<!-- FOOTER
================================================== -->
<?php include('util/rodape.html');?>

<!-- all -->
<script src="./js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="./js/common.js"></script>

<!-- slider -->
<script src="./js/jquery.cslider.js"></script>

<!-- cycle -->
<script src="./js/jquery.cycle.js"></script>

<!-- carousel items -->
<script src="./js/jquery.carouFredSel-6.0.3-packed.js"></script>

<!-- twitter -->
<script src="./js/jquery.tweet.js"></script>

<!-- Call Showcase - change 4 from min:4 and max:4 to the number of items you want visible -->
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
<?php
mysql_free_result($ls_msgebd);
?>