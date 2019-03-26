<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_con01 = "mysql.disseminando.com";
$database_con01 = "disseminando";
$username_con01 = "disseminando";
$password_con01 = "a2b4m9";
$con01 = mysql_pconnect($hostname_con01, $username_con01, $password_con01) or trigger_error(mysql_error(),E_USER_ERROR); 
?>