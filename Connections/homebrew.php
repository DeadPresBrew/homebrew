<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_homebrew = "localhost";
$database_homebrew = "rtravers_brews";
$username_homebrew = "root";
$password_homebrew = "beer4a11";
$homebrew = mysql_pconnect($hostname_homebrew, $username_homebrew, $password_homebrew) or trigger_error(mysql_error(),E_USER_ERROR); 
?>