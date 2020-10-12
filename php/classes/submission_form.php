<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class mod_php_submission_form extends moodleform
{
function definition()
{
    global $CFG;
$mform = $this->_form;
$current = $this->_customdata['current'];

$mform->addElement('header', 'general', get_string('submission', 'workshop'));
$mform->addElement('text', 'title', get_string('submissiontitle', 'workshop'));
$mform->setType('title', PARAM_TEXT);
$mform->addRule('title', null, 'required', null, 'client');
$choices = array('text', 'file');
$default = 'text';
$mform->addElement('select', 'format_choice', "Choose format", $choices);
$mform->setDefault('format_choice', $default);
$mform->setType('format_choice', PARAM_ALPHA);
$mform->addElement('textarea', 'content_editor', "Paste your code", 'rows="2\0" cols="70"');
$mform->setType('content_editor', PARAM_RAW);
$mform->disabledIf('content_editor', 'format_choice', 'noteq', '0');
$mform->addElement('static', 'filemanagerinfo', "Instead of pasting the code, you can choose ".
"'file' format and attach a file below.");
$mform->addElement('filemanager', 'attachment_filemanager', "Upload file here:");
$mform->disabledIf('attachment_filemanager', 'format_choice', 'noteq', '1');
$mform->addElement('hidden', 'id', $current->id);
$mform->setType('id', PARAM_INT);
//$mform->addElement('hidden', 'cmid', $current->cmid);
//$mform->setType('cmid', PARAM_INT);
$this->add_action_buttons();
$this->set_data($current);
}
}