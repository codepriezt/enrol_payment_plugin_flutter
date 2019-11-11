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
 * Strings for component 'enrol_payumoneydotcom', language 'en'.
 *
 * @package    enrol_payumoneydotcom
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'PayUMoney';
$string['pluginname_desc'] = 'The PayUMoney module allows you to set up paid courses.  If the cost for any course is zero, then students are not asked to pay for entry.  There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';
$string['Api']='PAYUMoney api current version';
$string['username'] = 'PayUMoney merchant username';
$string['password'] = 'PayUMoney merchant password';
$string['safeKey']='PAYUMoney merchant safeKey';
$sting['transactionType']='the type of transaction';
$string['merchantReference']='unique merchant identifier for transaction';
$string['supportedPaymentMethods']='list of card payment';
$string['secure3d']='this will determine if the transaction went through';
$string['demoMode']='to determine if the Api request should be handled as a demo teansaction';
$string['NotificationUrl']='Url that will determine if the  mercahnt will be notified of transactio result';
$string['returnUrl']='Url return to browser or after a customer has comleted transaction';
$string['cancelUrl']='cancel url to cancel a transaction ';
$string['checkproductionmode'] = 'Check for production mode';
$string['mailadmins'] = 'Notify admin';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['cost'] = 'Enrol cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['currency'] = 'Currency';
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during PayUMoney enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['payumoney:config'] = 'Configure PayUMoney enrol instances';
$string['payumoney:manage'] = 'Manage enrolled users';
$string['payumoney:unenrol'] = 'Unenrol users from course';
$string['payumoney:unenrolself'] = 'Unenrol self from the course';
$string['status'] = 'Allow PayUMoney enrolments';
$string['status_desc'] = 'Allow users to use PayUMoney to enrol into a course by default.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';