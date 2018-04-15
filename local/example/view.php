<?php

require_once('../../config.php');
global $PAGE, $OUTPUT;

$PAGE->set_url($CFG->wwwroot.'/local/example/view.php');
$PAGE->set_context(context_system::instance());

echo $OUTPUT->header();

echo 'hola mundo';

echo $OUTPUT->footer();