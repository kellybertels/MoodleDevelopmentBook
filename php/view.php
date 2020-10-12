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
 * view.php entry script.
 *
 * @package   mod_php
 * @copyright 2015 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once("../../config.php");
require_once($CFG->dirroot . '/mod/assign/locallib.php');

//require_login($course, true, $cm);

require_login($courseorid = NULL, $autologinguest = true, $cm = NULL, $setwantsurltome = true, $preventredirect = false);


global $DB;
$PAGE->set_context(context_system::instance()); 
$PAGE->set_url(new moodle_url('/mod/php/view.php'));
//the code above replaces the code bellow
//$urlparams = array('id'=>$id,'name'=>$name);
$id = required_param('id', PARAM_INT);  // Course Module ID.
//$url = new moodle_url('', $urlparams);
$mform = new mod_php_submission_form();
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');
$coursecontext = context_course::instance($course->id);

//code from moodle API not book
if (empty($entry->id)) {
    $entry = new stdClass;
    $entry->id = null;
}
 
$draftitemid = file_get_submitted_draft_itemid('attachment_filemanager');



/* $templatecontext = (object)[

];
 */
if ($mform->is_cancelled()) {
    // form cancelled, redirect
    redirect(new moodle_url('view.php', array()));
    return;
    } else if (($data = $mform->get_data())) {
    // form has been submitted

    mod_php_save_submission($data);
    //25/09/2020 >> keeep working on it monday, this bit doesnt work when send the file. 
    file_save_draft_area_files($data->attachments, $context->id, 'mod_glossary', 'attachment',
    $entry->id, array('subdirs' => 0, 'maxbytes' => $maxbytes, 'maxfiles' => 50));

    } else {
    // Form has not been submitted or there was an error
    // Just display the form
    $mform->set_data(array('id' => $id));
    $mform->display();
    }
echo $OUTPUT->header();
echo $OUTPUT->notification("This is PHP assignment. Stay tuned!",'notifysuccess');
echo $OUTPUT->footer();
