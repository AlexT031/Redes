<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function getDBConnection() {
    $db = new PDO('sqlite:supermercado.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>
