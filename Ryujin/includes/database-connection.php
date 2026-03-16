<?php
$type = 'mysql';                             // Database type, e.g. 'mysql' for MySQL, 'pgsql' for PostgreSQL, etc.
$server = 'localhost';                      //enter your database server here, e.g. 'localhost' for XAMPP and MAMP, or the server address provided by your hosting provider
$db = 'ryujin';                             //enter your database name here, e.g. 'Ryujin' for XAMPP, 'ryujin' for MAMP, or the database name provided by your hosting provider
$port = '3306';                            //port is usally 3306 for MySQL, but can be left blank if using default
$charset = 'utf8mb4';                    // UTF-8 character encoding for the database connection
$username = 'root';                     // enter your database username here, e.g. 'root' for XAMPP, 'admin' for MAMP, or the username provided by your hosting provider
$password = '';                        // enter your database password here, e.g. '' for XAMPP, 'root' for MAMP, or the password provided by your hosting provider

$options = [                                                   //Options for PDO connection
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Exceptions for errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];


$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset"; // Data Source Name
try {
    $pdo = new PDO($dsn, $username, $password, $options); // Create PDO instance
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode()); // Handle connection errors
}