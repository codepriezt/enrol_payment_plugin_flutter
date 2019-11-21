<?php
define('NO_DEBUG_DISPLAY', false);

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG ;


$decoded = file_get_contents("php://input");

$enrolpayumoney = new stdClass();

$enrolpayumoney->auth_json = json_encode($decoded);
$enrolpayumoney->timeupdated = time();


$ret1 = $DB->insert_record("enrol_flutter", $enrolpayumoney, true);

print_r($ret1);



print_r($enrolpayumoney);





?>