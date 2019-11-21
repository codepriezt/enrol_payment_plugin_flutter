<?php

$decoded = file_get_contents("php://input");

$object  = json_decode($decoded);

var_dump($object);



?>