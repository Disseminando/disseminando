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
$query_ls_videos = "SELECT vid_id, vid_data, vid_codigo, vid_categoria, vid_situacao, vid_usuario FROM videos where vid_situacao=1 AND vid_categoria=2";
$ls_videos = mysql_query($query_ls_videos, $con01) or die(mysql_error());
$row_ls_videos = mysql_fetch_assoc($ls_videos);
$totalRows_ls_videos = mysql_num_rows($ls_videos);
?>
 		
  <div class="grid">  
    <div class="row space-bot">   
      <div class="c12">
        <hr>
        <?php do { ?> 
        <div class="c4 introbox introboxmiddle">
          <div class="introboxinner">
            <?php echo $row_ls_videos['vid_codigo']; ?>
          </div>                               
        </div>
        <?php } while ($row_ls_videos = mysql_fetch_assoc($ls_videos)); ?>
      </div>
    </div>
  </div>
<?php
mysql_free_result($ls_videos);
?>
