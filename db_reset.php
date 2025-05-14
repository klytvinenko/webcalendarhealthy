<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Migration;

session_start();

Migration::reset();
unset($_SESSION['user']);

echo "DB reseted";
echo "<br>";
echo "migration: ". isset($_SESSION['migration'])?"true":"false";
echo "<a href='index.php'>Go to main page</a>";