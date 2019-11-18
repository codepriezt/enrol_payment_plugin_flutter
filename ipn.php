<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Listens for Instant Payment Notification from PayUMoney.com
 *
 * This script waits for Payment notification from PayUMoney.com, 
 * then it sets up the enrolment for that user.
 *
 * @package    enrol_payumoney
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Disable moodle specific debug messages and any errors in output,
// comment out when debugging or better look into error log!
define('NO_DEBUG_DISPLAY', true);

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir.'/eventslib.php');
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG ;

if (empty($_POST) or !empty($_GET)) {
    print_error("Sorry, you can not use the script that way."); die;
}

// $enrolpayumoney = json_encode($_POST);


//print_r($enrolpayumoney);

$enrolpayumoney = new stdClass();
$record = $_POST['data'];
var_dump($record);
$enrolpayumoney->auth_json= json_encode($record);
$enrolpayumoney->timeupdated = time();


$ret1 = $DB->insert_record("enrol_payumoney_nigeria", $enrolpayumoney, true);


echo '<script type="text/javascript">
     window.location.href="'.$CFG->wwwroot.'/enrol/payumoney/update.php?id='.$ret1.'";
     </script>';
die;
