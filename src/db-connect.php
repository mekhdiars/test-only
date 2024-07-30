<?php

$userDb = 'root';
$passwordDb = 'root';
$db = 'testing';
$host = 'localhost';
$port = 8889;

$dsn = "mysql:host={$host};dbname={$db};port={$port}";
$pdo = new PDO($dsn, $userDb, $passwordDb);
