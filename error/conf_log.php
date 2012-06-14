<?php
$SERVER_LOG = "localhost";
$USER_LOG = "root";
$PASS_LOG = "root";
$BDD_LOG = "urbantraps";

$connectDBLOG = mysql_connect($SERVER_LOG, $USER_LOG, $PASS_LOG);
mysql_select_db($BDD_LOG, $connectDBLOG);
