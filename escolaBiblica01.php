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

mysql_select_db($database_con01, $con01);
$query_ls_msgebd = "SELECT msg_data, msg_categoria, msg_titulo, msg_texto, msg_situacao, msg_foto, msg_diretorio, msg_cadastrador FROM mensagem WHERE msg_categoria=2 ORDER BY msg_data DESC";
$ls_msgebd = mysql_query($query_ls_msgebd, $con01) or die(mysql_error());
$row_ls_msgebd = mysql_fetch_assoc($ls_msgebd);
$totalRows_ls_msgebd = mysql_num_rows($ls_msgebd);mysql_select_db($database_con01, $con01);
$query_ls_msgebd = "SELECT msg_id, msg_data, msg_categoria, msg_titulo, msg_texto, msg_situacao, msg_foto, msg_diretorio, msg_cadastrador FROM mensagem WHERE msg_categoria = 2 ORDER BY msg_data DESC";
$ls_msgebd = mysql_query($query_ls_msgebd, $con01) or die(mysql_error());
$row_ls_msgebd = mysql_fetch_assoc($ls_msgebd);
$totalRows_ls_msgebd = mysql_num_rows($ls_msgebd);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Disseminando Cristo</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!-- TOP LOGO & MENU
================================================== -->
<div class="boxedtheme">
	<?php include('util/menu01.html');?>
    <br>
    <br>
</div>
<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">Escola Biblica</h1>
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
			<!-- SIDEBAR -->	
			<div class="c3">

			</div><!-- end sidebar -->			
			<div class="c9">
				<br>
                <br>
                <!-- ANUNCIO 02 ================================================== -->
                <div class="container-fluid">
                <?php include('util/anuncio03.html');?>
                </div>
                <br>		
				<div id="google_translate_element"></div><script type="text/javascript">
				function googleTranslateElementInit() {
				  new google.translate.TranslateElement({pageLanguage: 'pt', multilanguagePage: true}, 'google_translate_element');
				}
				</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				<br>
				<div class="table-responsive">        
                  <table class="table">
                    <thead>
                      <tr>
                        <th>&nbsp;</th>
                        <th><center>Titulo</center></th>
                        <th><center>Autor</center></th>
                      </tr>
                    </thead>
                    <?php do { ?>
                    <tbody>
                      <tr>
                        <td><center><?php
                          echo '<img src="'.$row_ls_msgebd['msg_diretorio'].$row_ls_msgebd['msg_foto'].'"width="150" alt="350"</>';
			                ?></center>
                        </td>
                        <td width="50%"><strong><a href="escolaBiblica02.php?msg_id=<?php echo $row_ls_msgebd['msg_id']; ?>"><?php echo $row_ls_msgebd['msg_titulo']; ?></a></strong>                       </td>
                        <td><strong><?php echo $row_ls_msgebd['msg_cadastrador']; ?></strong></td>
                      </tr>
                    </tbody>
                     <?php } while ($row_ls_msgebd = mysql_fetch_assoc($ls_msgebd)); ?>
                  </table>
                   
              </div>
          </div>
	</div><!-- end main content -->			
</div>
<!-- Divulgacao de video -->
<?php include('util/ebdVideos.php');?>			
<!-- FOOTER
================================================== -->
<?php include('util/rodape.html');?>
<!-- JAVASCRIPTS
================================================== -->
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