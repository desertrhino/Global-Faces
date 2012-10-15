<?php

# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

$hostname_connect = $_ENV{'DATABASE_SERVER'};

$database_connect = "db130692_globalfaces";

$username_connect = "db130692_global";

$password_connect = "C8o3ol8s";

$connect = mysql_pconnect($hostname_connect, $username_connect, $password_connect) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database_connect, $connect) or die(mysql_error());

$Sitewww = "http://www.globalfaces.org";

?>