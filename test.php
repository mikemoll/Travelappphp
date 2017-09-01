<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

echo '<pre>';
var_dump($server, $username, $password, $db);

$conn = new mysqli($server, $username, $password, $db);


$res = $conn->query('insert into eventtype(description) values (\'aaa\');');

var_dump($res);

$res = $conn->query('select * from eventtype');

$rows = $res->fetch_all();

var_dump($rows);
