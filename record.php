<?php
define('NO_DEBUG_DISPLAY', true);

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG ;


$decoded = file_get_contents("php://input");



$enrolflutter = new stdClass();

$enrolflutter->auth_json = json_encode($decoded);
$enrolflutter->timeupdated = time();



$ret1 = $DB->insert_record("enrol_flutter", $enrolflutter, true);

echo $ret1;

die;

// echo '<script type="text/javascript">
//      window.location.href="'.$CFG->wwwroot.'/enrol/flutter/update.php?id='.$ret1.'";
//      </script>';

// die;



?>