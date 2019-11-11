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
 * Adds new instance of enrol_payumoney to specified course or edits current instance.
 * 
 * @package    enrol_payumoney
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
/**
 * Sets up moodle edit form class methods.
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_payumoney_edit_form extends moodleform {
    /**
     * Sets up moodle form.
     * @return void
     */
    public function definition() {
        global $CFG;

        $moddleform = $this->_form;

        list($instance , $plugin  , $context) = $this->_customdata;

        $moddleform->addElement('header' , 'header' , get_string('pluginname' , 'enrol_payumoney'));

        $moddleform->addText('text', 'name',get_string('custominstancename' , 'enrol'));

        $moddleform->setType('name' , PARAM_TEXT);

        $options = array(ENROL_INSTANCE_ENABLED => get_string('yes') , ENROL_INSTANCE_DISABLED => get_string('no'));

        $moddleform->addElement('select' , 'status' ,get_string('status' ,'enrol_payumoney') , $options);

        $moddleform->setDefault('status',$plugin->get_config('status'));

        $moddleform->addElement('text' , 'cost' , get_string('cost' , 'enrol_payumoney'), array('size' => 4));

        $moddleform->setDefault('cost' , format_float($plugin->get_config('cost') , 2 , true));

        $currencies = $plugin->get_currencies();

        $moddleform->addElement('select' , 'currency' , get_string('currency' , 'enrol_payumoney') , $currencies);

        $moddleform->setDefault('currency' , $plugin->get_config('currency'));

        if($instance->id)
        {
            $roles = get_default_enrol_roles($context , $instance->roleid);
        }else{
            $roles = get_default_enrol_roles($context , $plugin->get_config('roleid'));
        }

        $moddleform->addElement('select', 'roleid', get_string('assignrole', 'enrol_payumoney'), $roles);

        $moddleform->setDefault('roleid', $plugin->get_config('roleid'));

        $moddleform->addElement('duration', 'enrolperiod', get_string('enrolperiod', 'enrol_payumoney'),
                           array('optional' => true, 'defaultunit' => 86400));
        $moddleform->setDefault('enrolperiod', $plugin->get_config('enrolperiod'));
        $moddleform->addHelpButton('enrolperiod', 'enrolperiod', 'enrol_payumoney');

        $moddleform->addElement('date_time_selector', 'enrolstartdate', get_string('enrolstartdate', 'enrol_payumoney'),
                           array('optional' => true));
        $moddleform->setDefault('enrolstartdate', 0);
        $moddleform->addHelpButton('enrolstartdate', 'enrolstartdate', 'enrol_payumoney');

        $moddleform->addElement('date_time_selector', 'enrolenddate', get_string('enrolenddate', 'enrol_payumoney'),
                           array('optional' => true));
        $moddleform->setDefault('enrolenddate', 0);
        $moddleform->addHelpButton('enrolenddate', 'enrolenddate', 'enrol_payumoney');

        $moddleform->addElement('hidden', 'id');
        $moddleform->setType('id', PARAM_INT);

        $moddleform->addElement('hidden', 'courseid');
        $moddleform->setType('courseid', PARAM_INT);

        if ($CFG->version >= '2013111801') {
            if (enrol_accessing_via_instance($instance)) {
                $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'),
                                   get_string('instanceeditselfwarningtext', 'core_enrol'));
            }
        }

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }
    /**
     * Sets up moodle form validation.
     * @param stdClass $data
     * @param stdClass $files
     * @return $error error list
     */
    public function validation($data, $files) {
        global $DB, $CFG;
        $errors = parent::validation($data, $files);

        list($instance, $plugin, $context) = $this->_customdata;

        if (!empty($data['enrolenddate']) and $data['enrolenddate'] < $data['enrolstartdate']) {
            $errors['enrolenddate'] = get_string('enrolenddaterror', 'enrol_payumoney');
        }

        $cost = str_replace(get_string('decsep', 'langconfig'), '.', $data['cost']);
        if (!is_numeric($cost)) {
            $errors['cost'] = get_string('costerror', 'enrol_payumoney');
        }

        return $errors;
    }
    

}