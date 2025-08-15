<?php
// Connect to your MySQL DB that Laravel uses
$pdo = new PDO('mysql:host=127.0.0.1;dbname=eventticket;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
function is_logged_in(){ return isset($_SESSION['admin_id']); }
function require_login(){ if(!is_logged_in()){ header('Location: /admin/login.php'); exit; } }
