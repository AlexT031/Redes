<?php
// Conexión a la base de datos SQLite
function getDBConnection() {
    $db = new PDO('sqlite:supermercado.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Crear las tablas si no existen
    $db->exec("
        CREATE TABLE IF NOT EXISTS productos (
            id_producto INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT,
            codigo TEXT,
            tipo TEXT,
            id_marca INTEGER,
            id_local INTEGER,
            archivo_pdf BLOB
        );
        
        CREATE TABLE IF NOT EXISTS marcas (
            id_marca INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT
        );
        
        CREATE TABLE IF NOT EXISTS locales (
            id_local INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT
        );
        
        CREATE TABLE IF NOT EXISTS productos_locales_marcas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            id_producto INTEGER,
            id_marca INTEGER,
            id_local INTEGER,
            FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
            FOREIGN KEY (id_marca) REFERENCES marcas(id_marca),
            FOREIGN KEY (id_local) REFERENCES locales(id_local)
        );
    ");
    return $db;
}
?>
