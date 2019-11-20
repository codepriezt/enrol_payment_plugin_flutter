<?php

$user = $_POST['user'];
$decoded = json_decode($user , true);

var_dump($decoded);


?>