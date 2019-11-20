<?php
require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir.'/eventslib.php');
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG ;


$enrolpayumoney = new stdClass();
$decoded = $_POST['user'];
var_dump($decoded);
// $enrolpayumoney->auth_json= json_encode($decoded);
// $enrolpayumoney->timeupdated = time();
// $ret1 = $DB->insert_record("enrol_payumoney", $enrolpayumoney, true);
var_dump($ret1);

echo $ret1;


?>