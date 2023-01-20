<?php

$host = "localhost";
$dbname = "sphunter_test";
// $user = "test";
// $password = "test";
$user = "sphunter_test";
$password = "RsDNTd~0qR";

$config = "host=$host dbname=$dbname user=$user password=$password";
printf($config);

$dbconn = pg_connect($config) or die('Could not connect: ' . pg_last_error());

$query = 'SELECT * FROM projects_card;';
$result = pg_query($query) or die('Error message: ' . pg_last_error());

while ($row = pg_fetch_row($result)) {
    var_dump($row);
}

pg_free_result($result);
pg_close($dbconn);