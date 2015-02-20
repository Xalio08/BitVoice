<?php

//Run this file one to init the database
//Comes from the BlockChain API example, I just modified the structure of the table
//Needs write permissions in current directory to create the database file

include 'include.php';

$result = mysql_connect($mysql_host, $mysql_username, $mysql_password);
if (!$result) {
    die(__LINE__ . ' Invalid connect: ' . mysql_error());
}

$result = mysql_query('CREATE DATABASE IF NOT EXISTS ' . $mysql_database);

if (!$result) {
    die(__LINE__ . ' Invalid query: ' . mysql_error());
}

mysql_select_db($mysql_database) or die( "Unable to select database. Run setup first.");

$result = mysql_query('CREATE TABLE IF NOT EXISTS invoices (invoice_id VARCHAR(50), total_amount DOUBLE, left_amount DOUBLE, destination_address VARCHAR(50), state VARCHAR(50), expiration_date DATETIME, PRIMARY KEY (invoice_id))');

if (!$result) {
    die(__LINE__ . ' Invalid query: ' . mysql_error());
}

?>