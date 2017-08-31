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
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/slider.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css'>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
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
<script type="text/javascript" src="js/funcs.js"></script>
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<?php include('util/menu01.html');?>
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
					<a target="_blank" href="https://www.amazon.com.br/?&_encoding=UTF8&tag=disseminando-20&linkCode=ur2&linkId=f9bc36550781ecaa11af5ddd2bad7c79&camp=1789&creative=9325"><img src="images/amazon01.jpg"></img></a>
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
                    <a href="http://rede.natura.net/espaco/disseminando" target="_blank"><img src="images/natura03.jpg" alt="Natura Bem Estar" title="Natura Bem Estar"></img></a>
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
		<!--CAIXA DE PESQUISA-->
		<div class="c12 space-top">
			<h1 class="maintitle "><span>PESQUISAR</span></h1>
        </div>		
		<div class="container">                			
			<input type="text" id="pesquisar" placeholder="Informe o Titulo...." onkeyup="pesquisar(this.value)">
			<div id="resultado"></div>
			<br /><br />
			<font size="3" align="justify" color="blue"><div id="conteudo"></div></font> 
		</div>		
		
	</div>
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
				<a href="http://rede.natura.net/espaco/disseminando" target="_blank"><img src="images/natura01.jpg" class="logo" alt="Natura Bem Estar" title="Revenda Natura Em Breve"></a>
				<p class="bottomlink">
					<a href="http://rede.natura.net/espaco/disseminando" target="_blank" class="neutralbutton"><i class="icon-link"></i></a>
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
			<span>DESTAQUES</span>
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
						<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=BR&source=ac&ref=tf_til&ad_type=product_link&tracking_id=disseminando-20&marketplace=amazon&region=BR&placement=B0134QNNK0&asins=B0134QNNK0&linkId=e3e8113220968e1f58b93d51fad1999d&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff">
    </iframe>
					     </div>						
					</div>
					</li>
					<!--featured-projects 2-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
						<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=BR&source=ac&ref=tf_til&ad_type=product_link&tracking_id=disseminando-20&marketplace=amazon&region=BR&placement=8535928812&asins=8535928812&linkId=7f18838823ecbf5b56b8d3d1bcbfb238&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff">
    </iframe>
                        </div>						
					</div>
					</li>
					<!--featured-projects 3-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
						<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=BR&source=ac&ref=tf_til&ad_type=product_link&tracking_id=disseminando-20&marketplace=amazon&region=BR&placement=8000003635&asins=8000003635&linkId=99d0592d2fbae39aa6498df496b5aaca&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff">
    </iframe>
						</div>						
					</div>
					</li>
					<!--featured-projects 4-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=BR&source=ac&ref=tf_til&ad_type=product_link&tracking_id=disseminando-20&marketplace=amazon&region=BR&placement=8538303112&asins=8538303112&linkId=d127961a89418f85cfe66b9c432ae15b&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff">
    </iframe>
						</div>						
					</div>
					</li>
					<!--featured-projects 5-->
					<li>
					<div class="featured-projects">
						<div class="featured-projects-image">
<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=BR&source=ac&ref=tf_til&ad_type=product_link&tracking_id=disseminando-20&marketplace=amazon&region=BR&placement=B06Y1GT6CQ&asins=B06Y1GT6CQ&linkId=c20bd274ebeb209779909a0a18fedcd9&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff">
    </iframe>
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
<!--SLIDER EVANGELISMO -->
<?php include('videos.html');?>
<!--SLIDER EVANGELISMO -->
<!-- FOOTER ================================================== -->
<?php include('util/rodape.html');?>
<!-- FOOTER ================================================== -->
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
<?php
mysql_free_result($ls_msgebd);
?>