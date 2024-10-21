<?php
function getDBConnection() {
    $db = new PDO('sqlite:supermercado.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>
