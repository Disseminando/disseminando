<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_con01 = "localhost";
$database_con01 = "disseminando";
$username_con01 = "root";
$password_con01 = "";
$con01 = mysql_pconnect($hostname_con01, $username_con01, $password_con01) or trigger_error(mysql_error(),E_USER_ERROR); 
?>