<?php
require_once __DIR__ . '/lib/Database.php';

// Databaseのインスタンスを生成
$db = new Database();

$result = $db->findAllUser();
var_dump($result);

$result = $db->findAllUser();
var_dump($result);

$result = $db->addUser('test');
var_dump($result);

$result = $db->findAllUser();
var_dump($result);

