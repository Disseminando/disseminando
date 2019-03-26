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
<p align="center">
    <style>audio::-webkit-media-controls-timeline { display:none;}</style>
    <audio autoplay controls="controls" src="https://s33.maxcast.com.br:8290/live"></audio>
</p>
<div class="c12">
    <br>
    <br>
    <div id="google_translate_element"></div><script type="text/javascript">
        function googleTranslateElementInit() {
          new google.translate.TranslateElement({pageLanguage: 'pt', multilanguagePage: true}, 'google_translate_element');
        }
        </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <br>
		<h1 class="maintitle "><span>Mensagens Recentes</span></h1>
		<?php do { ?>				
			<div class="boxfourcolumns fw">
				<div class="container">						
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
		<?php } while ($row_ls_msgebd = mysql_fetch_assoc($ls_msgebd)); ?>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
mysql_free_result($ls_msgebd);
?>