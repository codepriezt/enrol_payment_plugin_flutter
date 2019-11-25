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
//define('NO_DEBUG_DISPLAY', true);

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir.'/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG;

$id = required_param('id', PARAM_INT);


$response = $DB->get_record('enrol_flutter', array('id' => $id));

print_r($response);


// $cct= json_decode($response->auth_json , true);

// $cct = json_decode($responsearray , true);


$txref = $cct["txref"];
$amount = $cct["amount"];
$email = $cct["email"];
$courseid = $cct["courseid"];
$userid = $cct["userid"];
$status = $cct["status"];
$contextid= $cct["contextid"];
$instanceid = $cct["instanceid"];





if (! $user = $DB->get_record("user", array("id" => $userid))) {
    print_error("Not a valid user id"); die;
}

if (! $course = $DB->get_record("course", array("id"=> $courseid))) {
    print_error("Not a valid course id"); die;
}

if (! $context = context_course::instance($courseid, IGNORE_MISSING)) {
    print_error("Not a valid context id"); die;
}

if (! $plugininstance = $DB->get_record("enrol", array("id" => $instanceid))) {
    print_error("Not a valid instance id"); die;
}


$enrolflutter = $userenrolments = $roleassignments = new stdClass();

$enrolflutter->id = $id;
$enrolflutter->courseid = $courseid;
$enrolflutter->userid = $userid;
$enrolflutter->instanceid = $instanceid;
$enrolflutter->contextid = $contextid;
$enrolflutter->amount = $amount;
$enrolflutter->email = $email;
$enrolflutter->txref = $txref;

if ($status == "successful") {
    $enrolflutter->status = 'Approved';
    
    $PAGE->set_context($context);
    $coursecontext = context_course::instance($course->id, IGNORE_MISSING);

    if ($users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC',
                                         '', '', '', '', false, true)) {
        $users = sort_by_roleassignment_authority($users, $context);
        $teacher = array_shift($users);
    } else {
        $teacher = false;
    }
}
    $plugin = enrol_get_plugin('flutter');

if ($status == "pending") {
    $enrolflutter->status = 'Held for Review';
}
if ($status == "failure") {
    $enrolflutter->status = 'Declined due to some Error';
}




$enrolflutter->timeupdated = time();

// /* Inserting value to enrol_flutter table */
$ret1 = $DB->update_record("enrol_flutter", $enrolflutter, false);




if ($status == "successful") {
    /* Inserting value to user_enrolments table */

    $userenrolments->status = 0;
    $userenrolments->enrolid = $instanceid;
    $userenrolments->userid = $userid;
    $userenrolments->timestart = time();
    $userenrolments->timeend = time();
    $userenrolments->modifierid = 2;
    $userenrolments->timecreated = time();
    $userenrolments->timemodified = time();
    $ret2 = $DB->insert_record("user_enrolments", $userenrolments, false);

    
    /* Inserting value to role_assignments table */
    $roleassignments->roleid = 5;
    $roleassignments->contextid = $contextid;
    $roleassignments->userid = $userid;
    $roleassignments->timemodified = time();
    $roleassignments->modifierid = 2;
    $roleassignments->component = '';
    $roleassignments->itemid = 0;
    $roleassignments->sortorder = 0;
    $ret3 = $DB->insert_record('role_assignments', $roleassignments, false);
   
}

echo '<script type="text/javascript">
     window.location.href="'.$CFG->wwwroot.'/enrol/flutter/return.php?id='.$courseid.'";
     </script>';
die;



