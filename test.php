<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);


$res = $conn->query('insert into eventtype(description) values (\'aaa\');');

var_dump($res);

$res = $conn->query('select * from eventtype');

var_dump($res);