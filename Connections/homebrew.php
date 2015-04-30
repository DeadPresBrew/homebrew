<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_homebrew = "";
$database_homebrew = "";
$username_homebrew = "";
$password_homebrew = "";
$homebrew = mysql_pconnect($hostname_homebrew, $username_homebrew, $password_homebrew) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
