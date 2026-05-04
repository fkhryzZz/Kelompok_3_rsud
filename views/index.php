<?php
require_once '../core/Functions.php';
require_once '../app/config/database.php';
require_once '../core/Router.php';

$baseUrl = "kelompok_3_rsud";

$database = new Database();
$dbConn = $database->getConnection();

// Ambil URL dari .htaccess
$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');

// Panggil daftar routes kita
require_once '../app/routes.php';

// Jalankan Router
Router::run($url, $dbConn);